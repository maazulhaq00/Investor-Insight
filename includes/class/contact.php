<?php 
/* functions without return */
function contact()
{
	$db = new db2();
	$data_n["html_head"] = "";
	$temp = '
Email: <a href="#">info@najafi.org</a><br /><br />
Phone: 9221-2251795<br /><br />
Mobile: 0322-2725-273<br /><br />
Address: Shop No. 11-12, M.L. Heights,
Mirza Qaleej Baig Road, Soldier Baza No. 2
Karachi 74400, Pakistan<br /><br />
Timings : 5:30 pm to 8:30 pm.
  ';
	
	$heading = "Contact us";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>