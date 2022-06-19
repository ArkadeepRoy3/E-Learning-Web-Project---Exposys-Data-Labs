<?php

    // Watch From Video
?>

		<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<div id="vertical-nav">
			<div class="container clearfix">

				<nav>
					<ul>
						<li class="current"><a href="home.php"><i class="icon-home2"></i>Home</a></li>

                        <li><a href="categorie.php"><i class="icon-book2"></i>Categories</a></li>

						<li><a href="courses.php"><i class="icon-book3"></i>Courses</a></li>

						<li><a href="content.php"><i class="icon-line-content-left"></i>Content</a> </li>

						<li><a href="blog.php"><i class="icon-blogger"></i>Blog</a></li>

						<li><a href="library.php"><i class="icon-line-align-center"></i>Library</a></li>

						<li><a href="instructors.php"><i class="icon-guest"></i>Instructors</a></li>

                        <li><a href="team.php"><i class="icon-users"></i>Team</a></li>

                        <li><a href="logout.php"><i class="icon-line-power"></i>Logout</a></li>

					</ul>
				</nav>

			</div>
		</div>

				<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Welcome <strong><?php if(isset($loginName)) echo $loginName; ?></strong></h1>
			</div>

			<div id="page-menu-wrap">

				<div class="container clearfix">

					

				</div>

			</div>

		</section><!-- #page-title end -->

		<!-- Page Sub Menu
		============================================= -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
				<!-- ========================================== -->

				<div class="postcontent nobottommargin">

                    

                <?php

              

                        if(isset($message_name) || isset($message_picture) || isset($message_pass) || isset($message_c_pass) || isset($submit_message) || isset($admin_error)){
                           echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";
                            
                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Update Admin</h3>

                        <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nameId">Full Name</label>
                        <input type="text" id="nameId" placeholder="Full Name" value="<?php if(isset($adminName)) echo $adminName; ?>" name="fullname" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">                    
                       <label>Admin Type</label>
                        <select class="form-control"  name="admin_op">
                        <option value="">Select Option</option>
                        
                        <option <?php if($adminType == 'yes') { ?> selected <?php } ?> value="yes" >Yes Sophisticated</option>
                        
                        <option <?php if($adminType == 'no') { ?> selected <?php } ?> value="no">Not Sophisticated</option>

                        </select>
                    <?php if(isset($admin_error)) echo $admin_error; ?>
                    </div>

                    <div class="form-group">
                        <label for="emailId">Email</label>
                        <input type="email" id="emailId" placeholder="Email" value="<?php 
                        if(isset($adminMail)) echo $adminMail; ?>" name="email" class="form-control" title="someone@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                        <?php if(isset($message_email)){ echo $message_email; } ?>
                    </div>
                    <div class="form-group">
                            <img src="images/admin/<?php if(isset($adminPic)) echo $adminPic; ?>" width="100 px" height="100 px">
                    </div>
                    <div class="form-group">       
                        <label class="btn btn-success" for="my-file-selector">
                            <input id="my-file-selector" name="profilePic" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                           Change Profile Picture
                        </label>
                        <span class='label label-success' id="upload-file-info"></span>
                        <?php if(isset($message_picture)){ echo $message_picture; } ?>
                    </div>
                    <div class="form-group">
                        <label for="passwordId1">Password</label>
                        <input type="password" id="passwordId1" placeholder="Password" name="password" class="form-control" required minlength="6">
                        <?php if(isset($message_pass)){ echo $message_pass; } ?>
                    </div>
                    <div class="form-group">
                        <label for="passwordid2">Confirm Password</label>
                        <input type="password" id="passwordid2" placeholder="Confirm Password" name="c_password" class="form-control" required minlength="6">
                        <?php if(isset($message_c_pass)){ echo $message_c_pass; } ?>
                    </div>

                    <input type="hidden" value="<?php if(isset($adminPic)) echo $adminPic; ?>" name="picValue" />
                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>
                        


					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->

<?php include('footer.php'); 
}
?>