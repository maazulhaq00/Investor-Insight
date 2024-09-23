<?php
include('application_top2.php');
//alert(!$u->check_permissions() == 1);

if(	($_SESSION["users_id"] == "0") || !isset($_SESSION["users_id"])	)
		redirect('loginfirst.php');
if(($_SESSION["users_name"] != "admin"))

if(!$u->check_permissions())
{
	alert("You don't have rights to the page");
	redirect(NOT_LOGGED_IN);
}
//check permission and redirect
?>