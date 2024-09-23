<?php
//include('.php');
include_once(_leveli.'database.php');
include_once(_leveli.'database2.php');
include_once(_leveli.'class_users.php');
include_once(_leveli.'dynamic.php');
include_once(_leveli.'classes.php');
#---------------------------------------------- load all class files
//echo _levelc;
$handle = opendir(_levelc);
while($file = readdir($handle))
{
	if(strpos($file, ".php")>0)
	{
		include(_levelc.$file);
	}
}
?>