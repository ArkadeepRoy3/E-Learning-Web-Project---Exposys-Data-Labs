
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

                //Name Condition
                if( isset($_POST['fullname']) && !empty($_POST['fullname'])){
                    
                    if(preg_match('/^[A-Za-z\s]+$/',$_POST['fullname'])){
                      $name = mysqli_real_escape_string($connection,$_POST['fullname']);
                    }else{
                      $message_name = '<b class="text-danger text-center">Please enter correct Name.</b>';
                    }

                  }else{
                      $message_name = '<b class="text-danger text-center">Please fill the Name field</b>';
                }

                // Categorie Condition
                if(isset($_POST["categorie_op"]) && !empty($_POST["categorie_op"])){

                        $categorie_option = $_POST["categorie_op"];
                } else {
                    $categorie_error = '<b class="text-danger text-center">Please select categorie option OR insert course categorie.</b>';
                }

                // Book Option
                if(isset($_POST["book_op"]) && !empty($_POST["book_op"])){

                        $book_option = $_POST["book_op"];
                } else {
                    $book_error = '<b class="text-danger text-center">Please Select book option OR Insert Book.</b>';
                }

                //Instructor Option
                if(isset($_POST["ins_op"]) && !empty($_POST["ins_op"])){

                        $instructor_option = $_POST["ins_op"];
                } else {
                    $instructor_error = '<b class="text-danger text-center">Please select Instructor option OR insert Instructor information.</b>';
                }

                // Description Condition
                if( isset($_POST['description']) && !empty($_POST['description']) ){
                
                    
                        $description = mysqli_real_escape_string($connection,$_POST['description']);
                    
                }else{
                    $message_des = '<b class="text-danger text-center">Please fill the Description field.</b>';
                } 

                //Image Condition
                if( isset($_FILES["profilePic"]["name"]) && !empty($_FILES["profilePic"]["name"]) ){
                    $target_dir = "images/courses/";
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



                if( ( isset($name) && !empty($name) ) && (isset($book_option) && !empty($book_option)) && (isset($instructor_option) && !empty($instructor_option)) && (isset($categorie_option) && !empty($categorie_option)) && (isset($description) && !empty($description)) && ( isset($newfilename) && !empty($newfilename) ) ){


                    $insert_query = "INSERT INTO `course` (name, cover, description, categorieId, instructorId, bookId) VALUES ('$name','$newfilename','$description','$categorie_option','$instructor_option','$book_option')";


                    if(mysqli_query($connection, $insert_query)){
                        
                       
                        header('Location: courses.php#end');
                    }else{
                        $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to submit please try later
                        </div>';
                    }    
                }

        }else{
    
             $alertMessage = "<div class='alert alert-danger'> 
                <p>You are not a Sophisticated Admin. So, You cannot right to delete any Record.<strong>THANK YOU.</strong> </p><br>       
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                </div>";    
        } // *******************************

    } // end of if 


       /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */
    

    if(isset($_GET['success'])){
        $alertMessage = "<div class='alert alert-success'> 
        <p>Record Deleted successfully.</p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a></div>";
    }

    if(isset($_GET['delid'])){ 

        $delcourse = $_GET['delid'];

        if($power == 'yes'){
                           
            $alertMessage = "<div class='alert alert-danger'> 
                <p>Are you sure want to delete this Record? No take baacks!</p><br>
                    <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$delcourse' method='post'>
                       <input type='submit' class='btn btn-danger btn-sm'
                       name='confirm-delete' value='Yes' delete!>
                       <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a> 
                        
                    </form>
        
        </div>";
        }else{
            $alertMessage = "<div class='alert alert-danger'> 
            <p>You are not a Sophisticated Admin. So, You cannot right to delete any Record <strong>THANK YOU.</strong> </p><br>       
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
        $query2 = "SELECT * FROM `course` WHERE id='$id' ";

        $result2 = mysqli_query($connection, $query2);

        if(mysqli_num_rows($result2) > 0){
        
                        //We have data 
                        //output the data
         while( $row2 = mysqli_fetch_assoc($result2) ){
                
                $base_directory = "images/courses/";
                if(unlink($base_directory.$row2['cover']))
                    $delVar = " ";  
         }}
 
        // new database query 
        $query = "DELETE FROM `course` WHERE id='$id'";
        $result = mysqli_query($connection,$query);
        
        if($result){
            // redirect
            header("Location: courses.php?success=1");
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
						<li><a href="home.php"><i class="icon-home2"></i>Home</a></li>

                        <li><a href="categorie.php"><i class="icon-book2"></i>Categories</a></li>
                        
						<li class="current"><a href="courses.php"><i class="icon-book3"></i>Courses</a></li>

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

                    echo $alertMessage; 
                    if(isset($update_status)) echo $update_status;

                        if(isset($message_name) || isset($message_picture) || isset($submit_message) || isset($message_des) || isset($categorie_error) || isset($instructor_error) || isset($book_error) ){
                            echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";

                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Insert Course</h3>

                        <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nameID">Course Name</label>
                        <input type="text" id="nameID" placeholder="Full Name" name="fullname" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">                    
                        <label>Book Selection</label>
                        <select class="form-control"  name="book_op">
                        <option value="">Select Option</option>
                    <?php 
                             $query = "SELECT * FROM `library`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>

                        <option value="<?php echo $row['id']; ?>" > <?php echo $row['name']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                    <?php if(isset($book_error)) echo $book_error; ?>
                </div>

                    <div class="form-group">                    
                        <label>Categorie Selection</label>
                        <select class="form-control"  name="categorie_op">
                        <option value="">Select Option</option>
                    <?php 
                             $query = "SELECT * FROM `categories`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>

                        <option value="<?php echo $row['id']; ?>" > <?php echo $row['categorie']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                    <?php if(isset($categorie_error)) echo $categorie_error; ?>
                </div>

                <div class="form-group">                    
                        <label>Instructor Selection</label>
                        <select class="form-control"  name="ins_op">
                        <option value="">Select Option</option>
                    <?php 
                             $query = "SELECT * FROM `teacher`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>

                        <option value="<?php echo $row['id']; ?>" > <?php echo $row['name']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                    <?php if(isset($instructor_error)) echo $instructor_error; ?>
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
                        <label for="descriptionId1">Description</label>
                        <textarea id="descriptionId1" class="form-control" 
                         name="description"></textarea>
                    </div>
                    <?php if(isset($message_des)){ echo $message_des; } ?>

                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>
                        
							

<!--%%%%%%%%%%%%%%%% HERE DISPLAY TABLE %%%%%%%%%%%%%%%%% -->
    
    
    <table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Cover Picture</th>
        <th>Name</th>
        <th>Description</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

        $query = "SELECT * FROM `course`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
                echo "<tr>";
echo "<td>".$row["id"]."</td> <td><img src=images/courses/".$row["cover"]." width='80px' height='80px'> </td> <td>".$row["name"]."</td>";
                
                 echo '<td><a href="view.php?courseId='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-eye-open"></span></a></td>';

                echo '<td><a href="updatecourses.php?id='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-edit"></span></a></td>';
                
                echo '<td><a href="courses.php?delid='.$row['id']. '" type= "button" class="btn btn-danger btn-sm">
                <span class="icon-trash2"></span></a></td>';

                echo "<tr>";  
            }
    } else {
        echo "<div class='alert alert-danger'>You have no Courses.<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="6" id="end"><div class="text-center"><a href="courses.php" type="button" class="btn btn-sm btn-success"><span class="icon-plus"></span></a></div></td>
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