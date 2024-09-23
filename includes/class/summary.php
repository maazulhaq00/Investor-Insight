<?php
function summary()
{
	$_GET = str_to_arr();
	$s= new student();
	$grades = array("Merit",	"Distinction", "Pass", "Consolation", "Fail");
	$temp = '<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#CCCCCC">
    <td><strong>Grade</strong></td>
    <td><strong>Level</strong></td>
    <td><strong>Boys</strong></td>
    <td><strong>Girls</strong></td>
    <td><strong>Sub Total</strong></td>
  </tr>';
  $total = 0;
  	foreach($grades as $grade)
	{
		//loop through grades
		$sql = "select * from level where level_id > 1";
		$result = $s->result($sql); //TODO: Check DB
		$grade_total = 0;
		$flag_first = true;
		$temp_count = array();
		foreach($result as $a)
		{
			if($flag_first)
			{
				$flag_first = false;
				$temp .= '
				  <tr>
					<td rowspan="4"><strong>'.$grade.'</strong></td>';
			}
			else
			{
				$temp .= '
				  <tr>';				
			}
			//loop through levels
			$level_total = 0;
			$level_id = $a["level_id"];
			
			$temp .= '
					<td><strong>'.$a["level_name"].'</strong></td>';
			$sql2 = "select * from gender order by gender_id asc";
			$result2 = $s->sql_query($sql2);
			$level_count = array();
			while($a2 = mysql_fetch_array($result2))
			{
				//loop through gender
				$gender_id = $a2["gender_id"];
				
				$sql3 = "select COUNT(*) as count from students where students_marks > 0 AND level_id = $level_id AND gender_id = ".$gender_id;
				
				
				$sql4 = "select students_id, students_marks from students where students_marks > 0 AND level_id = $level_id AND gender_id = ".$gender_id." order by students_marks desc limit 0,6";
				$result4 = $s->sql_query($sql4);
			/*
				6 people in merit 
				script modified on september 8th 2013
			*/	
				$i = 1;
				$last_student_marks = 0;
				$ids = '';
				while($a4 = mysql_fetch_array($result4))
				{
					if($i++ > 1  && $i<=6)
					{
						$ids .= ',';
					}
					if($i<=6)
						$ids .= $a4["students_id"];
					elseif($a4["students_marks"] == $last_student_marks)
					{
						$ids .= ', '.$a4["students_id"];
					}
					$last_student_marks = $a4["students_marks"];
				}
				
				//count boys of this level against grade
				//alert($grade);
				if($grade == "Merit")
				{
					$level_sub_total = 5;
				}
				elseif($grade == "Distinction")
				{
					if(!$ids)
					{
						$level_sub_total = 0;
					}
					else
					{
						$sql3 .= " AND students_marks > 84.9 AND students_id NOT IN ($ids)";
						$result3 = $s->sql_query($sql3);
						$a3 = mysql_fetch_array($result3);
						$level_sub_total = $a3["count"];
						$level_sub_total = ($level_sub_total>0)?$level_sub_total:0;
					}
				}
				elseif($grade == "Pass")
				{
					$sql3 .= "	AND students_marks < 84.9
								AND students_marks > 49.9";
					$result3 = $s->sql_query($sql3);
					$a3 = mysql_fetch_array($result3);
					$level_sub_total = $a3["count"];
				}
				elseif($grade == "Consolation")
				{
					$sql3 .= " AND students_marks > 24.9 ";
					$sql3 .= " AND students_marks < 49.9 ";	
					$result3 = $s->sql_query($sql3);
					$a3 = mysql_fetch_array($result3);
					$level_sub_total = $a3["count"];
					if($level_id != 2 && $level_id != 3) $level_sub_total = 0;
				}
				elseif($grade == "Fail")
				{
					$sql3 .= " AND students_marks > 0";
					$sql3 .= " AND students_marks < 24.4 ";
					$result3 = $s->sql_query($sql3);
					$a3 = mysql_fetch_array($result3);
					$level_sub_total = $a3["count"];
					//if($level_id != 2) $level_sub_total = 0;
				}
				$temp .= '
						<td>'.$level_sub_total.'</td>';
				$level_total += $level_sub_total;
				$temp_count[$gender_id] += $level_sub_total;
			}
			$temp .= '
					<td>'.$level_total.'</td>
				  </tr>';
			//over all grade total
			$grade_total += $level_total;
		}//level ends
		$boys_total += $temp_count[1];
		$girls_total += $temp_count[2];
		$temp .= '
			  <tr bgcolor="#CCCCCC">
			<td colspan="2"></td>
			<td><strong>'.$grade.' Boys : '.$temp_count[1].'</strong></td>
			<td><strong>'.$grade.' Girls : '.$temp_count[2].'</strong></td>
			<td><strong>'.$grade.' Sub Total : '.$grade_total.'</strong></td>
		  </tr>';
		  $total += $grade_total;
	}//grade end
	$temp .= '
		  <tr bgcolor="#CCCCCC">
		<td colspan="2"></td>
		<td><strong>Boys Total: '.$boys_total.'</strong></td>
		<td><strong>Girls Total: '.$girls_total.'</strong></td>
		<td><strong>Awarded Total: '.$total.'</strong></td>
	  </tr>
	</table>';
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Purchase Slip";
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>