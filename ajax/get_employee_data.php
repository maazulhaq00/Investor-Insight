<?php
include("../includes/application_top2.php");
if(!$_SESSION["groups_id"])
{
	alert("You don't have rights to the page");
	redirect(NOT_LOGGED_IN);
}
$employee_id = $_GET["id"];
$start = $_GET["start"];
$end = $_GET["end"];
$db = new db2();

	$sql = "select * from attendance where employee_id = $employee_id and time_in >= $start AND time_out <= $end";
	//echo $sql;
	$result = $db->result($sql);
	$event = array();
	foreach($result as $a)
	{
		$time_in = date('Y-m-d h:i:s', $a["time_in"]).' GMT+0000 (West Asia Standard Time)';
		$time_out = date('Y-m-d h:i:s', $a["time_out"]).' GMT+0000 (West Asia Standard Time)';
		$event[] = array(
				'id' => $a["attendance_id"],
				'title' => "attendance",
				'start' => get_time($a["time_in"]),
				'end' => get_time($a["time_out"]),
				'allDay' => false
			);
	}
	
	echo json_encode($event);
?>