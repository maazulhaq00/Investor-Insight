<?php
function ustudent()
{
	$db = new db2();
	$_GET = str_to_arr();
	$id = $_GET["id"];
	$batch_id = $_GET["batch_id"];
	if(!$batch_id) $batch_id = DEFAULT_BATCH_ID;
	if(!$id)
	{
		$sql = "select 
			s.students_id, s.students_name, s.fathers_name, s.mothers_name, 
			s.students_age, s.students_date_of_birth, s.students_email, s.students_telephone, s.students_mobile,
			cl.class_name, c.center_name as diniyat_center, l.level_name as diniyat_level,
			sc.speech_center_name as speech_center, sl.speech_level_name as speech_level
	
		from batch_to_students bs
		left join students s 
				left join center c on s.center_id = c.center_id
				left join class cl on s.class_id  = cl.class_id
				left join level l on s.level_id  = l.level_id
				left join speech_center sc on s.speech_center_id = sc.speech_center_id
				left join speech_level  sl on s.speech_level_id  = sl.speech_level_id
			on bs.students_id = s.students_id
		left join batch b on bs.batch_id = b.id
		where s.center_id = ''
		AND b.id = $batch_id";

		$result = $db->result($sql);
		$temp = '<table border="1" cellpadding="2" cellspacing="0"><tr><td>id</td><td>
    Name</td><td>
    Father\'s Name</td><td>
    Age</td><td>
    Date of Birth</td><td>
    Email</td><td>
    Telephone</td><td>
    Mobile</td><td>
    Class</td>
	<td>Diniyat Center</td><td>Diniyat Level</td>
	</tr>';
		foreach($result as $a)
		{
		$temp .= '<tr>
			<td><a href="?id='.$a["students_id"].'">'.$a["students_id"].'</a></td><td>
			<a href="?id='.$a["students_id"].'">'.$a["students_name"].'</a></td><td>
			'.$a["fathers_name"].'</td><td>
			'.$a["students_age"].'</td><td>
			'.date("m/d/Y", $a["students_date_of_birth"]).'</td><td>
			'.$a["students_email"].'</td><td>
			'.$a["students_telephone"].'</td><td>
			'.$a["students_mobile"].'</td><td>
			'.$a["class_name"].'</td>
			<td>'.$a["diniyat_center"].'</td>
			<td>'.$a["diniyat_level"].'</td>
		</tr>';
		}
		$temp .= '</table>';
	}
	else
	{
		if($_POST)
		{
			//debug_r($_POST);
			$center_id = $_POST["center_id"];
			$added_by_id = $_SESSION["users_id"];
			//tens of validation can go here
			$students_id = $_GET["id"];
			
			$sql = "update students 
					SET center_id = '$center_id',
					students_added_by_id = $added_by_id
			WHERE 
				students_id = $students_id;";
			//debug_r($sql);
			$result = $db->sqlq($sql);
			redirect("?action=success");
		}
		else
		{
			$student = get_tuple("students", $id, "students_id");
			//debug_r($student);
			$students_id = $id;
			//$batch = $_REQUEST["batch"];
			$students_name = $student["students_name"];
			//$students_date_of_birth = mktime(0, 0, 0, $student["monthdropdown_students_date_of_birth"], $student["daydropdown_students_date_of_birth"], $student["yeardropdown_students_date_of_birth"]);
			$students_date_of_birth = $student["students_date_of_birth"];
			
			$state_id = $student["state_id"];
			$state_id = get_tuple("state", $state_id);
			
			$gender_id = $student["gender_id"];
			$gender_id = get_tuple("gender", $gender_id);
			//debug_r($state_id);
			$street_name = $student["street_name"];
			$fathers_name = $student["fathers_name"];
			$plot_number = $student["plot_number"];
			$area = $student["area"];
			$school_name = $student["school_name"];
			$class_id = $student["class_id"];
			$previous_class_id = $student["previous_class_id"];
			$speech_level_id = $student["speech_level_id"];
			$speech_center_id = $student["speech_center_id"];
			$center_id = $student["center_id"];
			$level_id = $student["level_id"];
			$students_telephone = $student["students_telephone"];
			$students_mobile = $student["students_mobile"];
			$students_email = $student["students_email"];
			$comments = $student["comments"];
			$students_age = $student["students_age"];
			
			if($level_id)
				$programme_1_sected = 'checked="checked"';
			if($speech_level_id)
				$programme_2_sected = 'checked="checked"';
			
		}
		$data_n["html_head"] = '
			<script>
			function check()
			{
				if($("#batch_5:checked").val() == undefined && $("#batch_1:checked").val() == undefined)
				{
					alert("Please select your programme");
					$("#batch_5").focus();
					return false;
					
				}
				if($("#batch_5:checked").val() != undefined && ($("#level_id").val() == "none" || $("#center_id").val() == "none"))
				{
					alert("Please select your programme details");
					$("#level_id").focus();
					return false;
				}
				if($("#batch_1:checked").val() != undefined && ($("#speech_level_id").val() == "none" || $("#speech_center_id").val() == "none"))
				{
					alert("Please select your programme details");
					$("#speech_level_id").focus();
					return false;
				}
				//level_id
				return true;
			}
			</script>
		';
		/*	<ol>
	  <li>You can fill the following Admission form up to 22 July, 2013
		<ol>
		  <li>Admission fee will be charge at the time of collecting admit card</li>
		  <li>Collect your admit card from examination/registration center, 2 days before exam or at the examination center before start of exams</li>
		</ol>
	  </li>
	  <li>Admission form for speech competition can be submitted with the<br />
	 exam form online or offline. It can be submitted separately also up to 15 August 2013. No admission fee for registration.</li>
	  <li>Please pick your examination center CORRECTLY.</li>
	  <li>Please pick your EXAMS GROUP (JUNIOR/MIDDLE/HIGHER) correctly.</li>
	</ol>*/
		$temp = '';
		if($_GET["action"] == "success")
		{
			$temp = '<div style="background:#6F6; padding:5px; text-align:center; color:black">Student Added Sucessfully</div>';
		}
		$temp .= '
	<form id="form3" name="form3" method="post" action="?action=update&id='.$id.'" onsubmit="return check()">
	  <table>
	  <tr>
		<td width="200px">Name</td>
		<td width="2px">:</td>
		<td>'.$students_name.'</td>
	  </tr>
	  <tr>
		<td width="200px">Father\'s Name/Husband\'s Name</td>
		<td width="2px">:</td>
		<td>'.$fathers_name.'</td>
	  </tr>
	  <tr>
		<td width="200px">Date of Birth</td>
		<td width="2px">:</td>
		<td>'.date_gen("students_date_of_birth", $students_date_of_birth).'</td>
	  </tr>
	  <tr>
		<td width="200px">Age</td>
		<td width="2px">:</td>
		<td>'.$students_age.'</td>
	  </tr>
	  <tr>
		<td width="200px">Gender</td>
		<td width="2px">:</td>
		<td>'.$gender_id["gender_name"].'</td>
	  </tr>
	  <tr>
		<td width="200px">Street Name</td>
		<td width="2px">:</td>
		<td>'.$street_name.'</td>
	  </tr>
	  <tr>
		<td width="200px">Plot Number</td>
		<td width="2px">:</td>
		<td>'.$plot_number.'</td>
	  </tr>
	  <tr>
		<td width="200px">Area</td>
		<td width="2px">:</td>
		<td>'.$area.'</td>
	  </tr>
	  <tr>
		<td width="200px">City</td>
		<td width="2px">:</td>
		<td>'.$state_id["state_name"].'</td>
	  </tr>
	  <tr style="border-top:#000 thick solid; border-bottom:000 thin solid;">
		<td colspan="3">Programmes Interested In</td>
	  </tr>
	  <tr style="border-top:#000 thin solid">
		<td colspan="3">
		<input type="checkbox" value="2" name="batch[]" id="batch_5" '.$programme_1_sected.'>
		<label for="batch_5">Diniyat Exams '.CURRENT_ISLAMIC_YEAR.' Hijri</label>
		</td>
	  </tr>
	  <tr>
		<td width="200px">Diniyat Exams Group</td>
		<td width="2px">:</td>
		<td>'.dropdown("level", $level_id).'</td>
	  </tr>
	  <tr>
		<td width="200px">Diniyat Exams Center</td>
		<td width="2px">:</td>
		<td>'.dropdown("center", $center_id).'</td>
	  </tr>
	  
	  <tr style="border-top:#000 thin solid">
		<td colspan="3">
		  <input type="checkbox" value="1" name="batch[]" id="batch_1" '.$programme_2_sected.'>
		  <label for="batch_1">Speech Competition 2013</label>
		</td>
	  </tr>
	  <tr>
		<td width="200px">Diniyat Exams Group</td>
		<td width="2px">:</td>
		<td>'.dropdown("speech_level", $speech_level_id).'</td>
	  </tr>
	  <tr>
		<td width="200px">Diniyat Exams Center</td>
		<td width="2px">:</td>
		<td>'.dropdown("speech_center", $speech_center_id).'</td>
	  </tr>
	  <tr>
		<td width="200px"></td>
		<td width="2px"></td>
		<td>
		<input name="submit" id="submit" class="submit" type="submit" value="Submit" />
		<input name="reset" id="reset" class="reset" type="reset" />
		</td>
	  </tr>
	  
	  </table>
	  <a href="#"><strong>Please Note</strong>: </a>
	  <br />Record Are Saved Against : <strong>'.$_SESSION["users_name"].'</strong>
	  </form>';
	}
	$data_n["html_title"] = "Quick Fix Student Center";
	//$data_n["html_heading"] = $a["articles_name"];
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>