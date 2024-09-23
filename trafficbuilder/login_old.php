<?php 
//list($authUrl, $loginUrl) = get_login_links();


//Facebook Login URL END


if(!isset($_SESSION["users_id"]))
	$mess = "Login";
else
	$mess = "Main Menu";
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
	        
            
            
	<form id="form1" method="post" action="trafficbuilder/action.php?action=login&url=<?php echo page_url(); ?>" onsubmit="MM_validateForm('users_name','','R','users_password','','R');return document.MM_returnValue">
      <div class="form-group has-feedback">
        <input name="users_name" type="text" class="form-control" id="users_name" placeholder="email@example.com" tabindex="1" autocomplete="off" value="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="users_password" type="password" class="form-control" id="users_password" tabindex="2" autocomplete="off"  onfocus="this.value=''" value="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    

   <div class="social-auth-links text-center hidden">
      <p>- OR -</p>
      <a href="<?php echo $loginUrl; ?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      
      
<!--            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
-->      <a href="<?php echo $authUrl; ?>" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>

      
      
   <!--   <div class="g-signin2" id="login_button" data-onsuccess="onSignIn" data-theme="dark"></div>
    <script>
      function onSignIn(googleUser) {
		$('#login_button').hide();
		var profile = googleUser.getBasicProfile();
		var id_token = googleUser.getAuthResponse().id_token;
        // Useful data for your client-side scripts:
        var profile_data = {
				id:profile.getId(),
				id_token: id_token,
				full_name:profile.getName(),
				given_Name:profile.getGivenName(),
				family_name:profile.getFamilyName(),
				image_url:profile.getImageUrl(),
				email:profile.getEmail(),
				action: 'google_login'
		}
		jQuery('.login-box-msg').html('sending..');
        jQuery.ajax({
			url: 'facebook_login.php',
			method: "POST",
			data: profile_data
        })  .done(function( msg ) {
			$('#login_button').show();
			data = jQuery.parseJSON(msg);
			if(data.result == 'failure')
			{
				location.href='index.php';
			}
			//if(data.result == 'success')
			$('.login-box-msg').html('Sign in to start your session. <p style="color:#f00">Login Failed</p>');
		});
		/*
			console.log("ID: " + profile.getId()); // Don't send this directly to your server!
			console.log('Full Name: ' + profile.getName());
			console.log('Given Name: ' + profile.getGivenName());
			console.log('Family Name: ' + profile.getFamilyName());
			console.log("Image URL: " + profile.getImageUrl());
			console.log("Email: " + profile.getEmail());
		* /
        // The ID token you need to pass to your backend:
        //var id_token = googleUser.getAuthResponse().id_token;
        //console.log("ID Token: " + id_token);
      }
    </script>-->
    
    </div> <!---->
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="#" class="text-center">Register a new membership</a>
 	<!--  end login-inner -->
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="templates/template2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="templates/template2/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="templates/template2/plugins/iCheck/icheck.min.js"></script>
<script>
  jQuery(function () {
    jQuery('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
		        <?php 
					}
    echo $_SESSION["users_id"];die;
					?>