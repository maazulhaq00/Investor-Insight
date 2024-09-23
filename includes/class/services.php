<?php 
/* functions without return */
function services()
{
    $head = '';
    // debug_r($_REQUEST);
    list($heading, $temp) = service_body($_GET['id']);    
	$data_n = [];
	$data_n["html_head"] = $head;
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n; 
}
function service_body($name2)
{
    $service = get_tuple("service", str_replace('_', ' ', $name2), 'name');

    if(!$service || empty($service)) redirect(BASE_URL.'index.php');
    extract($service);
	$temp = '<!-- Single Case Study Section Start -->
        <section class=" single_case_study">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 service_sidebar">
                        <div class="widget service_list_widget">
                            <h3 class="widget-title">Our Services</h3>
                            '.service_list().'
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
                                <img src="'.BASE_URL.$image_upload.'" alt="">
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
                        '.$description.'
                        </div>
                        '. service_2($id).'
                    </div>
                </div>
            </div>
        </section>
        <!-- Single Case Study Section End -->';
    return [$name, $temp];
}

function service_2($service_id)
{
	$temp = '
    <div class="case_related_area">
        <h3>Related Service</h3>
        <div class="row">
            <div class="col-lg-12 noPadding">
                <div class="related_case_slider owl-carousel">
				';
	$db = new db2();
	$services = $db->result("select * from service WHERE id <> $service_id ORDER BY RAND() limit 0, 2");
	foreach($services as $a)
	{
		extract($a);
        $name2 = strtolower(str_replace(' ', '_', $name));
		$link = BASE_URL."services/$name2";
		$temp .= '<div class="case_01">
			<img src="'.BASE_URL.$image_upload.'" alt=""/>
			<div class="c01_cats">
				<a href="'.$link.'">'.$name.'</a>
			</div>
			<div class="c01_det">
				<h2><a href="'.$link.'">'.$name.'</a></h2>
				<p>
				'.$excerpt.'
				</p>
				<a class="learn_more_lnk" href="'.$link.'">Read More</a>
			</div>
		</div>';
	}
	$temp .= '
				</div><!--related_case_slider-->
			</div><!--.col-lg-12.noPadding-->
		</div><!--row-->
	</div><!--case_related_area-->';
    // debug_r($temp);
	return $temp;
}

function service_slider()
{
	$db = new db2();
	$services = $db->result("select * from service");
    $temp = '';
	foreach($services as $a)
	{
		extract($a);
        $name2 = strtolower(str_replace(' ', '_', $name));
		$link = BASE_URL."services/$name2";
		$temp .= '<div class="service_01">
			<div class="sr01_thumb">
				<img src="'.BASE_URL.$image_upload.'" alt="'.$name.'"/>
			</div>
			<div class="sr01_dtl text-center">
				<i class="'.$icon.'"></i>
				<h3><a href="'.$link.'">'.$name.'</a></h3>
				<p>'.$excerpt.'</p>
				<a class="learn_more_lnk" href="'.$link.'">Read More</a>
			</div>
		</div>';
 	}
    return $temp;
}
function service_list($class = '')
{
	$temp = '<ul '.($class ? ' class="'.$class.'"' : '').'>';
	$db = new db2();
	// $services = $db->result("select * from service");
	$services = $_SESSION['data_service'];
	$page_name = page_name();
	$current_id = '';
	if($page_name == 'services') $current_id = $_GET['id'];
	// debug_r($current_id);
	foreach($services as $a)
	{
		extract($a);
        $name2 = strtolower(str_replace(' ', '_', $name));
		$link = BASE_URL."services/$name2";
		$active ='';
		if($page_name == 'services' && $current_id == $name2) $active = ' class="active"';
		$temp .= '<li '.$active.'><a href="'.$link.'">'.$name.'</a></li>';
	}
	$temp .= '</ul>';
	return $temp;
}
