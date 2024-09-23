<?php 
//list($authUrl, $loginUrl) = get_login_links();


//Facebook Login URL END


if(!isset($_SESSION["users_id"]))
	$mess = "Login";
else
	$mess = "Main Menu";

//debug_r($_REQUEST);
	  if ($_SESSION["action"] == "login")
					{
						$_SESSION["action"] = '';
						$u->users_check2();
					}
					if($_SESSION["permission_dynamic_cmm"] == 'Yes')
					{
						?>

<UL class="menu" id="services-list">
    <!-- permissions start -->
    <div id="welcome-note">
        Welcome <br /><?php echo $_SESSION["users_full_name"]; ?>
    </div>
    <?php $u->permissions();?>
    <li><a href="logout.php">Logout</a></li>
    <!-- permissions start -->
</UL>
<?php
					}
					else
					{
						echo($_SESSION["error_message"]);
					?>


<form action="trafficbuilder/action.php?action=login&url=<?php echo page_url();?>" method="POST"
    class="margin-bottom-0">
    <div class="form-group m-b-20">
        <input name="users_name" type="text" class="form-control form-control-lg inverse-mode text-black"
            placeholder="Username" required />
    </div>
    <div class="form-group m-b-20">
        <input name="users_password" type="password" class="form-control form-control-lg inverse-mode text-black"
            placeholder="Password" required />
    </div>
    <div class="checkbox checkbox-css m-b-20">
        <input type="checkbox" id="remember_checkbox" />
        <label for="remember_checkbox">
            Remember Me
        </label>
    </div>


    <div class="login-buttons m-t-20 m-b-40  text-inverse">
        <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
    </div>


    <!-- <img class="col-6 offset-3" src="templates/template3/assets/img/login-bg/focalpoint.png"/> -->

    <hr />
    <p class="text-center text-grey-darker mt-3,">
        © FCG All Right Reserved 2022
    </p>
</form>




</div>
<!-- end login-content -->
</div>


<!-- end login -->


</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="templates/template3/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="templates/template3/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="templates/template3/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
		<script src="../assets/crossbrowserjs/html5shiv.js"></script>
		<script src="../assets/crossbrowserjs/respond.min.js"></script>
		<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
<script src="templates/template3/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="templates/template3/assets/plugins/js-cookie/js.cookie.js"></script>
<script src="templates/template3/assets/js/theme/default.min.js"></script>
<script src="templates/template3/assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<script>
$(document).ready(function() {
    App.init();

    // $("#page-container").hide();
    // $("#myVideo").hide();
});

document.getElementById('myVideo').addEventListener('ended', myHandler, false);

function myHandler(e) {
    // $("#page-container").show();
    // $("#myVideo").hide();
}
</script>
</body>

</html>

<?php
					}
die;
?>
<script src="templates/template3/plugins/iCheck/icheck.min.js"></script>