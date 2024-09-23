<?php 
/* functions without return */
function downloads()
{
	$db = new db2();
	$data_n["html_head"] = "";
	$temp = '<div id="links">
<a href="download/cdlist.xls">+ CD List</a><br /><br />
<a href="#">+ Nauhay</a><br /><br />
<a href="#">+ Majalis</a><br /><br />
<a href="#">+ Qasiday</a><br /><br />
<a href="#">+ Islamic Movies</a><br /> <br />
  </div>';
	
	$heading = "Downloads";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>