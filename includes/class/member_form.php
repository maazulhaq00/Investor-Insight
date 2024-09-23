<?php 
/* functions without return */
function member_form()
{
	$db = new db2();
	$data_n["html_head"] = "";
	if($_POST)
	{
		$full_name = $_REQUEST["full_name"];
		$date_of_birth = $_REQUEST["date_of_birth"];
		$name_of_spouse = $_REQUEST["name_of_spouse"];
		$address = $_REQUEST["address"];
		$telephone_res = $_REQUEST["telephone_res"];
		$telephone_cell = $_REQUEST["telephone_cell"];
		$email_address = $_REQUEST["email_address"];
		$khoja_membership = $_REQUEST["khoja_membership"];
		$cnic_no = $_REQUEST["cnic_no"];
		$association = implode(",", $_REQUEST["association"]);
		if($full_name == "")
		{
			alert("Name Cannot be Empty");
			redirect(page_url());
		}
		if($telephone_res == "")
		{
			alert("Phone Number Cannot be Empty");
			redirect(page_url());
		}
		if($email_address == "")
		{
			alert("Email Address Cannot be Empty");
			redirect(page_url());
		}
		if($cnic_no == "")
		{
			alert("CNIC Cannot be Empty");
			redirect(page_url());
		}

		$sql = 'Insert into membership_form (full_name, date_of_birth, name_of_spouse, address, telephone_res, telephone_cell, email_address, khoja_membership, cnic_no, association) VALUES (\''.$full_name.'\', \''.$date_of_birth.'\', \''.$name_of_spouse.'\', \''.$address.'\', \''.$telephone_res.'\', \''.$telephone_cell.'\', \''.$email_address.'\', \''.$khoja_membership.'\', \''.$cnic_no.'\', \''.$association.'\')';
		$result = $db->sqlq($sql);
		
		$to = SITE_ADMIN_EMAIL;
		$headers = getHeaders();
		$subject = "Membership Form From Najafi.org";
		$message = '
		<table width="1000" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>Name </td>
				<td>'.$full_name.'</td>
			  </tr>
			  <tr>
				<td>Email Address</td>
				<td>'.$email_address.'</td>
			  </tr>
			  <tr>
				<td>Date of Birth</td>
				<td>'.$date_of_birth.'</td>
			  </tr>
			  <tr>
				<td>Name of Spouse</td>
				<td>'.$name_of_spouse.'</td>
			  </tr>
			  <tr>
				<td>Address</td>
				<td>'.$address.'</td>
			  </tr>
			  <tr>
				<td>Company</td>
				<td>'.$company.'</td>
			  </tr>
			  <tr>
				<td>Comments</td>
				<td>'.$comments.'</td>
			  </tr>
			  <tr>
				<td>Association</td>
				<td>'.$association.'</td>
			  </tr>
			</table>
		';
		mail($to, $subject, $message, $headers);
		alert("We have received your order successfully");
		redirect(page_url());
	}
	$temp = '
	<form id="form1" name="form1" method="post" action="">
  <table width="645" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="91">Full Name:</td>
      <td width="554"><label for="full_name"></label>
      <input type="text" name="full_name" id="full_name" /></td>
    </tr>
    <tr>
      <td>Date Of Birth:</td>
      <td><label for="date_of_birth"></label>
      <input type="text" name="date_of_birth" id="date_of_birth" /></td>
    </tr>
    <tr>
      <td>Name of Spouse/Father:</td>
      <td><label for="name_of_spouse"></label>
      <input type="text" name="telephone_res" id="name_of_spouse" /></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><label for="address"></label>
      <input type="text" name="address" id="address" /></td>
    </tr>
    <tr>
      <td>Telephone No:</td>
      <td><label for="telephone_Res"></label>
      <input type="text" name="telephone_Res" id="telephone_Res" />
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><label for="telephone_cell"></label>
            <input type="text" name="telephone_cell" id="telephone_cell" /></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>Email Address(if any)</td>
      <td><label for="email_address"></label>
      <input type="text" name="email_address" id="email_address" /></td>
    </tr>
    <tr>
      <td>Khoja Jamaat Membership No:</td>
      <td><label for="khoja_membership_no"></label>
      <input type="text" name="khoja_membership_no" id="khoja_membership_no" /></td>
    </tr>
    <tr>
      <td>CNIC No:</td>
      <td>
      <input type="text" name="cnic_no" id="cnic_no" /></td>
    </tr>
    <tr>
      <td>Association with Najfi:</td>
      <td>
	  <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><label for="student"></label>
            <input name="association[]" type="checkbox" id="student" value="student" />
            <label for="student">Student</label>
            </td>
        </tr>
        <tr>
          <td><label for="volunteer"></label>
            <input type="checkbox" name="association[]" id="volunteer" value="volunteer" />
            <label for="volunteer">Volunteer</label>
            </td>
        </tr>
        <tr>
          <td><label for="doner"></label>
            <input type="checkbox" name="association[]" id="doner" value="doner" />
            <label for="doner">Doner</label>
            </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="association[]" id="library_member" value="library_member" />
            <label for="library_member">Library Member</label></td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="association[]" id="parent_of_student" value="parent_of_student" />
           
            <label for="parent_of_student">parent of Student </label></td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="association[]" id="others" value="others" />
           <label for="others">Others</label></td>
        </tr>
		<tr>
			<td colspan="2">
				
			</td>
		</tr>
      </table>
	  </td>
    </tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="Submit">
		</td>
	</tr>
  </table>
</form>

	';
	
	$heading = "Membership Form";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>