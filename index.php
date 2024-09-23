<?php
include("includes/application_top2.php");
$data = get_tuple("html", page_name(), "html_name");
if(empty($data) || !isset($data["html_title"]) || !$data["html_title"])
{
	if(function_exists(page_name()))
	{
		eval("\$data = ".page_name()."();");
	}
	else
	{
        $data = [];
		$data["html_title"] = ucwords(page_name());
		$data["html_heading"] = ucwords(page_name());
		$data["html_text"] = 'Website Under Consturction';
	}
}
// if(empty($data) || $data["logo"])
// {
//     $data = [];
// 	$data["site"] = 'GREEN ISLAND YOUTH FORUM';
// 	$data["logo"] = 'images/Investor_insight.png';
// 	$data["banner"] = '<a href="#"><img  class="baner"src="images/banner_1.png" alt="" style="margin-top:39px"/></a>';
// }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Investor Insight</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include('template_parts/head.php'); ?>

    </head>
    <body>
        <?php include('template_parts/header.php'); ?>
        <?php include('template_parts/banner.php'); ?>
        
        <!-- About US Section Start -->
        <section class="about_us_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="ab_images">
                            <img src="images/home_01/1.jpg" alt=""/>
                            <!-- <a data-rel="lightcase" href="https://player.vimeo.com/video/337292310" class="vp_btn light_pops">Play<span><i class="bx bx-play"></i></span></a> -->
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 noPaddingRight">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 noPaddingRight">
                                <div class="ab_content">
                                    <h5>About Us</h5>
                                    <h2>Your Path to Financial Prosperity Starts with Investor Insight</h2>
                                    <p>At Investor Insight, we have been empowering our clients' financial success since 2021, leveraging decades of collective expertise. Our team of highly skilled professionals, including ACCA Members and Master’s Degree holders, boasts over 20 years of experience, making us a trusted partner in navigating complex financial landscapes.</p>
                                    <h6>Industries Served</h6>
                                    <ul class="list_ul">
                                        <li>Private Equity</li>
                                        <li>Real Estate</li>
                                        <li>Private Debt</li>
                                        <li>Hedge Funds</li>
                                        <li>Mutual Funds</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 noPaddingRight">
                                <div class="ab_content">
                                    <h6>Our Clients</h6>
                                    <ul class="list_ul">
                                        <li>Individuals with Private Personal Portfolio Managers (e.g. individual traders, Investment, Portfolio and Fund Managers)   </li>
                                        <li>High Net Worth Individuals or Family Offices</li>
                                        <li>Private/ Public Fund Managers including</li>
                                        <li>Hedge and Mutual fund managers</li>
                                        <li>Private Equity and Real Estate having complex structures in different Jurisdictions</li>
                                    </ul>
                                </div>                                
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </section>
        <!-- About US Section End -->

        <?php include('template_parts/facts.php'); ?>
        <?php include('template_parts/services.php'); ?>
        <?php echo quote(); ?>
        <?php include('template_parts/case_studies.php'); ?>
        <?php //include('template_parts/testimonial.php'); ?>
        <?php include('template_parts/footer.php'); ?>
    </body>
</html>