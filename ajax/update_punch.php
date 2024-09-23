<?php
include("../includes/application_top.php");
$employee_id = $_POST["id"];
$db = new db2();
$attendance_id = $_POST["id"];
$time_in = set_time($_POST["start"]);
//echo $time_in;
$time_out = "";

if($_POST["end"])
{
	$time_out = set_time($_POST["end"]);
	$time_out = "time_out = $time_out,";
}
else
{
	$time_out = "time_out = $time_in +(time_out - time_in),";
}
$sql = "update attendance set
$time_out
time_in = $time_in
where attendance_id = $attendance_id";
//debug_r($sql);
$db->sqlq($sql);
?>