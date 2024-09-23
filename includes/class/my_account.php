<?php

function register($action = 'new')
{
    $heading = 'Register';
    form_submit_events();
    if(isset($_SESSION["users_id"]))
	if(is_login() && $action != 'edit')
	{
        //Send to quiz page
        redirect(DEFAULT_MY_ACCOUNT_URL);
		// return user_not_logged_in();
	}
	list($head, $temp) = get_register_content();
	$head .= '
    <style>
    .topbarBg {display: none;}
    h1.topbarText {
        display: none;
    }
    </style>
    ';
	$data_n = array();
    $data_n["html_head"] = $head;
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_banner"] = 'igap/images/banner-01.jpg';
	$data_n['html_text'] = $temp;
	return $data_n;
}
function my_account()
{
    if(!is_login())
	{
        return login();
		return user_not_logged_in();
	}
    // debug_r($_SESSION["groups_id"]);
    if(is_admin()) redirect(NOT_LOGGED_IN);
    $data_n = array();
    $temp = '';
	$action = $_GET["action"];
	// if(!$action)$action = 'edit';
    $user = get_client();
    // <script src="https://cdn.tailwindcss.com"></script>

    $head = '

    <link href="dist/output.css" rel="stylesheet">    ';
    /*		Update/View Profile		*/
	if($action == "edit")
	{
    	$data_n =   ('edit');
		$data_n["html_title"] = "View / Update Profile";
		$data_n["html_heading"] = "View / Update Profile";
		return $data_n;
	}
	elseif($action == "update")
	{
		profile_update();
	}
	else
	{   
		$temp .= get_sidebar().user_profile();
    }

    $data_n["html_head"] = $head;
	//$data_n["html_title"] = "Dashboard";
    $data_n["html_banner"] = 'igap/images/banner-01.jpg';
    $data_n["html_heading2"] = '<a class="tourmaster-user-content-title-link"
                               href="?action=edit">Edit
                                Profile</a>';
	$data_n["html_heading"] = "My Account";
	$data_n["html_wrapper"] = true;
    $heading_title = "Client Portal";
    $heading = "Welcome To Client Portal";
    $data_n["html_title"] = $heading_title;
    $data_n["html_heading"] = $heading;

	$data_n['html_text'] = wrap_form($temp, '', '');
	return $data_n;
}
function user_profile()
{
    $user = get_client();
    // debug_r($user);
    //'.$_SESSION['users_full_name'].'
    $users_picture_upload = $user["profile_photo_upload"];
    $title = 'Profile Details';
    if(page_name() == 'dash') $title = 'Dashboard';
    $temp = '
    <div class="col-lg-8 col-md-7">
    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">'.$title.'</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Welcome !</p>
    </div>
    <div class="mt-6 border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">'.$user['name'].'</dd>
        </div>
        
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900">Email address</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">'.$user['email'].'</dd>
        
    </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-900">Joined on</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">'.date("d/m/Y", strtotime($user['added_on'])).'</dd>
        </div>

        </dl>
    </div>
    </div>';
    return $temp;
}
function mark_as_used()
{
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Mark as Used";
	$data_n["html_heading"] = "Mark as Used";
	if(!is_admin())
	{
		$data_n["html_text"] = '<p>You need to login <strong>as Site Administrator</strong> in orders to proceed
				<strong>&lt;&lt;</strong>
				<a href="index.php">Click here to go back</a>
			</p>';
		return $data_n;
	}
	$data_n = array();
	$id = $_GET["id"];
	if(!$id)
	{
		$data_n["html_text"] = '<p>Invalid URL
				<a href="index.php">Click here to go back</a>
			</p>';
		return $data_n;
	}
	$user = get_tuple("users", $id, "users_id");
	$db = new db2();
	$sql =  "update orders set status = 1, updated_on = ".time()." where users_id = $id";
	$headers = headers();
	$message = '
	Dear '.$user["users_first_name"].' '.$user["users_last_name"].'<br />
	You have successfully redeemed your points. 
	<p>&nbsp;</p>
	<p>Dated: '.date("r").'</p>
	';
	mail($user["users_email"], "Congradulations. You have redeemed your points", $message, $headers);
	mail(SITE_ADMIN_EMAIL, $user["users_first_name"].' '.$user["users_last_name"]." have redeemed his points", $message, $headers);
	$result = $db->sql_query($sql);
	redirect("loyalty.php?users_id=$id");
	die;
}
function print_certificate()
{
	if(is_admin() && $_GET["users_id"])
	{
		$users_id = $_GET["users_id"];
	}
	else
	{
		$users_id = $_SESSION["users_id"];
	}
	echo '<link href="reset.css" rel="stylesheet" type="text/css" media="all">
	<link href="ana_haji.css" rel="stylesheet" type="text/css" media="all">
	<div id="logo"> <img src="images/Investor_insight.png"> </div>
	<div id="wrapper">
  <div id="header">
    <div id="menu_up" style="color:#ffcc00; font:bolder 17px arial">Loyalty Certificate (Customer ID: '.$users_id.')</div>
    <!--menu_up-->
    <div id="toll"></div><!--toll--> 
   
    <div id="login_form"></div>
    <!--login_form-->
    <div class="clearfix"></div>
    <div class="style-1">
      <div id="menu"></div>
      <!--style-1--> 
      
    </div>
    <!--menu-->
    <div class="clearfix"></div>
  </div>
  <!--header-->    <!--<div id="banner" style="background:url(images/banner2.png)"></div>
    <div class="style-2"></div>
  -->
<div class="clearfix" style="height:32px;"></div>
  <div id="left_column">
  	<div class="col2">
   	  <h1>Loyalty Points</h1>
   '.get_total_loyalty($users_id).'
   <p>&nbsp;</p>
   <p>Printed on : <strong>'.date("r").'</strong></p>
   </div>
  </div>
  <!--left_column-->
<div class="clearfix" style="height:32px;"></div>
<div class="clearfix"></div>
	<!--footer-->
<div class="clearfix" style="height:32px;"></div>
    
    <div class="style-1"></div>
	
    <div id="footer">
	&copy; Copyright ANA HAJI. All Rights Reserved.</div></div>
	';
	die;
}
function show_all_customers()
{
	$users_id = $_SESSION["users_id"];
	if(!is_admin())
	{
		$data_n["html_text"] = '<p>You need to login <strong>as Site Administrator</strong> in orders to proceed
				<strong>&lt;&lt;</strong>
				<a href="index.php">Click here to go back</a>
			</p>';
		return $data_n;
	}
	$data_n = array();
	$action = $_GET["action"];
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Loyalty Points";
	$data_n["html_heading"] = "Loyalty Points";
	$view = 1;
	if($id = $_GET["id"])
	{
		$user = get_tuple("users", $id, "users_id");
		if($user)
		{
			$view = 0;
			$temp .= get_total_loyalty($id);			
		}
		else
		{
			$temp .= '<div class="error">User does not exist</div>';
		}
	}
	
	if($view)
	{
		$sql = "select * from users where groups_id = 12";
		$db = new db2();
		$result = $db->sql_query($sql);
		$temp .= '
		<form action="" method="get" name="search_form">
		<p>Search By Customer ID: <input type="text" name="id" id="id"> <input type="submit" value="search"> </p>
		</form>
		<div class="clearfix" style="height:20px;"></div>
		<ul>';
		foreach($result as $a)
		{
			//debug_r($a);
			$temp .= '<li>'.$a["users_first_name"].' '.$a["users_last_name"] .' (ID : <strong>'.$a["users_id"].'</strong>)'.' <a href="?id='.$a["users_id"].'" target="_blank">View Details</a></li>';
		}
		$temp .= '</ul>';
	}
	$data_n["html_text"] .= $temp;
	return $data_n;
}
function form_submit_events()
{
    $db = new db2();
    $action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : '';
    if($action == "check_email")
    {
        $email_exists = get_tuple("client", request("email"), "email");
       
        echo($email_exists);
        if(!$email_exists)
        {
            echo json_encode(array('success' => 'true'));
        } else {
            echo json_encode(array('success' => 'false', 'error'=> "Email already exists"));
        }
        // debug($responseKeys);
        die;
    }
    else if ($action == "submit" )
    {
        // debug($_FILES);
        $all_data       = ($_REQUEST['data']);
        $data           = (array)json_decode($all_data);
        // $email;$comment;$captcha;
        
        $email          = $data["email"];
        $password       = $data["password"];
        // $comment     = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $captcha        = $data["token"];
        $secretKey      = G_APP_SECRET;
        $ip             = $_SERVER['REMOTE_ADDR'];
        $name           = $data["name"];
        $currency       = $data["currency"];
        try {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array('secret' => $secretKey, 'response' => $captcha,  'remoteip' => $_SERVER['REMOTE_ADDR']);
            $options = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            // echo 'response';
            // debug_r($response);
        }
        catch (Exception $e) {
            header('Content-type: application/json');
            echo json_encode(array('success' => 'false', 'error'=> "Issue with Captcha"));
            die;
        }

        $responseKeys = json_decode($response,true);
        // debug_r($responseKeys);
        // header('Content-type: application/json');
        if($responseKeys["success"]) {
            try
            {
                if(isset($_FILES["profile_photo_upload"]) && !empty($_FILES["profile_photo_upload"]))
                    $profile_photo_upload = upload($_FILES["profile_photo_upload"], "users_images");
                else
                    $profile_photo_upload = '';
                // $profile_photo_upload = upload($_FILES["profile_photo_upload"], "users_images");
                //Data is valid
                //insert data into database

                $token = session_id();
                $sql =
                 "INSERT INTO 
                `client`
                ( `name`, `profile_photo_upload`, `email`, `password`, `otp`, `currency`) 
                VALUES
                ('$name', '$profile_photo_upload', '$email', MD5('$password'), '$token', '$currency')";
                //debug_r($sql);
                $db->sqlq($sql);
                $client_id =  db2::$db->lastInsertId();
            }
            //catch exception
            catch(Exception $e)
            {
                echo json_encode(array('success' => 'false', 'error'=> $e->getMessage(), 'e'=>$e));die;
            }
  
            $subject = 'New Registration Started '.SITE_NAME;
            // debug_r($sql);
          
            // ->setFrom([$email])
            // // Include several To addresses
            // ->setTo(['it.greenisland@gmail.com' => 'New Registration'])
            // ->setCc(['hasnainwasaya@gmail.com' => 'IT Consultant'
            // ])->setFrom('info@greenislandtrust.org');

            $body = '<html>
            <body>
                <table>
                    <tr>
                    <td> IP   </td>
                    <td> '.$ip.' </td>
                    </tr>
                    <tr>
                        <td> Name   </td>
                        <td> '.$name       .' </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>'.$email.'</td>
                    </tr>
                    <tr>
                </table>
            </body>
            </html>';

            $attachments = [];

            $upload_file = $profile_photo_upload;
            $attachments[] = $upload_file;
            //debug_r($upload_file);
            
            // For the regular file types like docs, spreadsheets, or images, you can go without the content type
            // if($profile_photo_upload)
            // if($profile_photo_upload)
            //     $message->attach(Swift_Attachment::fromPath($profile_photo_upload)->setFilename('profile_photo_upload.jpg'));
            // if($profile_photo_upload)
            //     $message->attach(Swift_Attachment::fromPath($profile_photo_upload)->setFilename('profile_photo_upload.jpg'));
            
                // $headers = "From: International Ghadeer Awareness Program <info@greenislandtrust.org>\r\n".

                email(SITE_ADMIN_EMAIL, $subject, $body, $attachments);

                $link = BASE_URL.'verify?id='.$client_id.'&token='.$token;
              
              //SEND Welcome email to particiapnt
                $subject = "Verify Your Registration - Action Required | ".SITE_NAME;
                $body = "
                <p>Dear $name,</p>
                <p>Thank you for registering with ".SITE_NAME.". To ensure the security of your account and complete the registration process, please follow the link below:</p>
                <p><a href='$link'>Click Here to Complete Your Registration</a></p>
                <p>By clicking the link above, you will verify your registration and gain access to all the features and benefits 
                our platform has to offer. If the link does not work, please copy and paste the following URL into your web browser: $link</p>
                <p>If you did not register for ".SITE_NAME.", please disregard this email.</p>
                <p>Thank you for choosing ".SITE_NAME.". If you have any questions or need further assistance, please don't hesitate to contact our support team at ta2899274@gmail.com.</p>
                <p>Best regards,</p>
                ".SITE_NAME."<br>";

                $msg = email($email, $subject, $body);

                // die;
                // echo '
                // SMTP';
                // $transport = Swift_SmtpTransport::newInstance('localhost', 25);
                // $mailer = new Swift_Mailer($transport);
                // $mailer = new Swift_Mailer();
                // $mailer->send($message);
            
            echo json_encode(array('success' => 'true', 'msg' => $msg));
        } else {
            header('Content-type: application/json');
            echo json_encode(array('success' => 'false', 'error'=> $responseKeys["error-codes"][0], 'responseKeys'=>$responseKeys));
        }
        // debug($responseKeys);
        die;
    }
}
function get_register_content()
{
    $sql = "select * from currency";
		$db = new db2();
		$result = $db->sql_query($sql);
    $temp = '
        <div class="col-lg-10 offset-lg-1 col-md-12 contact_form">
            <form id="email-form" name="email-form" data-name="Email Form" onsubmit="return submit_form();">
                <label for="name">Name *</label><input name="name" type="text" class="w-input" id="name"
                    placeholder="Name in ALL CAPS" maxlength="256" data-name="Name" required="">
                
                <label for="profile_photo_upload">Profile Photo</label>
                <input type="file" class="w-input" name="profile_photo_upload" id="profile_photo_upload">
                
                <label for="email">Email Address *</label><input type="email" class="w-input" maxlength="256" name="email" data-name="Email" id="email" required="" placeholder="test@abc.com">

                <label for="currency">Currency *</label>
                <select class="w-input"  name="currency" data-name="Currency" id="currency" required="">';
                foreach($result as $a)
		{
			//debug_r($a);
			$temp .= '<option>'.$a["currency"].' </option>';
		}
               $temp .= ' </select>

                <label for="password">Password *</label>
            <input type="password" class="w-input" minlength="6" maxlength="256" name="password" id="password" required="" placeholder="123456">

            <label for="cpassword">Confirm Password *</label>
            <input type="password" class="w-input" minlength="6" maxlength="256" name="cpassword" id="cpassword" required="" placeholder="123456">

                <div class="text-block">
                <strong>Terms &amp; Conditions<strong>
            </p>
                

                <label class="w-checkbox checkbox-field"><input name="terms" type="checkbox"
                        class="w-checkbox-input" id="terms" value="1" data-name="Checkbox"><span
                        class="checkbox-label w-form-label"> &nbsp;I agree with the above Terms &amp; Conditions</span></label>

                </div>
                <div
                    class="w-form-formrecaptcha recaptcha g-recaptcha g-recaptcha-error g-recaptcha-disabled g-recaptcha-invalid-key">
                </div>
                <br>
                <input type="submit" value="Submit" data-wait="Please wait..."
                    class="submit-button w-button fnc_btn reverses">
            </form>
            <div class="w-form-done" style="display:none;">
                <div>Thank you! Your submission has been received!</div>
            </div>
            <div class="w-form-fail" style="display:none">
                <div>Oops! Something went wrong while submitting the form.</div>
            </div>
        </div>';

	$head = '
    <script src="https://www.google.com/recaptcha/api.js?render='.reCAPTCHA_site_key.'"></script>
    <script>
    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("cpassword").value;
        var passwordInput = document.getElementById("password");
        var cpasswordInput = document.getElementById("cpassword");

        if (password !== confirmPassword) {
            passwordInput.style.border = "2px solid red";
            cpasswordInput.style.border = "2px solid red";
        } else {
            passwordInput.style.border = "2px solid green";
            cpasswordInput.style.border = "2px solid green";
        }
    }

    // Attach event listeners to the password fields to trigger the checkPasswordMatch function
    document.getElementById("password").addEventListener("input", checkPasswordMatch);
    document.getElementById("cpassword").addEventListener("input", checkPasswordMatch);
    function submit_form()
    {
        // token = "";
        // e.preventDefault();
        const data = {
            token: "",
            name: $("#name").val(),
            password: $("#password").val(),
            cpassword: $("#cpassword").val(),
            currency: $("#currency").val(),
            email : $("#email").val(),
            
        };
        
        var fd = new FormData();

        var profile_photo_upload = $("#profile_photo_upload")[0].files;
        if(alert_and_focus("name", "Name")) return false;
        if(profile_photo_upload.length > 0){
            fd.append("profile_photo_upload",profile_photo_upload[0]);
        }


        if(alert_and_focus("email", "Email")) return false;
        if($("#terms:checked").val() == undefined)
        {
            alert("Please accept Terms & Conditions to proceed");
            return false;
        }
        if($("#terms:checked").val() == undefined)
        {
            alert("Please accept Terms & Conditions to proceed");
            return false;
        }

        $.ajax({
            type: "POST",
            url: "?action=check_email",
            data : {email : $("#email").val()},
        }).done(function(d) {
            try {
               r = JSON.parse(d);
            } catch (e) {
                alert("email already exsists");
                return false;
            }
            if(r.success == "true")
            {
                // alert("Form has been submitted successfully");
                // return false;
                grecaptcha.ready(function() {
                    grecaptcha.execute("'.reCAPTCHA_site_key.'", {
                            action: "submit",
                    }).then(function(token) {
                    // Add your logic to submit to your backend server here.
                    data.token = token;
                    fd.append("data", JSON.stringify(data))
                    $.ajax({
                        type: "POST",
                        url: "?action=submit",
                        contentType: false,
                        processData: false,
                        data : fd,
                    }).done(function(r) {
                        debugger;
                        try {
                            r = JSON.parse(r);
                            if(r.success == "true")
                            {
                                alert("Please check your email to verify and complete the registration process. Thank you!");
                                location.href= "index.php";
                            //    alert(r.msg);
                            }
                            else
                            {
                                alert("Error! "+r.error);
                            }    
                         } catch (e) {
                            if(r.success != "true")
                            {

                             alert(r+"Contact the Web Developer");
                             return false;
                            }
                         }
                    }).fail(function() {
                        // if (typeof error === "function") {
                        //     error.apply(this, arguments);
                        // }
                    });
                });
            });
            }
            else
            {
                alert("Error! "+r.error);
            }
        });
        return false;
    }
    function alert_and_focus(id, msg)
    {
        if($("#"+id).val() == "")
        {
            alert("Error! "+msg+" is required.");
            $("#"+id).focus();
            return true;
        }
        return false;
    }
    
    </script>
    <style>
        .link
        {
            text-decoration:none;
            color: #38a063;
        }
    </style>';
	return [$head, wrap_form($temp, 'Register')];
}
function user_not_logged_in()
{
	$data_n = array();
    $data_n["html_foot"] = "";
	$data_n["html_title"] = "Member Area";
	$data_n["html_heading"] = "Member Area";
	// $data_n["html_banner"] = 'igap/images/banner-01.jpg';
	$data_n['html_text'] = '<a href="login.php" style="color:black">Click here</a> &nbsp;to Login to access this area. ';
	return $data_n;
}
function forget_password()
{
    $action = request('action');
    $message = '';
    if($action == "forget")
    {
        $email = $_POST["email"];
        //debug($email);
        if($email)
        {
            $db = new db2();
            $sql = "select * from client where email like '".filter_var($email, FILTER_SANITIZE_EMAIL)."'";
            $client = $db->result($sql, 1);
            //debug_r($client);
            if($client)
            {
                //generate and send client reset password link 
                $reset_id = md5(session_id().time());
                //debug($reset_id);
                $link = BASE_URL.'reset_password.php?id='.$reset_id;
                $body = 'Dear '.$client['name'].',
                <p>Kindly note that a request for reset password has been generated by you, click the following link to reset your password. In case you have not generated the request kindly ignore this email.</p>
                <a href="'.$link.'">Reset Password</a>
                <p>&nbsp;</p>
                <p>Dated: '.date("r").'</p>';
                //$client["email"] = SITE_ADMIN_EMAIL;
                $email = $client["email"];
                $subject = 'Reset Password Request | Gohar e Hikmat ';
                $attachments = '';
                //debug_r($client["email"]);
                email($email, $subject, $body);
                //debug_r("Email sent");
                $sql_update = "update client set otp = '".$reset_id."' WHERE id = ".$client["id"];
                $db->sqlq($sql_update);
                // debug_r($sql_update);
                redirect("?action=success");
            }
            redirect("?action=not_found");
        }
    }
    elseif($action == "success")
    {
        $message = '<p style="background:#CFC;">A password reset link has been sent to your email. Please check your inbox as well as junk folder.</p>';
    }
    elseif($action == "not_found")
        $message = '<p style="background:#FCC;">If an account matching the provided details exists, we will send a password reset link. Please check your inbox.</p>';
    // debug_r($action);
    $temp = '
    <div class="traveltour-page-title-wrap container traveltour-style-custom traveltour-left-align">

    <div class="traveltour-page-wrapper" id="traveltour-page-wrapper">
    <div class="tourmaster-template-wrapper">
        <div class="tourmaster-container">
            <div class="tourmaster-page-content tourmaster-login-template-content container tourmaster-item-pdlr">';

    if($message) {
        $temp .= '<div class="tourmaster-notification-box tourmaster-failure">'.$message.'</div>';
    }
    $temp .= 'To reset your password, please enter your email address below
                <form class="tourmaster-login-form tourmaster-form-field tourmaster-with-border" method="post" action="forget_password.php?action=forget">
                    <div class="tourmaster-login-form-fields clearfix">
                        <p class="tourmaster-login-user"><input type="email" name="email" placeholder="Email" required></p>
                        <p class="tourmaster-login-submit">
                        <button type="submit" name="send_message" class="fnc_btn reverses"><span>Reset My Password <i class="bx bx-right-arrow-alt"></i></span></button>

                        <a href="register.php"><button type="button" name="send_message2" class="fnc_btn"><span>SIGN UP <i class="bx bx-right-arrow-alt"></i></span></button></a>
                            
                        <span class="tourmaster-login-lost-password"><a href="dash">SIGN IN</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>';
    $head = '<style>
    h1.traveltour-page-title {
        text-align:center;
        text-transform:uppercase;
        font-size: 30px;
        font-weight: bold;
        letter-spacing:1px;
    }
    .tourmaster-template-wrapper
    {
        text-align:center;
    }
    .tourmaster-template-wrapper input[type=text], .tourmaster-template-wrapper input[type=email], .tourmaster-template-wrapper input[type=password]
    {
        width:400px;
        height:40px;
        margin-top:15px;
    }
    .tourmaster-login-submit
    {
        width:400px;
        margin:0 auto;
        text-align:left;
    }
    .tourmaster-login-lost-password
    {
        text-align: right;
        float: right;
        line-height: 112px;
        color: black;
    }
    .tourmaster-login-lost-password a
    {
        color: black; text-decoration: underline;
        font-size:14px;
    }
    </style>';
	$data_n = array();
    $data_n["html_head"] = $head;
	$data_n["html_title"] = "Forget Password";
	$data_n["html_heading"] = "Forget Password";
	// $data_n["html_banner"] = 'igap/images/banner-01.jpg';
	$data_n['html_text'] = $temp;
	return $data_n;   
}

function reset_password()
{
    $id = request("id");
    $client = get_tuple("client", $id, 'otp');
    // debug($id);
    // debug_r($client);
    if($client)
    {
        if(request("action") == "reset_password") {
            if(request("new_password") == "") {
                // Password is empty
                redirect("reset_password.php?id=".$id);
            } else {
                if(request("new_password") == request("confirm_password")) {
                    // Passwords match
                    $new_password = request("new_password");
                    $sql = "UPDATE client SET reset_link = '', password = MD5('$new_password') WHERE id = ".$client['id'];
                    $db = new db2();
                    $db->sqlq($sql);
                    redirect("login.php");
                } else {
                    // Passwords don't match
                    redirect("reset_password.php?id=".$id);
                }
            }
        }
        $temp = '
        <div class="traveltour-page-title-wrap container traveltour-style-custom traveltour-left-align">
        <div class="traveltour-header-transparent-substitute" style="height: 17px;"></div>
        
        <div class="traveltour-page-wrapper" id="traveltour-page-wrapper">
        <div class="tourmaster-template-wrapper">
            <div class="tourmaster-container">
                <div class="tourmaster-page-content tourmaster-login-template-content container tourmaster-item-pdlr">';
    
        // if($message) {
        //     $temp .= '<div class="tourmaster-notification-box tourmaster-failure">'.$message.'</div>';
        // }
        $temp .= '
        To reset your password, please enter your new password below
        <form class="tourmaster-login-form tourmaster-form-field tourmaster-with-border" method="post" action="reset_password.php?action=reset_password&id='.$_GET["id"].'" autocomplete="off">
    <div class="tourmaster-login-form-fields clearfix">
        <p class="tourmaster-login-user"><input id="new_password" type="password" onkeyup="checkPasswordMatch()" name="new_password" placeholder="New Password" required autocomplete="off"></p>
        <p class="tourmaster-login-user"><input id="confirm_password" type="password" onkeyup="checkPasswordMatch()" name="confirm_password" placeholder="Confirm Password" required autocomplete="off"></p>
        <p class="tourmaster-login-submit">
            <button type="submit" name="send_message" class="fnc_btn reverses"><span>Reset My Password <i class="bx bx-right-arrow-alt"></i></span></button>
            <a target="_blank" href="register.php"><button type="button" name="send_message2" class="fnc_btn"><span>SIGN UP<i class="bx bx-right-arrow-alt"></i></span></button></a>
            <span class="tourmaster-login-lost-password"><a href="login.php" target="_blank">SIGN IN</a></span>
        </p>
    </div>
</form>
<script>
    function checkPasswordMatch() {
        var password = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password != confirmPassword) {
            document.getElementById("new_password").classList.add("password-mismatch");
            document.getElementById("confirm_password").classList.add("password-mismatch");
        } else {
            document.getElementById("new_password").classList.add("password-match");
            document.getElementById("confirm_password").classList.add("password-match");
        }
    }
</script>
                </div>
            </div>
        </div>';
        $head = '<style>
        .password-mismatch {
            border: 2px solid red;
        }
        .password-match {
            border: 2px solid green;
        }
        h1.traveltour-page-title {
            text-align:center;
            text-transform:uppercase;
            font-size: 30px;
            font-weight: bold;
            letter-spacing:1px;
        }
        
        .tourmaster-template-wrapper
        {
            text-align:center;
        }
        .tourmaster-template-wrapper input[type=text], .tourmaster-template-wrapper input[type=email], .tourmaster-template-wrapper input[type=password]
        {
            width:400px;
            height:40px;
            margin-top:15px;
        }
        .tourmaster-login-submit
        {
            width:400px;
            margin:0 auto;
            text-align:left;
        }
        .tourmaster-login-submit input{
            border-radius:0;
            margin-right:10px;
            padding: 10px 20px;
        }
        .tourmaster-login-lost-password
        {
            text-align: right;
            float: right;
            line-height: 112px;
            color: black;
        }
        .tourmaster-login-lost-password a
        {
            color: black; text-decoration: underline;
            font-size:14px;
        }
        </style>';
    }
    else
    {
        $temp = 'Error 400! Invalid Page';
    }
	$data_n = array();
    $data_n["html_head"] = $head;
	$data_n["html_title"] = "Forget Password";
	$data_n["html_heading"] = "Forget Password";
	// $data_n["html_banner"] = 'igap/images/banner-01.jpg';
	$data_n['html_text'] = $temp;
	return $data_n;   
}
function get_user($users_id = '', $tbl = 'users', $col = 'users_id')
{
    if(!$users_id) $users_id = $_SESSION["users_id"];
    $user = get_tuple($tbl, $users_id, $col);
    // debug_r($user);
    return $user;
}
function get_client($users_id = '')
{
    return get_user($users_id, 'client', 'id');
}
function get_sidebar()
{
    return ' <div class="col-lg-4 col-md-5 service_sidebar">
    <div class="widget service_list_widget">
        <h3 class="widget-title">Menu</h3>
        <ul>
            <li><a href="dash">Dashboard<i class="bx bx-right-arrow-alt"></i></a></li>
            <!--<li><a href="my_account">My Account<i class="bx bx-right-arrow-alt"></i></a></li>-->
            <li><a href="upload_files">Upload Files<i class="bx bx-right-arrow-alt"></i></a></li>
            <li><a href="data_center">Data Center<i class="bx bx-right-arrow-alt"></i></a></li>
            <li><a href="billing">Billing<i class="bx bx-right-arrow-alt"></i></a></li>
            <li><a href="logout.php">Logout<i class="bx bx-right-arrow-alt"></i></a></li>
        </ul>
    </div>
    <!--
    <div class="widget our_company_widget">
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
    </div>
    <div class="widget join_team_widget">
        <div class="join_team dark_modes">
            <img src="images/widgets/1.jpg" alt="">
            <div class="jt_content">
                <h5 class="sub_title">Join Us Now</h5>
                <h2 class="sec_title">Unique Solutions <br>For Your Service</h2>
                <a href="#" class="fnc_btn reverses"><span>Request a Quote<i class="bx bx-right-arrow-alt"></i></span></a>
            </div>
        </div>
    </div>
    -->
</div>';
}