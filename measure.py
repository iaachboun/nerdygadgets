#!/usr/bin/python3

#
# NAME
#   measure.py - script to store sense hat measurements in SQL database
#
# SYNOPSIS
#   measure.py [-v] [-t interval]
#       -v: verbose
#       -t interval: sample every interval seconds
#
# DESCRIPTION
#   measures temperature data from the raspbery pi sense hat and
#   store data in a local SQL database
#

# import some modules
import sys
import getopt
import sense_hat
import time
import mysql.connector as mariadb
from mysql.connector import errorcode
from time import sleep
from datetime import datetime

# sensor name
Table = 'colroomtemperatures'
delay = 65
now = ''

# database connection configuration
dbconfig = {
    'user': 'ilias',
    'password': '12345',
    'host': '192.168.178.192',
    'database': 'nerdygadgets',
    'raise_on_warnings': True,
}

# parse arguments
verbose = True
interval = 10  # second

try:
    opts, args = getopt.getopt(sys.argv[1:], "vt:")
except getopt.GetoptError as err:
    print(str(err))
    print('measure.py -q -t <interval>')
    print('-q: be quiet')
    print('-t <interval>: measure each <interval> seconds (default: 10s)')
    sys.exit(2)

for opt, arg in opts:
    if opt == '-q':
        verbose = False
    elif opt == '-t':
        interval = int(arg)

# instantiate a sense-hat object
sh = sense_hat.SenseHat()
    
# infinite loop
try:
    while True:
        # instantiate a database connection
        try:
            mariadb_connection = mariadb.connect(**dbconfig)
            if verbose:
                print("Database connected")

        except mariadb.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Something is wrong with your user name or password")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database does not exist")
            else:
                print("Error: {}".format(err))
            sys.exit(2)

        # create the database cursor for executing SQL queries
        cursor = mariadb_connection.cursor(buffered=True)

        # turn on autocommit
        #cursor.autocommit = True

        # get the sensor_id for temperature sensor
       
        # measure temperature
        Temp = round(sh.get_temperature())
      
        timeNow = datetime.now()
        dateTime = timeNow.strftime("%Y-%m-%d %H:%M:%S");
        print(dateTime)
    
        # verbo
        if verbose:
            print("Temperature: %s " % Temp )

        # store measurement in database
        try:
            sql = "UPDATE coldroomtemperatures SET Temperature = {} ,RecordedWhen = '{}', ValidFrom = '2020-12-14 19:50:32', ValidTo = '2021-12-16 19:50:31' WHERE ColdRoomSensorNumber = 5;".format(Temp, dateTime)
            print(sql)
            cursor.execute("Insert into coldroomtemperatures_archive select * from coldroomtemperatures where coldroomsensornumber = 5")
            cursor.execute(sql)
            print("Temp updated")
            
            print("Archive Updated")
        except mariadb.Error as err:
            print("Error: {}".format(err))

        else:
            # commit measurements
            mariadb_connection.commit()

            if verbose:
                print("Temperature committed")

            # close db connection
            cursor.close()
            mariadb_connection.close()
            time.sleep(interval)

except KeyboardInterrupt:
    pass

# done
