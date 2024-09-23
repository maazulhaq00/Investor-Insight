<?php
function generic()
{
	$get = str_to_arr();
	$db = new db2();
	$_GET = $get;
	/*
	
	function upload_files()
	{
		$head = '
		<script src="https://cdn.tailwindcss.com"></script>

		<link href="dist/output.css" rel="stylesheet">    ';
		if($_GET["action"]=="upload")
		{
			debug_r('upload files');
			// redirect();
			//eval($get["action"].'();');
		}
		$temp = get_sidebar().'
		<div class="col-lg-8 col-md-7">
			asda	
		</div>';
		
		$data_n = array();
		$data_n["html_head"] = "";
		$data_n["html_title"] = "Upload Files";
		$data_n["html_heading"] = "Upload Files";
		$data_n['html_text'] = wrap_form($temp, '', '');
		$data_n["html_head"] = $head;
		return $data_n;
	}
	
	
	
	
	*/
	if($get["action"]=="")
	{
		redirect();
		//eval($get["action"].'();');
	}
	if($_GET["action"] == "update_pagination")
	{
		if($_GET["id"] == "") redirect("index.php");
		$sql = "delete from pagination where users_id = ".$_SESSION["users_id"]." AND groups_id = ".$_SESSION["groups_id"];
		$db->sqlq($sql);
		$sql = "insert into pagination (users_id, groups_id, number_of_pages) values (".$_SESSION["users_id"].", ".$_SESSION["groups_id"].", ".$_GET["id"].");";
		$db->sqlq($sql);
		redirect($_SERVER['HTTP_REFERER']);
		die;
	}
}
function subscription()
{
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$email = $_POST["email"];
	if(!$first_name) $first_name = $_POST["name"];
	// debug_r($_POST);
	$sql = "insert into subscriptions
	(subscriptions_name, subscriptions_last_name, subscriptions_email)
	VALUES
	('".$first_name."', '".$last_name."', '".$email."')";
	// debug_r($sql);
	$db = new db2();
	$db->sqlq($sql);

	$subject = 'New Subscription From '.SITE_NAME;
	$message = 'E-Mail : '.$email.'<br />';
	if(!$_POST['first_name'])
	{
		if($first_name)
		$message .= 'Name: '.$first_name;
	}
	else
	$message .= '
				First Name: '.$first_name.'<br />
				Last Name: '.$last_name.'';

	email(SITE_ADMIN_EMAIL, $subject, $message);
	alert("You have successfully subscribed.");
	redirect($_SERVER["HTTP_REFERER"]);
}
function headers()
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= 'From: Najafi <info@najafi.org>' . "\r\n";
	return $headers;
}

function date_gen($id = '', $date = '', $multi = '')
{
	if(!$date) $date = time();
	$daydropdown_ = date("d", $date);
	$monthdropdown_ = date("m", $date);
	$yeardropdown_ = date("Y", $date);

	$temp = ' <select id="daydropdown_'.$id.'" name="daydropdown_'.$id.$multi.'">';
	for($i=1;$i<=31;$i++)
	{
		$selected = '';
		if($i == $daydropdown_)
			$selected = ' selected="selected"';
		$temp .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	$temp .= '</select>

	<select id="monthdropdown_'.$id.'" name="monthdropdown_'.$id.$multi.'">';
	for($i=1;$i<=12;$i++)
	{
        $mon = date("F", mktime(0, 0, 0, $i+1, 0, 0));
		$selected = '';
		if($i == $monthdropdown_)
			$selected = ' selected="selected"';
		$temp .= '<option value="'.($i).'" '.$selected.'>'.$mon.'</option>';
	}
	$temp .= '</select>

	<select id="yeardropdown_'.$id.'" name="yeardropdown_'.$id.$multi.'">';
	for($i=1998;$i<2021;$i++)
	{
		$selected = '';
		if($i == $yeardropdown_)
			$selected = ' selected="selected"';
		$temp .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	$temp .= '</select>';
	return $temp;
}
function content_to_constant()
{
    $db = new db2();
    $sql = "SELECT * FROM  `content` ";
    $data = $db->result($sql);
		// debug_r($sql);
    foreach($data as $f)
    {
        // $content = get_tuple("content", $f["content_name"], "content_name");
        $name = $f["content_name"];
        $name = str_replace("{", '', $name);
        $name = str_replace("}", '', $name);
        define($name, $f["content_description"]);
    }
    return $data;
}
function generate_insert()
{
  $cols = [];
  $vals = [];
  foreach($_POST as $k=>$v)
  {
    $cols[] = $k;
    $vals[] = "'\${$k}'";
    echo "\${$k} = \$_POST['{$k}'];<br>";// 
  }
  echo 'Insert into 
  tbl 
    ('.implode(', ', $cols).')
  VALUES
    ('.implode(', ', $vals).');<br>';
}
function generate_update()
{
  $cols = [];
  foreach($_POST as $k=>$v)
  {
    $cols[] = "{$k} = '\${$k}'";
    echo "\${$k} = \$_POST['{$k}'];<br>";// 
  }
  echo 'update tbl 
  set
    '.implode(', ', $cols).'
  WHERE
    ;<br>';   
}

function is_assistantteacher()
{
	if(isset($_SESSION["groups_id"]) && $_SESSION["groups_id"] == "13") return $_SESSION["groups_id"];
}
function is_teacher()
{
	if(isset($_SESSION["groups_id"]) && $_SESSION["groups_id"] == "14") return $_SESSION["groups_id"];
}