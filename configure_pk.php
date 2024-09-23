<?php
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
	define('BASE_URL', 'http://localhost/investor_insight/');
	define('DB_NAME', 'investor_insight');
	define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
	define('DB_SERVER_USERNAME', 'root');
	define('DB_SERVER_PASSWORD', '');
} 
echo DB_NAME; die;
/*
define('DB_NAME','smmoin');
define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('FOOTER_TEXT', '');
*/
//Email SMTP
define('EMAIL_HOST', 'ta2899274@gmail.com');
define('EMAIL_PORT', '587');
define("EMAIL_LOGIN_ID", "ta2899274@gmail.com");
define("EMAIL_PASSWORD", "sigmas81234");

define("SITE_NAME", "Investor Insight");
define("SITE_ADMIN_EMAIL", "ta2899274@gmail.com");

//Template
define("TEMPLATE_DIR", "templates/template4/");
define("TEMPLATE", TEMPLATE_DIR . "index.php");
define("TEMPLATE_LOGIN", TEMPLATE_DIR . "login.php");
define("SHOW_LOGIN", false);

define("TEMPLATE_SITE", TEMPLATE_DIR . "forexschool/index.php");

//NOT_LOGGED_IN
define("NOT_LOGGED_IN", "loginfirst.php");
$dont_show_forms = array();
define('reCAPTCHA_site_key', '6LcM9BAoAAAAAMOY69djQKVUE4d5kpnk6je91AnF');
define('G_APP_SECRET', '6LcM9BAoAAAAANkLnQAmvXCRqYBg2mVwPnAKAGXf');
define("DEFAULT_MY_ACCOUNT_URL", 'dash');
define('number_of_pages', '20');