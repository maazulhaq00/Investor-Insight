<?php 
include('includes/application_top.php');
 $a = new content();
 
 if($_GET["action"] == "insert")
 {
	 $a->insert();
 }
 elseif($_GET["action"] == "delete")
 {
	$a->delete($condition);
 }
 elseif($_GET["action"] == "update")
 {
	$a->update();
 }
 elseif($_GET["action"] == "delete_confirm")
 {
	 
		 echo '<script type="text/javascript"> 
				<!--
				var answer = confirm ("Are sure you want to delete '.$a->class_name.'?")
				if (answer)
				{
					location.href=\'content.php?action=delete&id='.$_GET["id"].'\';
				}
				else
				{
					location.href=\'content.php\';
				}	
				-->
				</script>';
 }
$data = file_get_contents(TEMPLATE);
$data = load_content($data);
//Title
$data = str_replace("{__HEADER__}", page_comment(), $data);
//
$data_temp = explode("</head>", $data);
echo $data_temp[0];
$data = $data_temp[1];
?>
<script>
function check()
{
	if(document.getElementById("content_name").value == "")
	{
			alert('Content Name is required.');
			return false;
	}
	return true;
}
</script><?php require_once('trafficbuilder/cal.php'); ?>
<style type="text/css" title="currentStyle">
			@import "media/css/demo_table.css";
		</style>
		
<script src="trafficbuilder/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			jQuery(document).ready(function() {
				jQuery('#example').dataTable();
			} );
		</script>

<?php 
include('trafficbuilder/head.php');
//ADD THE DYNAMIC STUFF
 ?>
 <?php
echo '</head>';
//

$data_temp = explode("{__LEFTCOLUM__}", $data);
$data = str_replace("{__LEFTCOLUM__}", "", $data);
echo $data_temp[0];
$data = $data_temp[1];
//ADD THE DYNAMIC STUFF
include('trafficbuilder/login.php');

$data_temp = explode("{__BODY__}", $data_temp[1]);
echo $data_temp[0];
$data = $data_temp[1];
//ADD Body
	if($_GET["action"] == "new" )
	{
		echo '<form id="form5" name="form5" method="post" action="?action=insert" enctype="multipart/form-data" onsubmit="return check()">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
					<td width="30%">Content Name</td>
					<td width="70%"><input name="content_name" type="text" class="inputs" id="content_name"/>							
					</td>
				  </tr>
				 
				<tr>
					<td colspan="2">Content Description</td>
				  </tr>
				  <tr>
				  <td colspan="2"><textarea id="content_description" name="content_description" rows="15" cols="40" style="width: 80%"></textarea>
						<br />
						<script>once = true; toggleEditor(\'content_description\');</script>
						<a href="javascript:toggleEditor(\'content_description\');" class="black2">Toggle HTML Editor</a>
						</td>
				  </tr>
				 
		<tr><td colspan="2">
		<table cellpadding="5" cellspacing="0" border="0">
		<tr>
				<td><input type="submit" name="button2" id="button2" value="Insert CONTENT" /></td>
				<td><input type="reset" name="Reset" id="button2" value="Reset Insert CONTENT" /></td>
				<td>
				<a href="content.php">
				<img src="trafficbuilder/button_cancel.gif" width="65" height="22" border="0" />
				</a></td>
			  </tr>
		</table>
			</table>
		  </form>';
	}
	elseif($_GET["action"] == "edit")
	{
		$a->edit();
	}
	else
	{
		$a->show();
	}


echo $data;
include('includes/application_bottom.php');
?>