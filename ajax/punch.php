<?php
include("../includes/application_top2.php");
if(!$_SESSION["groups_id"])
{
	alert("You don't have rights to the page");
	redirect(NOT_LOGGED_IN);
}
$employee_id = $_POST["id"];
$db = new db2();
//alert($_POST["type"]);
$description = $_POST["description"];
if($_POST["type"] == "in")
{
	$sql = "insert into attendance (time_in, date, employee_id, description_in)
		VALUES (".set_time().", NOW(), ".$employee_id.", '$description')";
}
elseif($_POST["type"] == "out")
{
	//get id where to update
	$a = last_marked($employee_id);
	if($a["attendance_id"])
		$sql = "update attendance set time_out = ".set_time().", description_out = '$description' where attendance_id = ".$a["attendance_id"];
}
else
{
	echo '';
}
//print_r($_POST);
if($sql)
	$db->sqlq($sql);
?>