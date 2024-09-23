<?php
function dashboard2()
{
    $title = 'Dashboard';
	$action = $_GET["action"];
	$db = new db2();
	if($action == "detail")
	{
		$mysql_date = $_GET["date"];
		$date = date("d/m/Y", mysql_to_timestamp($mysql_date));
		$level_filter = '';
		if(is_teacher() || is_assistantteacher())
		{
		  $level_filter = ' AND level_id = '.$_SESSION["level_id"];
		}
	
		$sql = "select UNIX_TIMESTAMP(a.added_on) as added_on, a.students_id, a.students_name, bs.level_name, level_id, bs.id
		from 
		attendance a left join batch_to_students bs on a.students_id = bs.students_id AND a.batch_id = bs.batch_id
		 where (a.status = '1' OR a.status = 'P' OR a.status = 'L') AND date like '".$mysql_date."' $level_filter
		 ORDER BY level_id ASC";
		// debug_r($sql);
		// echo $sql;
		$result = $db->result($sql);
		// debug_r($result);
		$temp = '<!-- Main content -->
		<section class="content">
		  <!-- Default box -->
		  <div class="card">
			<div class="card-header">
			  <h3 class="card-title">Date : '.$date.'</h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				  <i class="fas fa-minus"></i>
				</button>
			  </div>
			</div>
			<div class="card-body">';
			$temp .= '
			<table class="table table-head-fixed text-nowrap">
			<thead>
			  <tr>
				<th>#</th>
				<th>Name</th>
				<th>Class</th>
				<th>Marked at</th>
			  </tr>
			</thead>
			<tbody>';
			$counter = 1;
			foreach($result as $a)
			{
				  $temp .= '<tr>
				  <td>'.$counter++.'</td>
					  <td><a target="_blank" href="students.php?action=edit_student&batch_id=7&center_id=91&programme_id=19&students_id='.$a['students_id'].'">'.$a['students_name'].'</a></td>
					  <td>'.$a["level_name"].'</td>
					  <td>'.date("H:i:s", $a["added_on"]).'</td>
				  </tr>';
				
			}
			$temp .= '
				</tbody>
			</table>';
  
			$temp .= '
  
			</div>
			<!-- /.card-body 
			<div class="card-footer">
			  Footer
			</div>
			<!-- /.card-footer-->
		  </div>
		  <!-- /.card -->
		</section>
		<!-- /.content -->';
		// debug_r($action);
		$data_n["html_head"] = $head;
		$data_n["html_title"] = $title;
		$data_n["html_text"] = $temp;
		return $data_n;
	}
	$sql = "SELECT MONTH(date) as month, MONTHNAME(date) month_name, count(date) total
	FROM attendance
	WHERE status = 1 OR status = 'P' OR status = 'L'
	GROUP BY YEAR(date), MONTH(date), date";
	// debug($sql);
	$result = $db->result($sql);
	$data_array = [];
	$month_name_array = [];
	$counter = 1;
	foreach($result as $a)
	{
		$month = $a["month"];
		$month_name = $a["month_name"];
		$total = $a["total"];
		$data_array[] = [$counter, (int)$total];
		$month_name_array[] = [$counter, $month_name];

		$temp .= '<tr>
			<td><a href="?action=detail&id='.$a['date'].'">'.$a['date'].'</a></td>
			<td>'.$a['total'].'</td>
		</tr>';
		$counter++;
	}
	// debug_r(json_encode($month_name_array));
	$head = '
	<script src="'.TEMPLATE_DIR.'plugins/flot/jquery.flot.js"></script>
	<script>
	/*
     * BAR CHART
     * ---------
     */
    var bar_data2 = {
		data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,19]],
		bars: { show: true }
	  }
  
    var bar_data = {
      data : '.json_encode($data_array).',
      bars: { show: true }
    }
	$(function(){
		$.plot("#bar-chart", [bar_data], {
			grid  : {
				borderWidth: 1,
				borderColor: "#f3f3f3",
				tickColor  : "#f3f3f3"
			},
			series: {
				bars: {
				show: true, barWidth: 0.5, align: "center",
				},
			},
			colors: ["#3c8dbc"],
			xaxis : {
				ticks: '.json_encode($month_name_array).'
			}
		});

		$.plot("#bar-chart2", [bar_data2], {
			grid  : {
				borderWidth: 1,
				borderColor: "#f3f3f3",
				tickColor  : "#f3f3f3"
			},
			series: {
				bars: {
				show: true, barWidth: 0.5, align: "center",
				},
			},
			colors: ["#3c8dbc"],
			xaxis : {
				ticks: [[1,"Monday"], [2,"Tuesday"], [3,"Wednesday"], [4,"Thursday"], [5,"Friday"], [6,"Saturday"]]
			}
		})
	})
    /* END BAR CHART */
	</script>';

	$temp = '
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<!-- Bar chart -->
				<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">
					<i class="far fa-chart-bar"></i>
					Monthly Attendance Summary
					</h3>

					<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
					</div>
				</div>
				<div class="card-body">
					<div id="bar-chart" style="height: 300px;"></div>
				</div>
				<!-- /.card-body-->
				</div>
				<!-- /.card -->
			</div><!--col-md-6-->
			<div class="col-md-6">
				<!-- Bar chart -->
				<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">
					<i class="far fa-chart-bar"></i>
					Weekly Attendance Summary
					</h3>

					<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
					</div>
				</div>
				<div class="card-body">
					<div id="bar-chart2" style="height: 300px;"></div>
				</div>
				<!-- /.card-body-->
				</div>
				<!-- /.card -->
			</div><!--col-md-6-->
		</div><!--row-->
	</section>

      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Statistics</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
		  ';

		  $sql = "SELECT count(id) as total, date FROM `attendance` 
		  WHERE status = 1 OR status = 'P'
		  GROUP by date
		  order by date ASC;";
		  $result = $db->result($sql);
		  $temp .= '
		  <table class="table table-head-fixed text-nowrap">
		  <thead>
			<tr>
			  <th>Date</th>';
			//levels
			foreach($_SESSION["data_level"] as $a)
			{
				$temp .= '<th>'.$a['level_name'].'<th>';
			}
			$temp .= '
				<th>Total</th>
			</tr>
		  </thead>
		  <tbody>';
		  foreach($result as $a)
		  {
				$temp .= '<tr>
				<td><a href="?action=detail&date='.$a['date'].'">'.$a['date'].'</a></td>
				';
				// $temp .= '<td>'.$a['date'].'</td>';
				foreach($_SESSION["data_level"] as $level)
				{
					$level_id = $level['level_id'];

					$sql = "SELECT count(a.id) as total, date FROM `attendance` a
						inner join batch_to_students bs on bs.students_id = a.students_id and bs.batch_id = a.batch_id 
					WHERE 
						(status = 1 OR status = 'P' OR status = 'L')
						AND bs.level_id = $level_id
						AND a.date = '".$a['date']."'
					GROUP by date
					order by date ASC;";
					// echo $sql;die;
					$result = $db->result($sql, 1);
					// debug_r($result);
					
					// debug_r($level_id);
					$temp .= '<td>'.$result['total'].'<td>';
				}
				$temp .= '<td>'.$a['total'].'</td>';
				$temp .= '</tr>';
			  
		  }
		  $temp .= '
		  	</tbody>
		  </table>';

		  $temp .= '

          </div>
          <!-- /.card-body 
          <div class="card-footer">
            Footer
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.content -->';
    $data_n["html_head"] = $head;
	$data_n["html_title"] = $title;
	$data_n["html_text"] = $temp;
	return $data_n;
}
function get_quotes()
{
	$db = new db2();
	$sql = "select * from quote order by RAND() limit 0,1";
	$result = $db->result($sql);
	$temp = '<div class="daily_question">
	<h1>Quote</h1>
	';
	$flag_start = true;
	foreach($result as $a)
	{
		$temp .= '<div>'.$a["quote_name"].'</div>
		
		<div style="text-align:right; font-weight:bold">
			<a href="print_quote.php?id='.$a["quote_id"].'" target="_blank">
				<img src="images/printer.png" height="22"/>
				Print
			</a>
		</div>';
	}
	$temp .= '</div>';
	return $temp;
}
function get_categories()
{
	$db = new db2();
	$sql = "select * from categories where parent_id = '0' order by sort desc";
	$result = $db->result($sql);
	$temp = '<UL id="menu">';
	foreach($result as $a)
	{
		$temp .= '<li><a href="category.php?id='.$a["categories_id"].'"><h2>'.$a["categories_name"].'</h2></a>
				<ul>';
		$sql2 = "select * from categories where parent_id = '".$a["categories_id"]."' order by sort desc";
		$result2 = $db->sql_query($sql2);
		while($b = mysql_fetch_array($result2))
		{
			$temp .= '<li><a href="category.php?id='.$b["categories_id"].'">'.$b["categories_name"].'</a></li>';
		}
		
		$temp .= '</ul>
		</li>';
	}
	$temp .= '</UL>';
	return $temp;
}