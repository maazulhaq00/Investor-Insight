<div class="quick_login">
	<div style="float:left">
	<?php 
	//debug_r($_SESSION);
	if($_SESSION["members_id"])
	{
	}
	else
	{?>
    <form action="member_login.php?action=login&url=<?php echo page_name()?>.php" method="post" name="form_quick_login">
    <input name="members_name" type="text" id="members_name" value="Login" onfocus="this.value=''" />
    <input name="members_password" type="password" id="members_password" value="Password" onfocus="this.value=''" />
    <input type="submit" value="Login" />
    </form>
    <?php 
	}
	?>
    </div>
    <div style="padding-top:5px; float:right">
    Welcome <?php 
	//debug_r($_SESSION);
	if($_SESSION["members_id"])
	{
		echo '<span style="font-weight:bold;">'.$_SESSION["members_name"].'</span>
		 | <a href="profile.php">Edit Profile</a>
		 | <a href="logout.php">Logout</a>';
	}
	else
	{
		echo 'Guest! | <a href="register.php">Register</a>';
	}
	?>
    </div>
</div><!--quick_login-->