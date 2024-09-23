<?php
function import_data()
{
	$temp = '';
	$temp .='</table>';
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Import Data";
	$data_n["html_text"] = $temp;
	return $data_n;
}