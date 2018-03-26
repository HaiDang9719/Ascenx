<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

Feb 02 2016 - Ported US3.2.1 top-nav

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"			=> "Register",
	"SIGNUP_BUTTONTEXT"		=> "Register Me",
	"SIGNUP_AUDITTEXT"		=> "Registered",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"			=> "** FAILED LOGIN **",
	"SIGNIN_TITLE"			=> "Please Log In",
	"SIGNIN_TEXT"			=> "Log In",
	"SIGNOUT_TEXT"			=> "Log Out",
	"SIGNIN_BUTTONTEXT"		=> "Login",
	"SIGNIN_AUDITTEXT"		=> "Logged In",
	"SIGNOUT_AUDITTEXT"		=> "Logged Out",
	));

//Navigation
$lang = array_merge($lang,array(
	"NAVTOP_HELPTEXT"		=> "Help",
	));

$query = $db->query("SELECT * FROM email");
$results = $query->first();

//Value of email_act used to determine whether to display the Resend Verification link
$email_act=$results->email_act;
$directToHome = $us_url_root."map.php";
?>
<!-- Navigation -->
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header ">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-top-menu-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="" href="<?=$us_url_root?>"><img class="img-responsive" src="<?=$us_url_root?>users/images/logo1.png" alt="" /></a>
			
		</div>
		<div class="collapse navbar-collapse navbar-top-menu-collapse navbar-right">
			<ul class="nav navbar-nav ">
				<?php if($user->isLoggedIn()){ //anyone is logged in?>
					
					
					<li class="hidden-md hidden-lg"><a class="dropdown-toggle" href="#" data-toggle="dropdown">FLIPPER<b class="caret"></b></a></a><ul class="dropdown-menu nav navbar-nav" id="Nav1">
                        <li role="presentation"><a href="http://gdc.tamduongs.com"> GDC</a></li>
                        <li role="presentation"><a href="http://tko.tamduongs.com"> JDC </a></li>
                        <li role="presentation"><a href="http://sg.tamduongs.com"> SDC </a></li>
                        
                    </ul>
					</li> <!-- Common for Hamburger and Regular menus link -->
						<li class="hidden-xs hidden-sm"><a class="dropdown-toggle" href="#" data-toggle="dropdown">FLIPPER<b class="caret"></b></a></a><ul class="dropdown-menu hidden-sm">
						<li ><a href="http://gdc.tamduongs.com"> GDC</a></li>
                        <li ><a href="http://tko.tamduongs.com"> JDC </a></li>
                        <li ><a href="http://sg.tamduongs.com"> SDC </a></li>
                        
					</ul>
					</li>
					<li class="hidden-md hidden-lg"><a class="dropdown-toggle" href="#" data-toggle="dropdown">ESS<b class="caret"></b></a></a><ul class="dropdown-menu nav navbar-nav" id="Nav1">
                        <li role="presentation"><a href="warehouseUSA.php?location=USA"> United States of America </a></li>
                        <li role="presentation"><a href="amsterdam.php?location=Amsterdam"> Amsterdam </a></li>
                        <li role="presentation"><a href="israel.php?location=Israel"> Israel </a></li>
                        <li role="presentation"><a href="taiwan-tn.php?location=Taiwan_TN"> Taiwan-TN </a></li>
                        <li role="presentation"><a href="taiwan-hsc.php?location=Taiwan_HSC"> Taiwan-HSC </a></li>
                        <li role="presentation"><a href="seoul.php?location=Seoul"> SEOUL </a></li>
                        <li role="presentation"><a href="tokyo.php?location=Tokyo"> Tokyo </a></li>
                        <li role="presentation"><a href="osaka.php?location=Osaka"> Osaka </a></li>
                        <li role="presentation"><a href="fukuoka.php?location=Fukuoka"> Fukuoka</a></li>
                        <li role="presentation"><a href="dublin.php?location=Dublin"> Dublin </a></li>
                        <li role="presentation"><a href="singapore.php?location=Singapore"> Singapore </a></li>
                        <li role="presentation"><a href="shanghai.php?location=Shanghai">Shanghai </a></li>
                    </ul>
					</li> <!-- Common for Hamburger and Regular menus link -->
						<li class="hidden-xs hidden-sm"><a class="dropdown-toggle" href="#" data-toggle="dropdown">ESS<b class="caret"></b></a></a><ul class="dropdown-menu hidden-sm">
						<li ><a href="warehouseUSA.php?location=USA"> United States of America </a></li>
                        <li ><a href="amsterdam.php?location=Amsterdam"> Amsterdam </a></li>
                        <li ><a href="israel.php?location=Israel"> Israel </a></li>
                        <li ><a href="taiwan-tn.php?location=Taiwan_TN"> Taiwan-TN </a></li>
                        <li><a href="taiwan-hsc.php?location=Taiwan_HSC"> Taiwan-HSC </a></li>
                        <li><a href="seoul.php?location=Seoul"> SEOUL </a></li>
                        <li><a href="tokyo.php?location=Tokyo"> Tokyo </a></li>
                        <li><a href="osaka.php?location=Osaka"> Osaka </a></li>
                        <li><a href="fukuoka.php?location=Fukuoka"> Fukuoka </a></li>
                        <li><a href="dublin.php?location=Dublin"> Dublin </a></li>
                        <li><a href="singapore.php?location=Singapore"> Singapore </a></li>
                        <li><a href="shanghai.php?location=Shanghai">Shanghai </a></li>
					</ul>
					</li>



						
					<!--li><a href="<?=$us_url_root?>users/account.php"><i class="fa fa-fw fa-user"></i> --><!--?php echo ucfirst($user->data()->username);?></a></li> --><!-- Common for Hamburger and Regular menus link -->
						

					<?php if($settings->messaging == 1){ ?>
					<li><a href="<?=$us_url_root?>users/messages.php"><i class="fa fa-fw fa-envelope"></i><?=$msgC?> <?=$grammar?></a></li>
					<?php } ?>
					<li class="hidden-sm hidden-md hidden-lg"><a href="<?php echo $directToHome;?>"><i class="fa fa-fw fa-home"></i> Home</a></li> <!-- Hamburger menu link -->
					
					<?php if (checkMenu(2,$user->data()->id)){  //Links for permission level 2 (default admin) ?>
						<li class="hidden-sm hidden-md hidden-lg"><a href="<?=$us_url_root?>mailist.php"><i class="fa fa-fw fa-envelope-o"></i>Mail List</a>
						<li class="hidden-sm hidden-md hidden-lg"><a href="<?=$us_url_root?>setting.php"><i class="fa fa-fw fa-cog"></i>Flipper Settings</a>
						</li> <!-- Hamburger menu link -->
						<li class="hidden-sm hidden-md hidden-lg"><a href="<?=$us_url_root?>export.php"><i class="fa fa-fw fa-download"></i>Export</a>
						</li> <!-- Hamburger menu link -->
						<li class="hidden-sm hidden-md hidden-lg"><a href="<?=$us_url_root?>users/admin.php"><i class="fa fa-fw fa-cogs"></i> Admin Dashboard</a></li> <!-- Hamburger menu link -->
					<?php } // is user an admin ?>
					<li class="dropdown hidden-xs"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-fw fa-cog"></i><b class="caret"></b></a> <!-- regular user menu -->
						<ul class="dropdown-menu"> <!-- open tag for User dropdown menu -->
							<li><a href="<?php echo $directToHome;?>"><i class="fa fa-fw fa-home"></i> Home</a></li> <!-- regular user menu link -->
							<li><a href="<?=$us_url_root?>users/account.php"><i class="fa fa-fw fa-user"></i> Account</a></li>
							
							
							<?php if (checkMenu(2,$user->data()->id)){  //Links for permission level 2 (default admin) ?>
							<li><a href="<?=$us_url_root?>mailist.php"><i class="fa fa-fw fa-envelope-o"></i>Mail List</a></li>
						<li><a href="<?=$us_url_root?>setting.php"><i class="fa fa-fw fa-cog"></i>Flipper Settings</a></li>
						<li><a href="<?=$us_url_root?>users/admin_warehouses.php"><i class="fa fa-fw fa-cog"></i>Warehouse Settings</a></li>
						<li><a href="<?=$us_url_root?>export.php"><i class="fa fa-fw fa-download"></i>Export </a></li>

					<?php } // is user an admin ?>
						<?php if($settings->messaging == 1){ ?>

							<li><a href="<?=$us_url_root?>users/messages.php"><i class="fa fa-fw fa-envelope"></i><?=$msgC?> Messages</a></li>
						<?php } ?>

									 <!-- regular user menu link -->

							<?php if (checkMenu(2,$user->data()->id)){  //Links for permission level 2 (default admin) ?>
								<li class="divider"></li>
								<li><a href="<?=$us_url_root?>users/admin.php"><i class="fa fa-fw fa-cogs"></i> Admin Dashboard</a></li> <!-- regular Admin menu link -->
							<?php } // is user an admin ?>
							<li class="divider"></li>
							<li><a href="<?=$us_url_root?>users/logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a></li> <!-- regular Logout menu link -->
						</ul> <!-- close tag for User dropdown menu -->
						<li><a>
							<div class="frmSearch">
						<input type="text" autocomplete="off" id="search-box" placeholder="Search" />
							<div class="dropdown-menu" id="suggesstion-box"></div>
							</div>
					</a></li>
					</li>
						

					<li class="hidden-sm hidden-md hidden-lg"><a href="<?=$us_url_root?>users/logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a></li> <!-- regular Hamburger logout menu link -->

				<?php }else{ // no one is logged in so display default items ?>
					<!--li><a href="<?=$us_url_root?>users/login.php" class=""><i class="fa fa-sign-in"></i> Login</a></li-->
					<!--li><a href="<?=$us_url_root?>users/join.php" class=""><i class="fa fa-plus-square"></i> Register</a></li-->
					<!--li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-life-ring"></i> Help <b class="caret"></b></a-->
					<ul class="dropdown-menu">
					<li><a href="<?=$us_url_root?>users/forgot_password.php"><i class="fa fa-wrench"></i> Forgot Password</a></li>
					<?php if ($email_act){ //Only display following menu item if activation is enabled ?>
					<li><a href="<?=$us_url_root?>users/verify_resend.php"><i class="fa fa-exclamation-triangle"></i> Resend Activation Email</a></li>
					<?php }?>
					</ul>
					</li>
				<?php } //end of conditional for menu display ?>
				
			</ul> <!-- End of UL for navigation link list -->
		</div> <!-- End of Div for right side navigation list -->
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=$us_url_root?>usersc/includes/navigation_script.js?n=1"></script>
<script type="text/javascript" src="<?=$us_url_root?>includes/navigation_script.js?n=1"></script>	



	</div> <!-- End of Div for navigation bar -->
</div> <!-- End of Div for navigation bar styling -->
