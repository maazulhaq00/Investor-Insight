<?php
function backup()
{
	$data_n = array();
	/*
	$data_n["html_title"] = "title ";
	$data_n["html_heading"] = "heading ";
	$data_n["html_text"] = "text ";
	*/
	//Step 1		------------		Backup
	$data_n["html_title"] = "Backup ";
	$data_n["html_heading"] = "Backup ";


		$link = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
		mysql_select_db(DB_NAME,$link);


	//echo DB_SERVER." 0 ".DB_SERVER_USERNAME." 0 ". DB_SERVER_PASSWORD;
	$tab_status = mysql_query("SHOW TABLE STATUS");
	while($all = mysql_fetch_assoc($tab_status)):
		$tbl_stat[$all[Name]] = $all[Auto_increment];
	endwhile;
	unset($backup);
	$tables = mysql_list_tables(DB_NAME);
	while($tabs = mysql_fetch_row($tables)):
		$backup .= "--\n-- Table structure for `$tabs[0]`\n--\n\nDROP TABLE IF EXISTS `$tabs[0]`;\nCREATE TABLE IF NOT EXISTS `$tabs[0]` (";
		$res = mysql_query("SHOW CREATE TABLE $tabs[0]");
		while($all = mysql_fetch_assoc($res)):
			$str = str_replace("CREATE TABLE `$tabs[0]` (", "", $all['Create Table']);
			$str = str_replace(",", ",", $str);
			$str2 = str_replace("`) ) TYPE=MyISAM ", "`)\n ) TYPE=MyISAM ", $str);
			if(!$tbl_stat[$tabs[0]])
			{
				$tbl_stat[$tabs[0]] = 1;
			}
			$backup .= $str2." AUTO_INCREMENT=".$tbl_stat[$tabs[0]].";\n\n";
		endwhile;
		$backup .= "--\n-- Data to be executed for table `$tabs[0]`\n--\n\n";
		$data = mysql_query("SELECT * FROM $tabs[0]");
		while($dt = mysql_fetch_row($data)):
			$backup .= "INSERT INTO `$tabs[0]` VALUES('$dt[0]'";
			for($i=1; $i<sizeof($dt); $i++):
				$temp = str_replace("'", "''" ,$dt[$i]);
				$backup .= ", '".$temp."'";
			endfor;
			$backup .= ");\n";
		endwhile;
		$backup .= "\n-- --------------------------------------------------------\n\n";
	endwhile;
	$fName = "mysql ".date("d-m-Y H:i").".txt";

	$data_n["html_text"] = '<textarea style="width:600px; height:400px;">'.($backup).'</textarea>';
	return $data_n;
}
?>
