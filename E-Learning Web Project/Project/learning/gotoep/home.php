
<?php
    
    include("../include/config.php");

    if((!isset($_SESSION['userId']) && empty($_SESSION['userId'])) && (!isset($_SESSION['userName']) && empty($_SESSION['userName']))) {

        header('Location: index.php');
    }else{

        $loginName = $_SESSION['userName'];
        $loginId = $_SESSION['userId'];
        $power = $_SESSION['adminType'];
        $alertMessage = " ";
        
        /* %%%%%%%%%%%%% START CODE SUBMIT %%%%%%%%%%%% */

        if( isset($_POST['submit']) ){
            
            if($power == 'yes'){ //*************************

                if(isset($_POST["admin_op"]) && !empty($_POST["admin_op"])){

                    $admin_type = $_POST["admin_op"];
                } else {
                    $admin_error = '<b class="text-danger text-center">Please select Admin Type option.</b>';
                }       

                //Name Condition
                if( isset($_POST['fullname']) && !empty($_POST['fullname'])){
                    
                    if(preg_match('/^[A-Za-z\s]+$/',$_POST['fullname'])){
                      $name = mysqli_real_escape_string($connection,$_POST['fullname']);
                    }else{
                      $message_name = '<b class="text-danger text-center">Please type correct Name</b>';
                    }

                  }else{
                      $message_name = '<b class="text-danger text-center">Please fill the Name field</b>';
                }



                if( isset($_POST['email']) && !empty($_POST['email']) ){
                    $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
                        
                        if(preg_match($pattern,$_POST['email'])){
                          $cemail = mysqli_real_escape_string($connection,$_POST['email']);  
                          
                          $query = "SELECT * FROM `admin` WHERE admin_mail='$cemail' ";
                          $result = mysqli_query($connection, $query);
                          if(mysqli_num_rows($result) > 0){
                                $message_email = '<b class="text-danger text-center">Email already exists try again.</b>';
                          }else{

                            $email = mysqli_real_escape_string($connection,$_POST['email']);
                            
                            }
                        }else{
                          $message_email = '<b class="text-danger text-center">Please type correct email</b>';
                        }
                }else{
                      $message_email = '<b class="text-danger text-center">Please fill email field</b>';
                }//email if condition


                if( !isset($_POST['password']) && empty($_POST['password'])){
                    $message_pass = '<b class="text-danger text-center">Please fill the password field</b>';
                }
                
                //Password Condition
                if(isset($_POST['c_password']) && !empty($_POST['c_password'])){
                    
                    if($_POST['c_password'] != $_POST['password']){
                        $message_c_pass = '<b class="text-danger text-center">Please write same password in both fields</b>';
                      }else{

                              if(strlen($_POST['password']) < 6){

                                    $message_pass = '<b class="text-danger text-center">your password should be 6 character long</b>';
                                }else{
                                    $password = md5(mysqli_real_escape_string($connection,$_POST['password']));
                                }
                            }
                }else{
                    $message_c_pass = '<b class="text-danger text-center">Please fill the confirm password field field</b>';
                }
               



                if( isset($_FILES["profilePic"]["name"]) && !empty($_FILES["profilePic"]["name"]) ){
                    
                    $target_dir = "images/admin/";
                    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image

                    $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
                    if($check !== false) {
                        
                        $uploadOk = 1;
                    } else {
                        $message_picture  = '<b class="text-danger">File is not an image</b>';
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["profilePic"]["size"] > 5000000) {
                        $message_picture =  '<b class="text-danger">Sorry, your file is too large.</b>';
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $message_picture =  '<b class="text-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed</b>';
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk != 0) {
                        $temp = explode(".", $_FILES["profilePic"]["name"]);
                        $newfilename = mysqli_real_escape_string($connection,round(microtime(true)) . '.' . end($temp));
                        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_dir . $newfilename)) {
                            
                        } else {
                            $message_picture =  '<b class="text-danger">Sorry, there was an error uploading your file';
                        }
                    }
                }else{
                    $message_picture =  '<b class="text-danger">Please Select Your Profile picture</b>';
                }



                if( ( isset($name) && !empty($name) ) && ( isset($admin_type) && !empty($admin_type) ) && ( isset($email) && !empty($email) ) && ( isset($password) && !empty($password) ) && ( isset($newfilename) && !empty($newfilename) ) ){



                    $check_email = "SELECT * FROM `admin` WHERE 'email' = '$email'";

                    $check_res = mysqli_query($connection, $check_email);
                    if(mysqli_num_rows($check_res) > 0){
                        $message_email = '<b class="text-danger text-center">This email already exists try another one</b>';
                }else{

                    $insert_query = "INSERT INTO `admin` (name, admin_mail,  password, profilePic, type) VALUES ('$name','$email','$password','$newfilename','$admin_type')";


                    if(mysqli_query($connection, $insert_query)){
                        
                       
                        header('Location: home.php#end');
                    }else{
                        $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to signup please try later
                        </div>';
                    }
    
                }       
            } // end of if 

        }else{
    
             $alertMessage = "<div class='alert alert-danger'> 
                <p>You are not a Sophisticated Admin. So, You cannot right to delete any Admin <strong>THANK YOU.</strong> </p><br>       
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                </div>";    
        } // *******************************
    }//submit button

       /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */


    if(isset($_GET['sucess'])){

        $alertMessage = "<div class='alert alert-success'> 
        <p>Record <strong>Deleted</strong> successfully.</p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";

    }

    if(isset($_GET['delid'])){ 

        $deluser = $_GET['delid'];

        if($power == 'yes'){

           if ($deluser != 1) {
                           
            $alertMessage = "<div class='alert alert-danger'> 
                <p>Are you sure want to delete this Admin? No take baacks!</p><br>
                    <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$deluser' method='post'>
                       <input type='submit' class='btn btn-danger btn-sm'
                       name='confirm-delete' value='Yes' delete!>
                       <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a> 
                        
                    </form>
                </div>";
            } else {

                $alertMessage = "<div class='alert alert-danger'> 
                <p>Please Chaudhry cannot Delete yourself <strong>THANK YOU.</strong> </p><br>       
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                </div>";
            }        
        }else{
            $alertMessage = "<div class='alert alert-danger'> 
            <p>You are not a Sophisticated Admin. So, You cannot right to delete any Admin <strong>THANK YOU.</strong> </p><br>       
            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
            </div>";
        }
    }


    // return from Update
    if(isset($_GET['back'])){

        $back = $_GET['back'];

        if($back!=2){
                $update_status = "<div class='alert alert-danger'> 
        <p>You are not a Sophisticated Admin. You can update your own record.<strong>THANK YOU.</strong> </p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";
        }else{

            $update_status = "<div class='alert alert-success'> 
        <p>Record Updated successfully.</p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";
        }

    } 


     // conform delete button
    if(isset($_POST['confirm-delete'])){

        $id = $_GET['id'];

        // Delete file from folder
        $query2 = "SELECT * FROM `admin` WHERE id='$id' ";

        $result2 = mysqli_query($connection, $query2);

        if(mysqli_num_rows($result2) > 0){
        
                        //We have data 
                        //output the data
         while( $row2 = mysqli_fetch_assoc($result2) ){
                
                $base_directory = "images/admin/";
                if(unlink($base_directory.$row2['profilePic']))
                    $delVar = " ";  
         }}
 
        // new database query 
        $query = "DELETE FROM `admin` WHERE id='$id'";
        $result = mysqli_query($connection,$query);
        
        if($result){
            // redirect
            header("Location: home.php?sucess=1");
        } else {
                     echo "Error".$query."<br>".mysqli_error($conn);
                }
    }
    include('header.php');
    

    
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
        <section id="page-title" style="margin-padding: 0px;">

            <div class="container clearfix">
                <h1>Welcome <strong><?php if(isset($loginName)) echo $loginName; ?></strong></h1>
            </div>


            <div id="page-menu-wrap">

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

                    echo $alertMessage; 
                    if(isset($update_status)) echo $update_status;

                        if(isset($message_name) || isset($message_picture) || isset($message_pass) || isset($message_c_pass) || isset($submit_message) || isset($admin_error)){
                            
                            echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";

                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Insert Admin</h3>

                        <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nameId">Full Name</label>
                        <input type="text" id="nameId" placeholder="Full Name" name="fullname" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">                    
                       <label>Admin Type</label>
                        <select class="form-control"  name="admin_op">
                        <option value="">Select Option</option>
                        <option value="yes">Yes Sophisticated</option>
                        <option value="no">Not Sophisticated</option>
                        </select>

                    <?php if(isset($admin_error)) echo $admin_error; ?>
                    </div>


                    <div class="form-group">
                        <label for="emailId">Email</label>
                        <input type="email" id="emailId" placeholder="Email" name="email" class="form-control" title="someone@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                        <?php if(isset($message_email)){ echo $message_email; } ?>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-success" for="my-file-selector">
                            <input id="my-file-selector" name="profilePic" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                            Profile Picture
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
                        <label for="passwordId2">Confirm Password</label>
                        <input id="passwordId2" type="password" placeholder="Confirm Password" name="c_password" class="form-control" required minlength="6">
                        <?php if(isset($message_c_pass)){ echo $message_c_pass; } ?>
                    </div>
                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>
                        
							

							
						

<!--%%%%%%%%%%%%%%%% HERE DISPLAY TABLE %%%%%%%%%%%%%%%%% -->
    
    
    <table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

        $query = "SELECT * FROM `admin`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
                echo "<tr>";
echo "<td>".$row["id"]."</td> <td><img src=images/admin/".$row["profilePic"]." width='80px' height='80px'> </td> <td>".$row["name"]."</td> <td> ".$row["admin_mail"]."</td>";

                echo '<td><a href="updateadmin.php?id='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-edit"></span></a></td>';
                
                echo '<td><a href="home.php?delid='.$row['id']. '" type= "button" class="btn btn-danger btn-sm">
                <span class="icon-trash2"></span></a></td>';

                echo "<tr>";  
            }
    } else {
        echo "<div class='alert alert-danger'>You have no admin<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="6" id="end"><div class="text-center"><a href="home.php" type="button" class="btn btn-sm btn-success"><span class="icon-plus"></span></a></div></td>
    </tr>
</table>

<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
    



					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->

<?php include('footer.php'); 

}

?>