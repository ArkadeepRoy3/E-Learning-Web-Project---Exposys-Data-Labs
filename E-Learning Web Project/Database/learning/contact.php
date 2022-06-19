
<?php

	if(isset($_POST['submit'])){        
            

            $subject = "Help us";
            
            // Status variable
            $Status_var = "";

            if( isset($_POST['name']) && !empty($_POST['name'])){
        
        		if(preg_match('/^[A-Za-z\s]+$/',$_POST['name'])){

          			$name = trim($_POST['name']);

        		}else{
          			$name_error = '<b class="text-danger text-center">Please enter correct Name</b>';
        		}

      		}else{
          		$name_error = '<b class="text-danger text-center">Please fill the Name field</b>';
		    }//name if condition
        
            if(isset($_POST['phone']) && !empty($_POST['phone'])){
                	
                    if(preg_match("/^([0-9]+)$/",$_POST['phone'])){
                    
                        $phone = trim($_POST['phone']);

                    }else{

                        $phone_error = '<b class="text-danger text-center">Please enter only degit numbers</b>';
                    }

            }else{     
                    $phone = "User Not Send";
            }// phone if condition

            if(isset($_POST['email']) && !empty($_POST['email'])){

        		if(preg_match("/^[^@ ]+@[^@ ]+\.[^@ \.]+$/",$_POST['email'])){

            		    $email = trim($_POST['email']);
        		}else{
     	           $mail_error = '<b class="text-danger text-center">Please enter valid Email</b>';
 	       		}
 	       	}else{
 	       		$mail_error = '<b class="text-danger text-center">Please fill Email field</b>';
 	       	}// mail if condition

 	       	if( isset($_POST['msg']) && !empty($_POST['msg']) ){
            	
            		$user_msg = trim($_POST['msg']);
            	
            }else{
            	$message_error = '<b class="text-danger text-center">Please fill the Message field.</b>';
            } // end of Message


        if( ( isset($name) && !empty($name) ) && ( isset($email) && !empty($email) ) && ( isset($user_msg) && !empty($user_msg) ) && ( isset($phone) && !empty($phone) ) ) {

            // preparing mail body 
            $message = "Email:".$email."\n";
            $message .= "Name:".$name."\n";
            $message .= "Phone:".$phone."\n";
            $message .= "Message:".$user_msg."\n";
            
            $to = "exceptionalprogrammers@gmail.com"; //Programmers email
            
            if(mail($to,$subject,$message)){
                
                $success= "<div class='alert alert-sucess'> Thank You For Your Feedback. <br>We Are Here For Achieve Your Expectations.<a class='close' data-dismiss='alert'>&times</a></div>";

            } else {
                $send_error = '<b class="text-danger text-center">Fail to send Mail. Please check Your Email Address&#44; Name &amp; Fill the message BOX. </b>';
            } 
            
            $header  = "exceptionalprogrammers@gmail.com";
            $subject = "Thank You $name";
            $message = "We are here for achieve your expectations. \nThank you for your FEEDBACK Form Exceptional Programmars.\n CEO EP";
        
            $to = $email; //Programmers email
            
            if(mail($to,$subject,$message,$header)){

                $success= "<div class='alert alert-sucess'> Thank You For Your Feedback <br>We Are Here For Achieve Your Expectations.<a class='close' data-dismiss='alert'>&times</a></div>";

            } else {
                $send_error = '<b class="text-danger text-center">Fail to send Mail. Please check Your Email Address&#44; Name &amp; Fill the message BOX. </b>';
            }  
        }  
        
        
    } // Submit If    

	
	include("header.php");
?>
		<!-- ======================Page Title======================== -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Contact</h1>
				<span>Get in Touch with Us</span>
				
			</div>

		</section><!-- #page-title end -->

		<!-- Page Sub Menu
		============================================= -->
		<div id="page-menu">

			<div id="page-menu-wrap">

			</div>

		</div><!-- #page-menu end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Postcontent
					============================================= -->
					<div class="postcontent nobottommargin">

						<?php 

							if(isset($message_error) || isset($name_error) || isset($phone_error) || isset($mail_error) || isset($send_error) ){

								echo "<div class='alert alert-danger'>";
                            
                            	echo "Please fill the form carefully and correctly<br>";

                            	echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            	</div>";
							}else if(isset($success)){

								if(isset($success)) echo $success;
							}

						?>

						<h3>Send us an Email</h3>

							<form class="nobottommargin" id="template-contactform" name="template-contactform" action="" method="post">

								<div class="form-process"></div>

								<div class="col_one_third">
									<label for="template-contactform-name">Name <small>*</small></label>
									<input type="text" placeholder="Name" id="template-contactform-name" name="name" class="sm-form-control required" />
								<?php if(isset($name_error)) echo $name_error; ?>
								</div>

								<div class="col_one_third">
									<label for="template-contactform-email">Email <small>*</small></label>
									<input type="email" id="template-contactform-email" placeholder="Email" name="email" class="required email sm-form-control" />
									<?php if(isset($mail_error)) echo $mail_error; ?>
								</div>

								<div class="col_one_third col_last">
									<label for="template-contactform-phone">Phone</label>
									<input type="text" id="template-contactform-phone" placeholder="Only Digits" name="phone" value="" class="sm-form-control" />
									<?php if(isset($phone_error)) echo $phone_error; ?>
								</div>

								<div class="clear"></div>
								<div class="clear"></div>

								<div class="col_full">
									<label for="template-contactform-message">Message <small>*</small></label>
									<textarea placeholder="Message" class="required sm-form-control" id="template-contactform-message" name="msg" rows="6" cols="30"></textarea>
									<?php if(isset($message_error)) echo $message_error; ?>
								</div>
								
								<div class="col_full">
									<button class="button button-3d nomargin" type="submit" id="template-contactform-submit" name="submit" value="submit">Send Message</button>
								</div>

							</form>
						
					</div><!-- .postcontent end -->

					<!-- Sidebar
					============================================= -->
					<div class="sidebar col_last nobottommargin">

						<address>
							<strong>Office:</strong><br>
							Karnataka,India<br>
						</address>

						<abbr title="Phone Number"><strong>Phone:</strong></abbr> 123456789<br>
						<abbr title="Email Address"><strong>Email:</strong></abbr> exceptionalprogrammers@gmail.com

					
						<div class="widget noborder notoppadding">

							<a target="_blank" href="" class="social-icon si-small si-dark si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a target="_blank" href="" class="social-icon si-small si-dark si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

							<a target="_blank" href="" class="social-icon si-small si-dark si-youtube">
								<i class="icon-youtube-play"></i>
								<i class="icon-youtube-play"></i>
							</a>

							<a target="_blank" href="" class="social-icon si-small si-dark si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>

							<a target="_blank" href="https://" class="social-icon si-small si-dark si-dropbox">
								<i class="icon-dropbox2"></i>
								<i class="icon-dropbox2"></i>
							</a>

							<a target="_blank" href="" class="social-icon si-small si-dark si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>

						</div>

					</div><!-- .sidebar end -->

				</div>

			</div>

		</section><!-- #content end -->

<?php include("footer.php"); ?>