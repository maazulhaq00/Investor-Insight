<?php
header('Content-Encoding: gzip');
ob_end_clean();
ob_start('ob_gzhandler');
//get the last-modified-date of this very file
$lastModified=filemtime(__FILE__);
//get a unique hash of this file (etag)
$etagFile = md5_file(__FILE__);
//get the HTTP_IF_MODIFIED_SINCE header if set
$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

//set last-modified header
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
//set etag-header
header("Etag: $etagFile");
//make sure caching is turned on
header('Cache-Control: public');
session_start();
if(0)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}
else
{
	error_reporting(E_ERROR);
}
// error_reporting(1);
#--------------------------------------------------| for directory access |--------------------------------------------------
$file_path = $_SERVER['SCRIPT_FILENAME'];
$file = explode("/", $file_path);
if($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == "::1")
{
	$level0 = $file[0].'/'.$file[1].'/'.$file[2].'/'.$file[3].'/'.$file[4].'/';
	// $level0 = $file[0].'/'.$file[1].'/'.$file[2].'/'.$file[3].'/';
}
else
{
	$level0 = $file[0].'/'.$file[1].'/'.$file[2].'/'.$file[3].'/';
}
// echo getcwd().'<br>';
// print_r($level0);die;
$level1 = $level0.''.$file[4].'';
define("_level0", $level0);
include(_level0.'includes/function3.php');
include(_level0.'includes/function.php');
include(_level0.'includes/function2.php');
define("_leveli", $level0.'includes/');
define("_levelc", $level0.'includes/class/');
define("_levelw", $level0.'trafficbuilder/');
//relative level
define("_levelw_r", 'trafficbuilder/');
define("_level1", $level1);
#--------------------------------------------------|  |--------------------------------------------------
include(_level0.'includes/configure_pk.php');
include(_level0.'includes/file_names.php');
include(_level0.'includes/class.php');
include(_level0.'includes/design.php');
$u = new users("users");
content_to_constant();
define(DEFAULT_BATCH_ID, '5');
// echo 2;
set_session_for("service", "id");