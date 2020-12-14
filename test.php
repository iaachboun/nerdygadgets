<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";


$insertNewTemp = "
UPDATE coldroomtemperatures
SET Temperature = 7, RecordedWhen = '2020-12-14 23:59:24', ValidFrom = '2020-12-14', ValidTo = '2020-12-16'
WHERE ColdRoomSensorNumber = 5;
";

$Statement = mysqli_prepare($Connection, $insertNewTemp);
mysqli_stmt_execute($Statement);
$em = mysqli_stmt_get_result($Statement);


$UpdateArchive = "INSERT INTO coldroomtemperatures_archive (ColdRoomTemperatureID, ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo)
VALUES (0, 5, '2020-12-14 23:59:24', 7, '2020-12-14', '2020-12-15')";

$Statement = mysqli_prepare($Connection, $UpdateArchive);
mysqli_stmt_execute($Statement);
$em = mysqli_stmt_get_result($Statement);