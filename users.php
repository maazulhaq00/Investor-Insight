<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  ?><?php
include('includes/application_top.php');
$a = new users();
 
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
					location.href=\'users.php?action=delete&id='.$_GET["id"].'\';
				}
				else
				{
					location.href=\'users.php\';
				}	
				-->
				</script>';
 }

$data = compile_top("Manage Users");
?>
<script>
function check()
{
	if(document.getElementById("users_name").value == "")
	{
			alert('Users Name is required.');
			return false;
	}
	if(document.getElementById("users_password").value == "")
	{
			alert('Users Password is required.');
			return false;
	}
	if(document.getElementById("users_password").value != document.getElementById("cpassword").value)
	{
			alert('Passwords do not match.');
			return false;
	}
	if(document.getElementById("date_of_birth").value == "")
	{
			alert('Date of Birth is required.');
			return false;
	}
	if(document.getElementById("users_email").value == "")
	{
			alert('Users Email is required.');
			return false;
	}
	if(document.getElementById("users_first_name").value == "")
	{
			alert('Users First Name is required.');
			return false;
	}
	if(document.getElementById("users_last_name").value == "")
	{
			alert('Users Last Name is required.');
			return false;
	}
	if(document.getElementById("users_secret_question").value == "")
	{
			alert('Secret question is required.');
			return false;
	}
	if(document.getElementById("users_secret_answer").value == "")
	{
			alert('Secret Answer is required.');
			return false;
	}
	if(document.getElementById("users_zipcode").value == "")
	{
			alert('Users Zipcode is required.');
			return false;
	}
	
	if(document.getElementById("users_secret_question").value == "")
	{
			alert('Secret Question is required.');
			return false;
	}
	if(document.getElementById("users_secret_answer").value == "")
	{
			alert('Secret Password is required.');
			return false;
	}
	return true;
}
</script>
<?php require_once('trafficbuilder/head.php'); ?>
<?php require_once('trafficbuilder/cal.php'); ?>
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

echo '</head>';
//

//left column
$data_temp = explode("{__LEFTCOLUM__}", $data);
$data = str_replace("{__LEFTCOLUM__}", "", $data);
echo $data_temp[0];
include('trafficbuilder/login.php');
$data = $data_temp[1];


//ADD Body
$data_temp = explode("{__BODY__}", $data_temp[1]);
echo $data_temp[0];
$data = $data_temp[1];

if($_GET["action"] == "new" )
	{
		echo '<form id="form5" name="form5" method="post" action="?action=insert" enctype="multipart/form-data" onsubmit="return check()">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
					<td width="30%">Users Name</td>
					<td width="70%"><input name="users_name" type="text" class="inputs" id="users_name"/>							
					</td>
				  </tr>
				 
				  <tr>
					<td width="30%">Users Password</td>
					<td width="70%"><input name="users_password" type="text" class="inputs" id="users_password"/>							
					</td>
				  </tr>
				 
				  <tr>
					<td width="30%">Password Verify</td>
					<td width="70%"><input name="cpassword" type="text" class="inputs" id="cpassword"/>							
					</td>
				  </tr>
				 
				  <tr>
					<td width="30%">Date of Birth</td>
					<td width="70%">
					<script language="JavaScript" src="trafficbuilder/calendar_us.js" type="text/javascript"></script>
                    <link rel="stylesheet" href="trafficbuilder/calendar.css" />
                  <label>
                        <input name="date_of_birth" type="text" id="date_of_birth"  />
                      </label>
                        <img src="images/spacer.gif" width="3" height="1" alt="" />
                        <script language="JavaScript" type="text/javascript"> 
						new tcal ({
							// form name
							\'formname\': \'form5\',
							// input name
							\'controlname\': \'date_of_birth\'
						});
				  </script>
					
					</td>
				  </tr>
				  <tr>
					<td width="30%">Users Email</td>
					<td width="70%"><input name="users_email" type="text" class="inputs" id="users_email"/>							
					</td>
				  </tr>
				  <tr>
					<td width="30%">Users Secret Question</td>
					<td width="70%"><input name="users_secret_question" type="text" class="inputs" id="users_secret_question"/>							
					</td>
				  </tr>
				  <tr>
					<td width="30%">Users Secret Answer</td>
					<td width="70%"><input name="users_secret_answer" type="text" class="inputs" id="users_secret_answer"/>							
					</td>
				  </tr>		 
					 
				  <tr>
					<td width="30%">Users First Name</td>
					<td width="70%"><input name="users_first_name" type="text" class="inputs" id="users_first_name"/>							
					</td>
				  </tr>
				  <tr>
					<td width="30%">Users Last Name</td>
					<td width="70%"><input name="users_last_name" type="text" class="inputs" id="users_last_name"/>							
					</td>
				  </tr>
				 
				  <tr>
					<td width="30%">State Province</td>
					<td width="70%"><input name="state_province" type="text" class="inputs" id="state_province"/>							
					</td>
				  </tr>
				 <tr>
						<td width="30%">Users Picture Upload</td>
						<td width="70%"><input name="users_picture_upload" type="file" class="inputs" id="users_picture_upload" />
						

						</td>
					  </tr>
				 
		<tr><td colspan="2">
		<table cellpadding="5" cellspacing="0" border="0">
		<tr>
				<td><input type="submit" name="button2" id="button2" value="Insert USERS" /></td>
				<td><input type="reset" name="Reset" id="button2" value="Reset Insert USERS" /></td>
				<td>
				<a href="users.php">
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