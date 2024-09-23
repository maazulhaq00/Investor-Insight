<?php 
function email_contact()
{
	$data_n = array();
	$db = new db();
	/*
	$data_n["title"] = "title ";
	$data_n["heading"] = "heading ";
	$data_n["body"] = "text ";
	*/
	//Step 1		------------		Display all projects + Tasks
	/*
    [product_id] => 21
    [Requirements] => asd
    [Company_Name] => asd
    [Name] => asadds
    [Email3] => asd@asd.asd
    [Phone] => aad
    [Fax] => asd
    [Street_Address] => ads
    [City] => ads
    [State] => asd
    [Zip_Code] => ads
    [Country] => United States
	*/
	//
	if(!isset($_REQUEST["Email_Address"]) || $_REQUEST["Email_Address"] == "")
	{
		alert("Please fill the form");
		back();
		return;
	}

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('track_errors', true);

function DoStripSlashes($FieldValue) 
{ 
  if (is_array($FieldValue) ) { 
   return array_map('DoStripSlashes', $FieldValue); 
  } else { 
   return stripslashes($FieldValue); 
  } 
}

#----------
# FilterCChars:

function FilterCChars($TheString)
{
 return preg_replace('/[\x00-\x1F]/', '', $TheString);
}


if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $ClientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
 $ClientIP = $_SERVER['REMOTE_ADDR'];
}

$FTGFirst_Name = DoStripSlashes( $_REQUEST['First_Name'] );
$FTGSecond_Name = DoStripSlashes( $_REQUEST['Second_Name'] );
$FTGAddress_Street_1 = DoStripSlashes( $_REQUEST['Address_Street_1'] );
$FTGAddress_Street_2 = DoStripSlashes( $_REQUEST['Address_Street_2'] );
$FTGCity = DoStripSlashes( $_REQUEST['City'] );
$FTGZip_Code = DoStripSlashes( $_REQUEST['Zip_Code'] );
$FTGstate = DoStripSlashes( $_REQUEST['state'] );
$FTGDaytime_Phone = DoStripSlashes( $_REQUEST['Daytime_Phone'] );
$FTGEvening_Phone = DoStripSlashes( $_REQUEST['Evening_Phone'] );
$FTGEmail_Address = DoStripSlashes( $_REQUEST['Email_Address'] );
$FTGComments = DoStripSlashes( $_REQUEST['Comments'] );
$FTGbutton = DoStripSlashes( $_REQUEST['button'] );
$FTGbutton2 = DoStripSlashes( $_REQUEST['button2'] );



# Include message in error page and dump it to the browser

if ($ValidationFailed === true) {

 $ErrorPage = '<html><head><title>Error</title></head><body>Errors found: <!--VALIDATIONERROR--></body></html>';

 $ErrorPage = str_replace('<!--VALIDATIONERROR-->', $ErrorList, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:First_Name-->', $FTGFirst_Name, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Second_Name-->', $FTGSecond_Name, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Address_Street_1-->', $FTGAddress_Street_1, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Address_Street_2-->', $FTGAddress_Street_2, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:City-->', $FTGCity, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Zip_Code-->', $FTGZip_Code, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:state-->', $FTGstate, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Daytime_Phone-->', $FTGDaytime_Phone, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Evening_Phone-->', $FTGEvening_Phone, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Email_Address-->', $FTGEmail_Address, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:Comments-->', $FTGComments, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:button-->', $FTGbutton, $ErrorPage);
 $ErrorPage = str_replace('<!--FIELDVALUE:button2-->', $FTGbutton2, $ErrorPage);
  

 echo $ErrorPage;
 exit;

}
# Email to Form Owner

$emailSubject = FilterCChars("Email from Dawn Services USA ");

$emailBody = chunk_split(base64_encode("<html>\n"
 . "<head>\n"
 . "<title></title>\n"
 . "</head>\n"
 . "<body>\n"
 . "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n"
 . "  <tr>\n"
 . "    <td width=\"26%\" align=\"right\" bgcolor=\"#CCCCCC\"><strong>First Name:</strong></td>\n"
 . "    <td width=\"74%\" bgcolor=\"#EEE\">$FTGFirst_Name</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Second Name :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGSecond_Name</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Address Street 1 :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGAddress_Street_1</td>\n"

 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Address Street 2 :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGAddress_Street_2</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>City :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGCity</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Zip Code :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGZip_Code</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>State :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGstate</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Daytime Phone:</strong></td>\n"
 . "    <td bgcolor=\"#EEE\"> $FTGDaytime_Phone</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Evening Phone :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGEvening_Phone</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong> Email Address :<br/><br/>\n"
 . "   </strong></td>\n"
 . "    <td bgcolor=\"#EEE\"> $FTGEmail_Address</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>Comments :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$FTGComments</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td colspan=\"2\" align=\"right\" bgcolor=\"#CCCCCC\">&nbsp;</td>\n"
 . "  </tr>\n"
 . "  <tr>\n"
 . "    <td align=\"right\" bgcolor=\"#CCCCCC\"><strong>IP Address :</strong></td>\n"
 . "    <td bgcolor=\"#EEE\">$ClientIP</td>\n"
 . "  </tr>\n"
 . "</table>\n"
 . "</body>\n"
 . "</html>\n"
 . ""))
 . "\n";
 ini_set('sendmail_from', "$FTGEmail_Address");
 ini_set('SMTP', 'smtp.gmail.com');
 $emailTo = 'Contact <contact@smmoin.com>';
  
 $emailFrom = FilterCChars("$FTGEmail_Address");
  
 $emailHeader = "From: $emailFrom\n"
  . "MIME-Version: 1.0\n"
  . "Content-Type: text/html; charset=\"ISO-8859-1\"\n"
  . "Content-Transfer-Encoding: base64\n"
  . "\n";
  
echo   mail($emailTo, $emailSubject, $emailBody, $emailHeader);
	
	
	# Redirect user to success page
	$FTGcontact_name = str_replace("'", "&rsquo;", $FTGcontact_name);
	$FTGFirst_Name = str_replace("'", "&rsquo;", $FTGFirst_Name);
	$FTGSecond_Name = str_replace("'", "&rsquo;", $FTGSecond_Name);
	$FTGAddress_Street_1 = str_replace("'", "&rsquo;", $FTGAddress_Street_1);
	$FTGAddress_Street_2 = str_replace("'", "&rsquo;", $FTGAddress_Street_2);
	$FTGCity = str_replace("'", "&rsquo;", $FTGCity);
	$FTGZip_Code = str_replace("'", "&rsquo;", $FTGZip_Code);
	$FTGstate = str_replace("'", "&rsquo;", $FTGstate);
	$FTGDaytime_Phone = str_replace("'", "&rsquo;", $FTGDaytime_Phone);
	$FTGEvening_Phone = str_replace("'", "&rsquo;", $FTGEvening_Phone);
	$FTGEmail_Address = str_replace("'", "&rsquo;", $FTGEmail_Address);
	$FTGComments = str_replace("'", "&rsquo;", $FTGComments);
	
	$db= new db2();
	$sql = "INSERT INTO  `contact` (
			`contact_id` ,
			`contact_name` ,
			`First_Name` ,
			`Second_Name` ,
			`Address_Street_1` ,
			`Address_Street_2` ,
			`City` ,
			`Zip_Code` ,
			`state` ,
			`Daytime_Phone` ,
			`Evening_Phone` ,
			`Email_Address` ,
			`Comments`
			)
			VALUES (
			NULL,  '".$FTGcontact_name."',  '".$FTGFirst_Name."',  '".$FTGSecond_Name."',  '".$FTGAddress_Street_1."',  '".$FTGAddress_Street_2."',  '".$FTGCity."',  '".$FTGZip_Code."',  '".$FTGstate."',  '".$FTGDaytime_Phone."',  '".$FTGEvening_Phone."',  '".$FTGEmail_Address."',  '".$FTGComments."'
			);";
	$result = $db->sqlq($sql);
	//debug_r(base64_decode($emailBody));
	//header("Location: thanks.html");
	redirect('thanks.html');
	exit;
}
?>