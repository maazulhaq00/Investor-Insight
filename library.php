<?php
include("includes/application_top2.php");
$data = get_tuple("html", page_name(), "html_name");
if(!$data["html_title"])
{
	if(function_exists(page_name()))
	{
		eval("\$data = ".page_name()."();");
	}
	else
	{
		$data["html_title"] = ucwords(str_replace("_", " ", page_name()));
		$data["html_heading"] = ucwords(str_replace("_", " ", page_name()));
		$data["html_text"] = 'Website Under Construction';
	}
}
if(!$data["logo"])
{
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $data["html_title"]; ?>- Najafi Cassette Library</title>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/jquery-3.6.3.min.js"></script>
<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css' />

<link rel="stylesheet" type="text/css" href="ddsmoothmenu.css" />
<script type="text/javascript" src="ddsmoothmenu.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>
<?php echo $data["html_head"];?>
</head>

<body>
<div id="wrapper">
  <div id="header">
    <div id="logo"><a href="index.php"><img src="logo.png" /></a></div>
    <!--logo-->
    
    <div id="smoothmenu1" class="ddsmoothmenu" style="margin-top:20px; margin-bottom:10px;">
      <ul>
        <li><a href="cassette_library.php"<?php echo (page_name() == "cassette_library" ?' class="selected"':'') ?>>Home</a></li>
        <li><a href="cassette_library_about.php"<?php echo (page_name() == "cassette_library_about" ?' class="selected"':'') ?>>About</a></li>
        <li><a href="cassette_library_activities.php"<?php echo (page_name() == "cassette_library_activities" ?' class="selected"':'') ?>>Activities</a> 
        </li>
        <li><a href="downloads.php"<?php echo (page_name() == "downloads" ?' class="selected"':'') ?>>Downloads</a> 
          <!--<ul>
  <li><a href=".php">Sub Item 1.1</a></li>
  <li><a href=".php">Sub Item 1.2</a></li>
  <li><a href=".php">Sub Item 1.3</a></li>
  <li><a href=".php">Sub Item 1.4</a></li>
  <li><a href=".php">Sub Item 1.2</a></li>
  <li><a href=".php">Sub Item 1.3</a></li>
  <li><a href=".php">Sub Item 1.4</a></li>
  </ul>--> 
        </li>
        <li><a href="contact.php"<?php echo (page_name() == "contact" ?' class="selected"':'') ?>>Contact</a></li>
      </ul>
      <br style="clear: left" />
    </div>
    <div id="menu" style="display:none;">
      <div id="news_ticker">
        <marquee behavior="scroll" direction="left" scrollamount="5" >
        <a href="downloads/NajafiDiniyatPamphlet2019.pdf"  target="_blank">Click here to download</a> Najafi Diniyat Exams 1440 / 2019 - Pamphlet
        </marquee>
      </div>
      <!--news_tickers-->
      <div class="clear"> </div>
      <!--clear--> 
    </div>
    <!--menu-->
    <div class="clear"> </div>
    <!--clear--> 
  </div>
  <!--header-->
  <div id="container">
    <div id="left_column">
      <div id="heading">
        <?php 
  
  $heading = explode(" ", $data["html_heading"]);
  if(count($heading) >= 2)
  {
	  $red_part = $heading[0];
	  
	  $blue_part = '';
	  for($i=1;$i<count($heading);$i++)
	  {
		  $blue_part .= ' '.$heading[$i];
	  }
  }
  else
  {
	  $red_part = implode(" ", $heading);
  }
  
  ?>
        <Span class="red"> <?php echo $red_part; ?> </Span> <span class="blue"> <?php echo $blue_part; ?> </span> </div>
      <!--heading--> 
      <?php echo $data["html_text"]; ?>
      <div class="clear"> </div>
      <p></p>
      <div id="order_now" style="display:none">
        <div class="heading"> <a href="order_form.html">
          <div id="white">Order Now </div>
          <!--white-->
          <div id="red"> for CD's of your choice </div>
          <!--red--></a> </div>
        <!--heading-->
        <div id="majalis"> Majalis, Nohay, Islamic Movies, Duroos, Fiqhi Masail, Seerat-e-Masoomen (a.s) and many more.... </div>
        <!--majalis-->
        <div class="logo"> <img src="images/Investor_insight.png" width="70" height="72" /> </div>
        <!--logo-->
        
        <div class="clear"></div>
      </div>
      <!--order_now-->
      <div id="offer" style="display:none"> <span class="headings"> SPECIAL OFFERS </span><!--headings-->
        <div class="clear" style="height:20px" ></div>
        <span class="ashra"> Ashra Majalis Of Moharram 1434 Hijri Video <br />
        Available in One CD (Real Video Format) </span><!--ashra-->
        <div class="clear"></div>
        <a href="order_form.html"><img src="images/order_now_link.png" /></a> </div>
      <!--offer--> 
    </div>
    <!--left_column-->
    <div id="right_column"  style="display:none">
      <div id="youtube"> </div>
      <!--youtube-->
      <div class="red_font"> Latest News </div>
      <!--red_font-->
      <ul>
        <strong>PLease Download Following Attachments</strong><br />
        <br />
        <li><a href="http://www.najafi.org/diniyat_results_19.php" target="_blank">Results of Najafi Diniyat Exams 1440, 2019.</a></li>
        <li> <a href="downloads/NajafiDiniyatPamphlet2019.pdf"  target="_blank">Click here</a> to <strong>Download Pamphlet of Najafi Diniyat Exams 1440 / 2019</strong></li>
		<li> <a href="downloads/TareekhIslam2019.pdf"  target="_blank">Click here</a> to <strong>Download selected page of  "Imam e Zamana(AJTF) (Waqia)" from Tareekh e Islam included in Syllabus.</strong></li>
      </ul>
      <div id="read_more"> <a href="read_more.html"><img src="images/read_more.png" /></a> </div>
      <img src="images/line.png" />
      <div id="red_font"> Subscribe to News Title </div>
      <!--red_font-->
      <div id="enter"> Enter Email Address : </div>
      <div id="email">
        <form id="users_name" name="users_name" method="post">
          <input class="users_email" name="users_email" id="users_email" type="text" />
          <input class="button" name="button" id="button" type="image" src="images/submit.png"  />
        </form>
      </div>
      <!--email-->
      <div id="submit"> </div>
      <!--submit--> 
    </div>
    <!--right_column-->
    <div class="clear"></div>
  </div>
  <!--container-->
  <div id="footer">
    <div id="links">
      <ul>
        <li><a href="index.html">Home |</a></li>
        <li><a href="about_us.html">About Us |</a></li>
        <li><a href="cassette_library_activities.php">Activities |</a></li>
        <li><a href="downloads.html">Downloads |</a></li>
        <li><a href="contact_us.html">Conatact Us |</a></li>
      </ul>
    </div>
    <!--links-->
    <div id="logo_bottom"> <img src="images/logo_bottom.PNG" /> </div>
    <!--logo_bottom-->
    <div class="clear"></div>
    <div id="copyright"> Copyright &copy; Najafi.org All Rights Reserved </div>
    <!--copyright--> 
    
  </div>
  <!--footer-->
  <div class="clear"> </div>
  <!--clear--> 
  
</div>
<!--wrapper-->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-5561451-16"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-5561451-16');
</script>

</body>
</html>