<?php
include("../includes/application_top.php");
$db = new db2();
$attendance_id = $_POST["id"];
$sql = "delete from attendance where attendance_id = $attendance_id";
echo $sql;
$db->sqlq($sql);
?>