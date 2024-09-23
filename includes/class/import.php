<?php

function import()
{
	global $column_names, $should_be;
	/*	$column_names = array('application_date', 'traveller_name', 'passport_number', 'nationality_id', 'visa_type_id', 'client_id', 'typing_location_id', 'vendor_id', 'debit_', 'credit_', 'company_id');
	
	$column_names = array('', 'application_date', 'traveller_name', 'passport_number', 'description', 'nationality_id', 'visa_type_id', 'client_id', 'debit_', 'credit_', 'company_id', 'vendor_id', 'typing_location_id', 'sales_person_id', 'typing_location_id', 'ticket_date', 'air_line');
*/
	$db = new db2();
	$action = $_GET['action'];
	if ($action == 'import_confirm') {
		db2::$db->beginTransaction();
		$data = $_SESSION['temp_data']['insert_records'];
		// debug_r($data);
		foreach ($data as $row) {
			extract($row);
			//check if record with same client id and name exists
			$sql = "insert into client_data (client_id, valuation_points, fund_nav, tasi, sp_500, investments, cash_and_cash_equivalent, other_assets, realized_gain_or_loss, dividend, dividend_per_share, total_fund_commitment, assets_under_management , investor_count, holding_position)
					VALUES (
						'$client_id', '$valuation_points', '$fund_nav', '$tasi', '$sp_500', '$investments', '$cash_and_cash_equivalent', '$other_assets', '$realized_gain_or_loss', '$dividend', '$dividend_per_share', '$total_fund_commitment', '$assets_under_management', '$investor_count', '$holding_position'
					)";
			// debug_r($sql);
			$db->sqlq($sql);
			// db2::$db->commit();

		}
		$data = $_SESSION['temp_data']['updated_records'];
		// debug_r($_SESSION['temp_data']);
		foreach ($data as $row) {
			extract($row);
			//check if record with same client id and name exists
			$sql = "update client_data 
			SET
				valuation_points = '$valuation_points',
				fund_nav = '$fund_nav',
				tasi = '$tasi',
				sp_500 = '$sp_500',
				investments =  '$investments',
				cash_and_cash_equivalent = '$cash_and_cash_equivalent',
				other_assets = '$other_assets',
				realized_gain_or_loss = '$realized_gain_or_loss',
				dividend = '$dividend',
				dividend_per_share = '$dividend_per_share',
				total_fund_commitment = '$total_fund_commitment',
				assets_under_management = '$assets_under_management',
				investor_count = '$investor_count',
				holding_position = '$holding_position'
				
			where id = $id";
			// debug_r($sql);
			$db->sqlq($sql);
			// db2::$db->commit();

		}
		if (!DEBUG) {
			if (db2::$db->inTransaction())
				db2::$db->commit();
			// echo 'here';
			alert("Data Imported Successfully");
			redirect(page_url());
		} else {
			debug($sql);
			debug("Data Imported");
			db2::$db->rollBack();
			die;
		}
		$output = 'Data Inserted Sucessfully';
	} else if ($action == "import") {
		$data = $_SESSION['temp_data'];
		if ($data) {
			// debug($data);
			$output .= '<p>Data ready for import. <a href="?action=import_confirm">Click here to continue</a></p>
			Total Records to be imported = ' . count($data['insert_records']) . '<br>';
			// Total Records to be Updated = '.count($data['updated_records']).'<br>';
			//$output .= '<pre>'.print_r($data, 1).'</pre>';
			if ($data['updated_records']) {
				$output .= 'Total Records that will be updated: ' . count($data['updated_records']) . '<br>';
				$output .= '<table border="1" cellpadding="5" cellspacing="0" class="table-responsive">';
				$output .= '<thead><tr>';
				// Add table headers (assume the first row contains column names)
				foreach ($should_be as $column) {
					$output .= "<th>$column</th>";
				}
				$output .= '</tr></thead>';
				$output .= '<tbody>';
				
				// Loop through each row of updated records
				$i = 0;
				foreach ($data['updated_records'] as $curr_row) {
					$output .= '<tr>';
					foreach ($curr_row as $value) {
						$output .= '<td>' . htmlspecialchars($value) . '</td>';
					}
					$output .= '</tr>';
				}
				$output .= '</tbody></table>';
			}

			if ($data['insert_records']) {
				// Assuming you want to show the inserted records in a table too
				$output .= '<br>Total Records that will be inserted: ' . count($data['insert_records']) . '<br>';
				$output .= '<table border="1" cellpadding="5" cellspacing="0">';
				$output .= '<thead><tr>';
				foreach ($should_be as $column) {
					$output .= "<th>$column</th>";
				}
				$output .= '</tr></thead>';
				$output .= '<tbody>';
				
				foreach ($data['insert_records'] as $insert_row) {
					$output .= '<tr>';
					foreach ($insert_row as $value) {
						$output .= '<td>' . htmlspecialchars($value) . '</td>';
					}
					$output .= '</tr>';
				}
				$output .= '</tbody></table>';
			}
		} else {
			$output = 'No Data to be imported';
		}
		$output .= '<br><br>';
	}
	//debug_r($_SESSION["temp_removed_months"]);
	//unset($_SESSION["temp_removed_months"]);
	//debug_r($_SESSION);
	/*
		Now to optimize the runtime of script we will only run it for 10 seconds and then refresh the page 
		or
		we will use some sort of ajax to do this
	*/

	/*
		1. Display List of files from uploaded directory
		2. Get the selected file and start importing it 
		3. Remove the extra entry that has already been done 
		3.1. for removal go month and year wise. That is to remove the entire month and year whose data is to be inserted (this is done by $temp_removed_months array
	*/
	$data_n["html_head"] = '';

	// Open a known directory, and proceed to read its contents
	$temp .= '<div id="typography_lists" class="col-md-12">
					<div class="widget"><div class="box-body">';
	if ($action && $output) {
		$temp .= $output;
	}
	$temp .= '	<form enctype="multipart/form-data" method="post" action="?action=import">
								<input type="file" name="import">
								<input type="submit" name="submit" id="submit">
							</form>';

	$temp .= '
						</div> <!-- .box-body -->
		       		</div> <!-- .widget -->
				</div> <!-- .grid -->';

	$data_n["html_text"] = $temp;
	$data_n["html_title"] = "Import Excel";
	$data_n["html_heading"] = "Import Excel";
	return $data_n;
}
function generate_CSV()
{
}
function load_to_database()
{
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
	//if started then just save that time
	if (!$_SESSION["script_start"]) {
		$_SESSION["script_start"] = $starttime;
	}
	//
	$start = $_POST["line_number"];
	if (!$start || $start == "undefined" || $start == "") {
		$start = 1;
	}
	$lines_per_session = LINES_PER_SESSION;
	$file = $_POST["file"];
	if (!$file) die("File not Passed");
	///debug_r($start);
	$lines = file(DIR . "/" . $file);
	$db = new db2();
	for ($i = $start; $i < count($lines) && $i < ($start + $lines_per_session); $i++) {
		//END OF GET COLUMN NAMES
		//we have the column names
		// 8 == since we have only 8 columns in the databse
		$cols = explode(",", $lines[0], 8);
		//remove extra ",,,," from 8th column, i.e. column 7th Index of data
		$cols[7] = str_replace(",", '', $cols[7]);
		//just in case there are empty columns | This line is not necessary and probabbly should be removed
		$cols = array_filter($cols, 'strlen');
		//END OF GET COLUMN NAMES
		//we are traversing the data
		$data[0] = date('m/d/Y H:i', strtotime($data[0]));
		//there will be columns > 8 and index >7 but we will use only till 7th index
		//		since 8 cols only 
		//$data[7] = str_replace(",", '', $data[7]);

		//to make a dynamic query in case of swapping of columns
		$sql = "Insert into data (
		";
		$values = '';
		//now a new var $flag_data to check if there is data or not	| for every row
		$flag_data = false;
		for ($j = 0; $j < 8; $j++) {
			if ($cols[$j] == "Date") {
				$temp_dt = explode(' ', $data[$j]);
				//$temp_d == 12/1/2010 in mm/dd/YYYY format
				$temp_d = explode('/', $temp_dt[0]);
				//temp_r = 12:23 in HH:MM 24 hour format
				$temp_r = explode(':', $temp_dt[1]);
				//now to save date in mktime
				//debug($data[$j]);
				$final_date = mktime($temp_r[0], $temp_r[1], 0, $temp_d[0], $temp_d[1], $temp_d[2]);
				//get month range to delete
				$month_start_date = mktime(0, 0, 0, $temp_d[0], 1, $temp_d[2]);
				//Since 0 is the last day of previous month
				//for end date of current month we will need the previous date of the next month
				$month_end_date = mktime(0, 0, 0, $temp_d[0] + 1, 0, $temp_d[2]);
				//check if the month has already been removed or not
				if ($_SESSION["temp_removed_months"][$temp_d[2]] != $temp_d[0]) {
					$_SESSION["temp_removed_months"][$temp_d[2]] = $temp_d[0];
					//debug($temp_removed_months);
					$sql_delete = "delete from data where Date >= $month_start_date AND Date <= $month_end_date";
					$db->sql_query($sql_delete);
					//debug_r("range = ". date("r", $month_start_date) .' - '.date("r", $month_end_date));
					$sql_delete = '';
				}
				$data[$j] = $final_date;
				//debug(date("r", $data[$j]));
				//echo '<hr>';
				$flag_data = true;
			}
			if ($j > 0) {
				$sql .= ', ';
				$values .= ', ';
			}
			$sql .= $cols[$j];
			$values .= "'" . $data[$j] . "'";
		}
		//end of for


		$sql .= ') VALUES (' . $values . ')';
		if ($flag_data)
			$db->sql_query($sql);
		else
			echo $sql;
		//for(
	} //end of lines loop

	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$endtime = $mtime;
	$totaltime = ($endtime - $starttime);
	//$percent_done
	$total_lines = count($lines);
	$done = $start + $lines_per_session;
	if ($done > $total_lines) {
		$done = $total_lines;
	}
	$percent_done = round(($done) / $total_lines * 100, 2);
	if ($lines_per_session > $done)
		$lines_per_session = $done;
	echo '
	
	
	Total Script runtime is ' . $totaltime . ' seconds, to import ' . $lines_per_session . ' lines from ' . $start . ' to ' . $done . ' of total ' . $total_lines . '
	<div class="progress-bar primary">
		<div class="bar" style="width: ' . $percent_done . '%;">' . $percent_done . '%</div>
	</div>';
	if ($percent_done < 100) {
		echo '<script>
			load_file_start("' . $file . '", ' . ($start + $lines_per_session) . ');
		</script>';
	} else {
		//unset $_SESSION["temp_removed_months"]
		unset($_SESSION["temp_removed_months"]);
		$starttime = $_SESSION["script_start"];
		unset($_SESSION["script_start"]);
		$endtime = $mtime;
		$totaltime = ($endtime - $starttime);
		echo '<div class="progress-bar secondary">
					<div class="bar" style="width: 100%;">Total Time: ' . $totaltime . ' seconds</div>
				</div>';
	}

	//alert("Data Imported Successfully");
	//redirect("index.php");
	die;
}
function update_column($temp_val, $j, $do_replace = false)
{
	if (strtolower(trim($temp_val)) == "") return array('', '');
	global $temp_match_column;
	//debug($temp_val);
	$db = new db2();
	global $match_column;

	$temp_match_column = $match_column[$j];

	$temp_match_column_id = $temp_match_column . '_id';
	$temp_match_column_name = $temp_match_column . '_name';
	if ($temp_match_column) {
		if ($temp_match_column_name == "company_name" && $temp_val == '') {
			$temp_val = 'Karachi Branch';
		}
		//visa_type_id
		/*echo $j.'='.$temp_match_column;
			debug($temp_val);*/
		$filter = '';
		if ($temp_match_column_name == "visa_type_name") {
			$temp_match_column = 'account_heads';
			$temp_match_column_id = "id";
			$temp_match_column_name = "name";
			$filter = " AND LOWER(" . $temp_match_column_name . ") like '%inventory%'";
		}
		/*echo $temp_match_column;
			debug_r($temp_val);*/
		$search_match_sql = "select * From " . $temp_match_column . " where LOWER(" . $temp_match_column_name . ") like '%" . strtolower(trim($temp_val)) . "%' $filter";

		//			if($column_names[$j-1] == "debit_currency_id")

		//if($temp_match_column == "sales_person") debug($search_match_sql.'<hr>');
		//debug($search_match_sql);
		$result_match = $db->sql_query($search_match_sql, true);
		$data_match = $result_match->fetch(PDO::FETCH_ASSOC);
		/*if($temp_match_column_name != 'nationality_name' && $temp_match_column_name != 'vendor_name' && $temp_match_column_name != 'company_name' && $temp_match_column_name != 'client_name' && $temp_match_column_name != 'typing_location_name' && strtolower($temp_val) != '')
		{
			echo $temp_val;
			
			debug($data_match);
			debug_r($search_match_sql);
		}*/
		//$dta = get_tuple($temp_match_column, $temp_val, $temp_match_column.'_name');
		if ($data_match) {
			//found correctly
			if ($do_replace)
				$temp_val = $data_match[$temp_match_column_id];
		} else {
			//can add typing_location
			if ($temp_match_column == "vendor" || $temp_match_column == "client" || $temp_match_column == "sales_person") {
				if ($temp_val) {
					$sql_insert = "insert into $temp_match_column ($temp_match_column_name) values ('$temp_val')";
					$vendors_new = $temp_val;
					if ($do_replace) {
						$db->sqlq($sql_insert, true);
						$temp_val = db2::$db->lastInsertId();
					}
				}
			}
			/*
			//rest cannot be added
			elseif($temp_match_column_name == "typing_location")
			{
				
			}*/
			/*debug($temp_match_column);
			echo $search_match_sql;
			debug_r($temp_val.' missmatch');*/
		}
	}

	return array($temp_val, $vendors_new);
}
