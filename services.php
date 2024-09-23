<?php include("includes/application_top2.php");
$data = get_tuple("html", page_name(), "html_name");
if(!$data["html_title"])
{
	if(function_exists(page_name()))
	{
		eval("\$data = ".page_name()."();");
	}
	else
	{
		$data["html_title"] = ucwords(page_name());
		$data["html_heading"] = ucwords(page_name());
		$data["html_text"] = 'Website Under Consturction';
	}
}?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $data["html_title"]; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include('template_parts/head.php'); ?>

      
    </head>
    <body><?php
    include('template_parts/header.php');
        $service = get_tuple("service", $_GET["id"], 'id');
        if(!$service || empty($service)) redirect('index.php');
        extract($service);
        ?>
        <!-- Page Banner Section Start -->
        <section class="page_banner bg_19 no_overlay pb_light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pb_content text-left">
                            <h2><?=$name?></h2>
                            <p><a href="#">Services</a><b>-</b><span><?=$name?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Banner Section End -->

        <!-- Single Case Study Section Start -->
        <section class="comon_section single_case_study">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 service_sidebar">
                        <div class="widget service_list_widget">
                            <h3 class="widget-title">Our Services</h3>
                            <?=service_list()?>
                        </div>
                        <!-- <div class="widget our_company_widget">
                            <h3 class="widget-title">Our Company</h3>
                            <div class="wd_company_details">
                                <p>
                                    Our 2020 financial prospectus brochure for easy to read guide all of the services offered.
                                </p>
                                <div class="company_btns">
                                    <a href="#"><span>Company Report 2020</span><i class="bx bx-download"></i></a>
                                    <a href="#"><span>Company Presentation</span><i class="bx bx-download"></i></a>
                                </div>
                            </div>
                        </div> -->
                        <div class="widget join_team_widget">
                            <div class="join_team dark_modes">
                                <img src="images/widgets/1.jpg" alt="">
                                <div class="jt_content">
                                    <h5 class="sub_title">Join Us Now</h5>
                                    <h2 class="sec_title">Unique Solutions <br/>For Your Service</h2>
                                    <a href="#" class="fnc_btn reverses"><span>Request a Quote<i class="bx bx-right-arrow-alt"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="case_study_detail_content">
                        <?=$description?>
                        </div>
                        <div class="case_related_area">
                            <h3>Related Case Study</h3>
                           <?php echo service_2($id); ?> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Single Case Study Section End -->

        <?php include('template_parts/cta.php'); ?>
        <?php include('template_parts/footer.php'); ?>
    </body>
</html>