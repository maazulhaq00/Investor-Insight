<?php
//  $_GET = array_map('addslashes', $_GET);
//  $_POST = array_map('addslashes', $_POST);
//  $_COOKIE = array_map('addslashes', $_COOKIE);


if (isset($_SESSION['user_password']))
{
	if ($_SESSION['user_password'] != md5($_SERVER['HTTP_USER_AGENT'].'_HIJ'))
	{
		//print_r($_SESSION);
	//	redirect(NOT_LOGGED_IN);
		/* Prompt for password */
		//exit;
	}
}
else
{
	$_SESSION['user_password'] = md5($_SERVER['HTTP_USER_AGENT'].'_HIJ');
}



//remove <script> post
if($_REQUEST)
{
	foreach($_REQUEST as $key=>$value)
	{
		$correct_site = isset($_SERVER['HTTP_REFERER']) ? strpos($_SERVER['HTTP_REFERER'], "smmoin.com") : -1;
		if(!$correct_site || $correct_site < 0)
		{
			//redirect("http://smmoin.com");
			//die;
		}
		$_REQUEST[$key] = str_replace("</script>", "", $value);
		$_REQUEST[$key] = str_replace("script>", "", $value);
		$_REQUEST[$key] = str_replace("<script", "", $value);
		$_REQUEST[$key] = str_replace("<?", "", $value);
	}
}

//no site other then this one
// if(strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])<1)
// {
// 	//debug("asad");
//
// 	//echo 'Please block';
// }
$blocked_counts =get_blocked_count();
if($blocked_counts >3)
{
	echo '
	Due to too many failures in login attempt your ip has been blocked.<br />
	Please contact us at <a href="mailto:contact@smmoin.com">contact@smmoin.com</a> to get it unblocked';
	die;
}
function add_to_block()
{
	$blocked_counts = get_blocked_count();
	$db = new db2();
	if($blocked_counts==0)
	{
		$sql="INSERT INTO blocked_ip (blocked_ip_id, blocked_ip_name, blocked_on, blocked_details) VALUES (NULL, '".getRealIpAddr()."', CURRENT_TIMESTAMP, '1');";
		$db->sqlq($sql);
	}
	else
	{
		$sql="update blocked_ip set blocked_details = blocked_details+1 where blocked_ip_name = '".getRealIpAddr()."'";
		$db->sqlq($sql);
	}
}
function get_blocked_count()
{
	$sql = "select blocked_details as count from blocked_ip where blocked_ip_name = '".getRealIpAddr()."'";
	$db = new db2();
	$a = $db->result($sql, 1);
	return isset($a["count"])? $a["count"] : 0;
}
?>
