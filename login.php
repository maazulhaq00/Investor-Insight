<?php
include('includes/application_top2.php'); 

if(	($_SESSION["users_id"] != "0") && isset($_SESSION["users_id"]) && $_SESSION["currency"])
		redirect('index.php');

$function_name = $_GET["page_function"];
$e = ("\$data_n = ".$_GET["page_function"]."();");

//debug_r($data_n);
//str_replace("" ,"", $data_n[]);	

$data =compile_top($data_n);

$data = str_replace("<h1>Login </h1>", "", $data);
//-----------------------------DATA WITH ALL CONTENTS LOADEDS


	
$data = str_replace("{__META_KEYWORDS__}", $data_n["html_meta_keywords"], $data);
$data = str_replace("{__META_DESCRIPTION__}", $data_n["html_meta_description"], $data);

//-----------------------------PRINT UNTILL </head>
$data_temp = explode("</head>", $data);
echo $data_temp[0];
$data = $data_temp[1];

echo ''.$data_n["head"];
require_once('trafficbuilder/head.php');
//require_once('trafficbuilder/cal.php'); 

echo '
<style type="text/css" title="currentStyle"> 
			@import "media/css/demo_table.css";
		</style> 
<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script> 
<script type="text/javascript" charset="utf-8">
			jQuery(document).ready(function() {
				jQuery(\'#example\').dataTable();
			} );
		</script>'."\n";
?>
<?php
echo '</head>';
//left column goes first
	

	//ADD Body
$data_temp = explode("{__BODY__}", $data);

echo $data_temp[0];
include('trafficbuilder/login.php');
$data = $data_temp[1];


echo $data_n["html_text"];

$data_temp = explode("{__LEFT_COLUMN__}", $data);
	$data = str_replace("{__LEFT_COLUMN__}", "", $data);
	echo $data_temp[0];
	$u = new users();
	if(SHOW_LOGIN || is_login()){
		include('trafficbuilder/login.php');
	}
	$data = $data_temp[1];
	if(!is_login())
{
?>
   <div id="services">Our Services</div>
           <div class="services">
                 <a href="stock_valuation_services.php"><img src="images/services/s1.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
</div>
           
              <div class="services">
                 <a href="supervision_services.php"><img src="images/services/s2.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
</div>
           
              <div class="services">
                 <a href="hypothetication_inspection.php"><img src="images/services/s3.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
</div>
           
              <div class="services">
                 <a href="clearing_forwarding.php"><img src="images/services/s4.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
</div>
           
              <div class="services">
                 <a href="clearing_forwarding.php"><img src="images/services/s5.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
              </div>
              
              <div class="services">
                 <a href="clearing_forwarding.php"><img src="images/services/s6.png" alt="Services" width="300" height="66"  vspace="5" border="0"/></a>
              </div>
            
<?php
}

//eval("\$data_n = ".page_name()."(".htmlspecialchars_decode1($html_text).");");

echo $data;
//$data = compile_left2($data);
include('includes/application_bottom.php');
?>