<?php 

	//**************** Login File

	include("../include/config.php");
    
    if(isset($_POST['submit'])){

    	//Email Condition
	    if( isset($_POST['email']) && !empty($_POST['email']) ){
	        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
	            if(preg_match($pattern,$_POST['email'])){
	              $email = $_POST['email'];
	            }else{
	              $message_mail = '<b class="text-danger text-center">Please type correct Email</b>';
	            	
	            }
	        }else{
	          $message_mail = '<b class="text-danger text-center">Please fill Email field</b>';
	    	
	    }

		//Password Condition
	    if(isset($_POST['password']) && !empty($_POST['password'])){
	        if(strlen($_POST['password']) < 6){
	            $message_pass= '<b class="text-danger text-center">Your Password should be 6 character long</b>';
	            
	        }else{
	            $password = $_POST['password'];
	        }
	    }else{
	        $message_pass = '<b class="text-danger text-center">Please fill Password field</b>';   	
	    }


	    // Email Condition
    	if( (isset($email) && !empty($email)) && (isset($password) && !empty($password)) ){

	        $email = mysqli_real_escape_string($connection, $email);
	        $password = md5(mysqli_real_escape_string($connection, $password));
	        $check_sql = "SELECT * FROM `admin` WHERE admin_mail='$email' AND password = '$password'";
	        $result = mysqli_query($connection, $check_sql);
                       
            if($result){
                
                while($row = mysqli_fetch_assoc($result)){
                    
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['userName'] = $row['name'];
                    $_SESSION['adminType'] = $row['type'];
                    header('Location: home.php');                    
                }
            
        	}

        	
        	if($row <= 0)
        	{

            	$message_found = '<div class="text-danger text-center"><strong>OOP\'s!</strong> email or password not found</div>';
  
        	}//num rows if
    	}//isset if 

    }//signin if ends


 ?>






<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />
	<link rel="icon" type="image/png" href="images/tab.png" sizes="16x16">
	<link rel="icon" type="image/png" href="images/tab1.png" sizes="32x32">

	<!-- Stylesheets
	============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="../style.css" type="text/css" />
	<link rel="stylesheet" href="../css/dark.css" type="text/css" />
	<link rel="stylesheet" href="../css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="../css/animate.css" type="text/css" />
	<link rel="stylesheet" href="../css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="../css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- Document Title
	============================================= -->
	<title>Exceptional Programmers</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap nopadding">

				<div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('../images/login.png') center center no-repeat; background-size: cover;"></div>

				<div class="section nobg full-screen nopadding nomargin">
					<div class="container vertical-middle divcenter clearfix">

						<div class="row center">
							<a href="index.php"><img height="50px" src="../images/logo-footer.png" alt="Exceptional Programmers"></a>
						</div>

						<div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
							<div class="panel-body" style="padding: 40px;">
								<form id="login-form" name="login-form" class="nobottommargin" action="" method="post">
									<h3>Login to your Account</h3>

									<div class="col_full">
										<label for="login-form-email">Email:</label>
										<input type="email" id="login-form-username" name="email" value="" class="form-control not-dark" />
									</div>

									<div class="col_full">
										<label for="login-form-password">Password:</label>
										<input type="password" id="login-form-password" name="password" value="" class="form-control not-dark" />
									</div>

									<div class="col_full nobottommargin center">
										<button class="button button-3d button-black nomargin " id="login-form-submit" name="submit" value="login">Login</button>
										
									</div>	
									
								</form>

								<div class="line line-sm"></div>

								<div class="alert-danger">
								
								<?php 

								if(isset($message_pass) || isset($message_mail) || isset($message_found)){ 

									if(isset($message_mail))
										echo "$message_mail <br>";
									if (isset($message_pass)) 
										echo "$message_pass <br>";
									if (isset($message_found)) 
										echo "$message_found";

									}


								?>
									
								</div>
								
							</div>

						</div>


						<div class="row center dark"><small></small></div>

					</div>
				</div>

			</div>

		</section><!-- #content end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="../js/functions.js"></script>

</body>
</html>