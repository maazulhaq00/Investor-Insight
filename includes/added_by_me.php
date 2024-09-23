<?php 
function added_by_me2()
{
	$data_n = added_by_me(2);
	$data_n["html_title"] = "Records Added - Diniyat Exams 2014";
	if($_SESSION["users_id"] != "20")
		$data_n["html_title"] .= " by ". $_SESSION["users_name"];
	return $data_n;
}
function added_by_me($batch_id = 1)
{
	$db = new db2();
	$temp = '';
	if($_SESSION["users_id"] != 20)
		$filter = "
		 AND s.students_added_by_id = ".$_SESSION['users_id'];
	/* 		
	s.*, bs.*, */
	$sql = "select 
		s.students_id, s.students_name, s.fathers_name, s.mothers_name, 
		s.students_age, s.students_date_of_birth, s.students_email, s.students_telephone, s.students_mobile,
		cl.class_name, c.center_name as diniyat_center, l.level_name as diniyat_level,
		sc.speech_center_name as speech_center, sl.speech_level_name as speech_level

	from batch_to_students bs
	left join students s 
			left join center c on s.center_id = c.center_id
			left join class cl on s.class_id = cl.class_id
			left join level l on s.level_id  = l.level_id
			left join speech_center sc on s.speech_center_id = sc.speech_center_id
			left join speech_level  sl on s.speech_level_id  = sl.speech_level_id
		on bs.students_id = s.students_id
	left join batch b on bs.batch_id    = b.id
	WHERE b.id = $batch_id
	$filter
	Order by c.center_name ASC";
	$result = $db->result($sql);
	$temp = '<table border="1" cellpadding="2" cellspacing="0"><tr><td>S.no.</td><td>id</td><td>
    Name</td><td>
    Father\'s Name</td><td>
    Age</td><td>
    Date of Birth</td><td>
    Email</td><td>
    Telephone</td><td>
    Mobile</td><td>
    Class</td>
	'.($batch_id != 1 ? '
	<td>Diniyat Center</td><td>Diniyat Level</td>
	':'
	<td>Speech Center</td><td>speech_level</td>
	').'
	</tr>';
	$counter  = 0;
	foreach($result as $a)
	{
		$counter++;
		$temp .= '<tr>
			<td>'.$counter.'</td>
			<td>'.$a["students_id"].'</td><td>
			'.$a["students_name"].'</td><td>
			'.$a["fathers_name"].'</td><td>
			'.$a["students_age"].'</td><td>
			'.date("m/d/Y", $a["students_date_of_birth"]).'</td><td>
			'.$a["students_email"].'</td><td>
			'.$a["students_telephone"].'</td><td>
			'.$a["students_mobile"].'</td><td>
			'.$a["class_name"].'</td>
			'.($batch_id!=1?'
			
			<td>'.$a["diniyat_center"].'</td>
			<td>'.$a["diniyat_level"].'</td>
			':'
			<td>'.$a["speech_center"].'</td>
			<td>'.$a["speech_level"].'</td>
			').'
		</tr>';
	}
	$temp .= '</table>';
	//echo $sql;die;
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Records Added - Speech Competition 2013";
	if($_SESSION["users_id"] != "20")
		$data_n["html_title"] .= " by ". $_SESSION["users_name"];
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>