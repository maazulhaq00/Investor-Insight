<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  ?><?php  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Investor Insight - {__Content__title__}</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="css/reset_dynamic.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="{__META_KEYWORDS__}" />
<meta name="description" content="{__META_DESCRIPTION__}" />
<script src="trafficbuilder/jquery.min.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="js/jquery.cycle.all.2.74.js"></script>

<script>
	$(document).ready(function(){
		$('.slideshow').cycle({
			fx: 'fade',
			pause:  1
		});
	});
</script>
</head>

<body>
<div id="wrapper">
    <div id="header">
        <div id="logo"></div>
        <div id="banner">   
            <div id="nav">
            	<ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="features.html">Our Features</a></li>
                <li><a href="contact.html">Contact us</a></li>
                <li><a href="services.html">Services</a></li>
                <li>{__LOGIN__}</li>
              </ul>
          </div>
            <div id="anim" class="slideshow">
		    	 <img src="banner_images/01.png" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/02.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/03.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/04.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/05.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/06.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
                 <img src="banner_images/07.jpg" alt="S.M Moin (Pvt.) Ltd." width="747" height="205" border="0" />
            </div>
        </div>
    </div>
    <div id="body">
    	<div id="left_column">
			<h1>{__HEADING__} </h1>
             {__BODY__}
      </div>
        <div id="right_column">
        	<div id="matters">
        	 {__LEFT_COLUMN__}
             
              <div id="heading">Our Services</div>
           
              <div class="services">
                 <a href="stock_valuation_services.php"><img src="images/services/sv.png" alt="Services" width="263" height="49" vspace="5" border="0"/></a>
              </div>
           
              <div class="services">
                 <a href="supervision_services.php"><img src="images/services/ss.png" alt="Services" width="263" height="49" vspace="5" border="0"/></a>
              </div>
           
              <div class="services">
                 <a href="hypothetication_inspection.php"><img src="images/services/hypins.png" alt="Services" width="263" height="49" vspace="5" border="0"/></a>
              </div>
           
              <div class="services">
                 <a href="clearing_forwarding.php"><img src="images/services/cf.png" alt="Services" width="263" height="49" vspace="5" border="0"/></a>
              </div>
              <!--
<ul id="services-list">
          <li><a href="services.php">STOCKS VALUATION SERVICES</a></li>
          <li><a href="services.php">SUPERVISION SERVICES
          </a></li>
          <li><a href="services.php">CLEARING & FORWARDING SERVICES
          </a></li>
          <li><a href="services.php">HYPOTHETICATION INSPECTION & HYPOTHETICATED STOCKS
          </a></li>
        </ul>
       -->
       	  </div>
        </div>
    </div>
    <div id="footer">
Copyright &copy; Protected. All rights Reserved <?php echo date('Y');?> by <a href="http://www.smmoin.com">S.M. Moin(Pvt.) Ltd.</a><br />
<a href="http://www.trafficbuilder.biz" target="_blank">Web Development</a> by <a href="http://www.trafficbuilder.biz" target="_blank">Traffic Builder</a></div>    </div>
</div>
</body>
</html>