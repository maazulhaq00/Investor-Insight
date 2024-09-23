<?php
include('includes/application_top.php');
require 'vendor/autoload.php';
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$db = new db2();
$action = $_GET["action"];
if ($action == "import") {
	// debug_r($action);
	// $inputFileName = $_FILES['import']['tmp_name'];
	$inputFileName = upload($_FILES['import'], 'upload');
	if (empty($inputFileName)) {
		alert("Error! Please select the excel file for import.");
		redirect(page_url());
	}
	// $inputFileName = './sampleData/example1.xls';

	//  Read your Excel workbook
	try {
		$inputFileType = IOFactory::identify($inputFileName);
		$objReader = IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
	} catch (Exception $e) {
		die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage() . '<br>' . $inputFileName);
	}

	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
	$should_be = ["client_id", "valuation_points", "fund_nav", "tasi", "sp_500", "investments", "cash_and_cash_equivalent", "other_assets", "realized_gain_or_loss", "dividend", "dividend_per_share", "total_fund_commitment", "assets_under_management", "investor_count", "holding_position"];
	//  Loop through each row of the worksheet in turn
	// db2::$db->beginTransaction();
	$updated_records = [];
	$insert_records = [];
	for ($i = 1; $i <= $highestRow; $i++) {
		//  Read a row of data into an array
		$current_row_data = $sheet->rangeToArray(
			'A' . $i . ':' . $highestColumn . $i,
			NULL,
			TRUE,
			FALSE
		);
		$row = $current_row_data[0];
		foreach ($row as $j => $a) {
			// echo $j;
			if ($i == 1) {
				if ($should_be[$j] != $a) debug_r("column at $col $a should be " . $should_be[$j]);
			} else {
				$col_name = $should_be[$j];
				// if($col_name == 'total_fund_commitment')debug_r($j);
				if ($col_name == 'valuation_points') {
					$dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($a);
					$a = $dt->format('Y-m-d');
				}
				if ($j >= 11) $a = floatval($a);
				//insert data sql 
				// echo $i;die;
				$data[$i - 2][$col_name] = $a;
				// debug($a);
			}
			// echo('"'.$a)."\", ";
		}
		//  Insert row data array into your database of choice here
		if ($i >= 2) {
			$a = $data[$i - 2];
			$client_id = $a['client_id'];
			$valuation_points = $a['valuation_points'];
			// $dated = $a;
			$sql_previous = "select * from client_data where valuation_points = '$valuation_points' AND client_id = '$client_id'";
			$prev = $db->result($sql_previous, 1);
			if ($prev) {
				$a['id'] = $prev['id'];
				// debug_r($prev);
				//skip or update
				$updated_records[] = $a;
			} else {
				$insert_records[] = $a;
			}
			// extract($data[$i-2]);
			//check if record with same client id and name exists
			// $sql = "insert into client_data (client_id, valuation_points, fund_nav, tasi, sp_500, investments, cash_and_cash_equivalent, other_assets, realized_gain_or_loss, dividend, dividend_per_share, total_fund_commitment, assets_under_management, investor_count, holding_position)
			// 		VALUES (
			// 			'$client_id', '$valuation_points', '$fund_nav', '$tasi', '$sp_500', '$investments', '$cash_and_cash_equivalent', '$other_assets', '$realized_gain_or_loss', '$dividend', '$dividend_per_share', '$total_fund_commitment', '$assets_under_management', '$investor_count', '$holding_position'
			// 		)";
			// debug_r($sql);
			// $db->sqlq($sql);
			// db2::$db->commit();
		}
	}
	unlink($inputFileName);
	$_SESSION['temp_data'] = ['updated_records' => $updated_records, 'insert_records' => $insert_records];
	// $this->sqlq($sql);
	// if(db2::$db->inTransaction())
	// 	db2::$db->commit();
}
$function_name = isset($_GET["page_function"]) ? $_GET["page_function"] : '';
if (!$function_name) $function_name = page_name();
$e = ("\$data_n = " . $function_name . "();");
// debug_r($e);
eval($e);
$data = compile_top($data_n);
//-----------------------------PRINT UNTILL </head>
$data_temp = explode("</head>", $data);
echo $data_temp[0];
$data = $data_temp[1];

// echo ''.$data_n["head"].$data_n["html_head"];
require_once('trafficbuilder/head.php');
echo '</head>';
//left column goes first

$head = isset($data_n["head"]) ? $data_n["head"] : '';
$head .= isset($data_n["html_head"]) ? $data_n["html_head"] : '';
$data = str_replace('{__HEAD__}', $head, $data);
$data = str_replace('{__BODY__}', $data_n["html_text"], $data);

//ADD Body
// $data_temp = explode("{__BODY__}", $data);

// echo $data_temp[0];
// $data = $data_temp[1];


// echo $data_n["html_text"];
echo $data;
//$data = compile_left2($data);
include('includes/application_bottom.php');
