<?php
function compile_top_html($data_n, $template)
{
	$title = $data_n["html_title"];
	$heading = $data_n["html_heading"];
	if($title == "")
	{
		$title = page_name();
		if(isset($_GET["action"]) && $_GET["action"] == "new")
			$title = "New ".$title;
	}

	if($heading == "")
		$heading = $title;

	//-----------------------------LOAD ALL CONTENT

	$data = file_get_contents($template);
	if(page_name() != 'login')
		$data = load_content($data);
	//-----------------------------menu
	//echo((page_name()=="index")?" current":page_name());
	#-------------------#
	$data = str_replace('src="images/', 'src="'.TEMPLATE_DIR.'images/', $data);
	$data = str_replace('src="dist/', 'src="'.TEMPLATE_DIR.'dist/', $data);
	$data = str_replace('src="plugins/', 'src="'.TEMPLATE_DIR.'plugins/', $data);
	$data = str_replace('src="js/', 'src="'.TEMPLATE_DIR.'js/', $data);
	$data = str_replace('src="jquery/', 'src="'.TEMPLATE_DIR.'jquery/', $data);
	$data = str_replace('src="bootstrap/', 'src="'.TEMPLATE_DIR.'bootstrap/', $data);

	$data = str_replace('src="fullcalendar/', 'src="'.TEMPLATE_DIR.'fullcalendar/', $data);
	$data = str_replace('href="', 'href="'.TEMPLATE_DIR.'', $data);
	$data = str_replace('pref="', 'href="', $data);

	$data = str_replace('src="plugins/', 'src="'.TEMPLATE_DIR.'plugins/', $data);
	$data = str_replace('src="dist/', 'src="'.TEMPLATE_DIR.'dist/', $data);

	#-------------------#
	$u = new users();
	//



	if(!is_login())
	{
//		$data = str_replace("Investor Insight", "Flexible Learning School", $data);
		$data = str_replace("{__Content__title__}", "", $data);
		//alert("IS NOT Login");
		$data_temp = explode("{__LOGIN__}", $data);
		echo $data_temp[0];
		include('trafficbuilder/login.php');
		$data = $data_temp[1];
	}
	//-----------------------------END OF LOAD ALL CONTENT

	//-----------------------------HEADING
	$data = str_replace("{__HEADING__}", $heading, $data);
	$data = str_replace("<a pref=\"", "<a href=\"", $data);

	#-------------------#
	$data = add_analytics($data);
	#---------Menu----------#
	$data = str_replace('{__menu__}', $u->permissions(), $data);
	#---------Profile----------#
	$group = get_group();
	if(!is_array($group)) $group = [];
	//group_name.php
	//if group as page name don't exist
	$page = page_explode();
	$wwwroot = "http://".$_SERVER['HTTP_HOST'].'/'.$page[1].'/';
	$file = $wwwroot.$group["group_name"].".php";
	$file_headers = @get_headers($file);
	if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		$exists = false;
		$file = $wwwroot."users.php";
	}
	else {
		$exists = true;
	}
	$data = str_replace('{__PROFILE_LINK__}', $file.'?action=edit&id='.$_SESSION["users_id"], $data);
	$data = str_replace("{__USERS_NAME__}", $_SESSION['users_name'], $data);
	$data = str_replace("{__USERS_FULL_NAME__}", $_SESSION['users_name'], $data);
	#---------set pagination----------#
	$sql = "select number_of_pages from pagination where users_id = ".(int)$_SESSION["users_id"]." AND groups_id = ".(int)$_SESSION["groups_id"];
	$result = $u->result($sql, 1);
	$number_of_pages = $result['number_of_pages'];
	if(!$number_of_pages)
		define("number_of_pages", 10);	 //default number of pages
	// else
	// 	define("number_of_pages", $number_of_pages["number_of_pages"]);
	return $data;
}

function compile_top($data_n)
{

	//-----------------------------LOAD ALL CONTENT
	if(!is_login())
	{
		$template = TEMPLATE_LOGIN;
	}
	else
	{
		$template = TEMPLATE;
	}

	return compile_top_html($data_n, $template);
}
function compile_left($data, $html_text)
{
	if(strpos($html_text, '<p>&nbsp;</p>') == (strlen($html_text)-13))
	{
		$html_text = substr($html_text, 0, (strlen($html_text)-13));
	}

	//ADD Body
	$data_temp = explode("{__BODY__}", $data);
	//-----------------------------ADD BODY
	$temp = "";
	//-----------------------------CHECK IF FITER IS AVAILBLE TO THE BODY
	if(function_exists(page_name()) && 0)
		eval("\$temp = ".page_name()."(".htmlspecialchars_decode1($html_text).");");
	else
		eval("\$temp = '".remove_appos(htmlspecialchars_decode1($html_text))."';");

	//eval("\$temp = '".remove_appos(htmlspecialchars_decode1($html_text))."';");
	$data_temp[0] .= $temp;
	$data = $data_temp[0].$data_temp[1];
	//-----------------------------END OF ADD BODY


	$data = str_replace('{__State__}', $temp, $data);
	return $data;
}
function compile_left2($data)
{
	return $data;
}

function get_group()
{
	$groups_id = $_SESSION["groups_id"];
	$groups_id = get_tuple("groups", $groups_id, "groups_id");
	return $groups_id["groups_name"];
}

function color($c)
{
	return '<span style="color:'.$c.'">';
}

function color_end()
{
	return '</span>';
}

function has_inherits($str)
{
	if(strpos($str, '_inherits_'))
		return true;
	return false;
}

function remove_inherits($str)
{
	if(has_inherits($str))
	{
		$temp = explode('_inherits_', $str);
		$str = $temp[0];
	}
	if(strpos($str, ' inherits '))
	{
		alert("pls reconsider line 97 functions.php");
		$temp = explode(' inherits ', $str);
		$str = $temp[0];
	}
	return ucwords(str_replace("_", " ", $str));
}
function get_inherits($str)
{
	if(has_inherits($str))
	{
		$temp = explode('_inherits_', $str);
		$str = $temp[1];
	}
	if(strpos($str, ' inherits '))
	{
		alert("pls reconsider line 97 functions.php");
		$temp = explode(' inherits ', $str);
		$str = $temp[1];
	}
	return $str;
	return ucwords(str_replace("_", " ", $str));
}
function get_inherits_parent($str)
{
	if(has_inherits($str))
	{
		$temp = explode('_inherits_', $str);
		$str = $temp[0];
	}
	return $str;
}
//to get the classname_id in case of inherits or not
function get_class_id($tbl)
{
	$db = new db2();
	if(has_inherits($tbl))
	{
		return get_inherits_parent($tbl)."_id";
	}
	else
	{
		$column_name  = $tbl;
		//if has id then don't add id
		if(strpos($tbl, "_id") != (strlen($tbl)-3))
		{
			$column_name = $tbl."_id";
		}

		if(strpos($tbl, "_id") == (strlen($tbl)-3))
		{
			$tbl = str_replace("_id", "", $tbl);
		}
		$sql = "SHOW COLUMNS FROM `$tbl` LIKE 'id';";
		$columns = $db->result($sql);
		if($columns) return "id";
		return $column_name;
//		alert('str = '.$str.'\nClass = '.$class_id);
	}

	return $class_id;
}
function remove_appos($str)
{
	$str = str_replace("'", "&rsquo;", $str);
	return $str;
}
function is_login()
{

	if(isset($_SESSION["users_id"])&&($_SESSION["users_id"] != "0"))
		return true;
}
function add_analytics($data)
{
	$code = "";
	$data = explode("</body>", $data);
	$data = $data[0].$code.'</body>'.$data[1];
	return $data;
}
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function str_to_arr($str = '')
{
	if($str == "")
		$str = page_url_complete();
	//str = vehicle.php?action=delete&id=1
	$result = array();

	$arr = explode("?", $str);
	$arr = $arr[count($arr)-1];

	$arr = explode("&", $arr);
	for($i=0; $i<count($arr); $i++)
	{
		$temp = explode("=", $arr[$i]);
		$key = $temp[0];
		$value = $temp[1];
		$result[$key] = $value;
	}
	return $result;
}
?>