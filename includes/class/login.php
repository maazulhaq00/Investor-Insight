<?php 
/* functions without return */
function login()
{
	$db = new db2();
    $head = '';
	$heading = 'Login';
	
	

	if (!user_not_logged_in()) redirect('my_account');

	// debug_r($_GET);

	if (isset($_GET["action"]) && $_GET["action"] == "login") {
		$email = $_POST["email"];
		$password = $_POST["password"];
		$currency = $_POST["currency"];
		$_SESSION["users_name_temp"] = $email;
		$_SESSION["users_password_temp"] = $password;
		$u = new users();
		$u->users_check2();
	}
    // debug_r($_REQUEST);
	// list($heading, $temp) = service_body($_GET['id']);    
	$temp = '
			<div class="col-lg-10 offset-lg-1 col-md-12">
				<div class="contact_form">
				'.(isset($_SESSION["error"]) &&  $_SESSION['error'] == true ? '<div class="tourmaster-notification-box tourmaster-failure">'.$_SESSION['error_message'].'</div>' : '').'
					<form method="post" action="?action=login&url='.page_url().'" id="login_form" autocomplete="off">
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<input type="email" name="email" class="required" placeholder="Your Email *" autocomplete="off"/>
							</div>
							<div class="col-lg-6 col-md-6">
								<input type="password" name="password" class="required" placeholder="Your Password *" autocomplete="off"/>
							</div>
							<div class="col-lg-12 col-md-12 text-center">
							<button type="submit" name="send_message" class="fnc_btn reverses"><span>Log in<i class="bx bx-right-arrow-alt"></i></span></button>
							<img src="images/loader.gif" alt="" class="fn_loader"/>
							<button onclick="location.href=\'forget_password.php\'" type="button" name="send_message" class="fnc_btn"><span>Forget Password<i class="bx bx-right-arrow-alt"></i></span></button>

							</div>
							<div class="col-lg-12 con_message"></div>
						</div>
					</form>
				</div>
			</div>';
	$data_n = [];
	$data_n["html_head"] = $head;
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = wrap_form($temp, '', '');
	return $data_n; 
}

function wrap_form($main_data, $heading, $main_heading = 'Members Area')
{
	$temp = '<!-- Contact Form Section Start -->
	<section class="comon_section contact_form_section" style="width: 100%;">
		<div class="container">';
	if($main_heading != '')
	{
		$temp .= '
			<div class="row">
				<div class="col-lg-12 text-center">
					<h5 class="sub_title">'.$main_heading.'</h5>
					<h2 class="sec_title">'.$heading.'</h2>
				</div>
			</div>';
	}
	$temp .= '
			<div class="row">'.$main_data.'</div>
		</div>
	</section>
	<!-- Contact Form Section End -->';
	return $temp;
}