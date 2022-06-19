
<?php

    include("../include/config.php");

	if((!isset($_SESSION['userId']) && empty($_SESSION['userId'])) && (!isset($_SESSION['userName']) && empty($_SESSION['userName']))) {

        header('Location: index.php');
    } else {

        $loginName = $_SESSION['userName'];
        $loginId = $_SESSION['userId'];
        $updateId = $_GET['id'];
        $power = $_SESSION['adminType'];

        /* %%%%%%%%%%%%% START CODE SUBMIT %%%%%%%%%%%% */

        if( isset($_POST['submit']) ){
  
                if(isset($_POST["course_op"]) && !empty($_POST["course_op"])){

                    $course_option = $_POST["course_op"];
                } else {
                    $course_error = '<b class="text-danger text-center">Please select course option OR insert course. .</b>';
                }
            
                // Description
                if( isset($_POST['editor']) && !empty($_POST['editor']) ){
                        
                        $lectureContent = $_POST['editor'];
                }else{
                    	$message_Content = '<b class="text-danger text-center">Please fill the content field.</b>';
                }     

                // Name
                if( isset($_POST['name']) && !empty($_POST['name'])){
                    	
                	if(preg_match('/^[A-Za-z\s]+$/',$_POST['name'])){
                    		$name = mysqli_real_escape_string($connection,$_POST['name']);
                    	}else{

                    		$message_name = '<b class="text-danger text-center">Please enter valid Name field.</b>';
                    	}

                }else{
                    $message_name = '<b class="text-danger text-center">Please fill the Name field.</b>';
                }


                if( ( isset($name) && !empty($name) ) && ( isset($course_option) && !empty($course_option) ) && ( isset($lectureContent) && !empty($lectureContent) ) ) {

                    $insert_query = "UPDATE `content` SET
                    content = '$lectureContent', 
                    courseId = '$course_option', 
                    lectureName = '$name'
                    WHERE id= '$updateId' ";

                    if(mysqli_query($connection, $insert_query)){
                                               
                        header('Location: content.php?back=2');
                    }else{
                        $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to submit please try later
                        </div>';
                    }
                } // end of if 
            }//submit button */

	   /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */
	
    $alertMessage = " ";

    // Get Data

    if(isset($_GET['id'])){

        $updateId = $_GET['id'];
        if( $power == 'yes' ) {

           $query = "SELECT * FROM `content` WHERE id=$updateId ";

            $result = mysqli_query($connection,$query);

            if(mysqli_num_rows($result) > 0){
                  while( $row = mysqli_fetch_assoc($result) ){

                $content_Name = $row["lectureName"];
                $contentFull = $row["content"];
                $course_Id = $row["courseId"];
               
             }
            }
        }else header('Location: content.php?back=1');    

    } else header('Location: content.php?back=1');

    include('header.php');

?>

		<!-- ============================== Document Wrapper ================================= -->
	<div id="wrapper" class="clearfix">

		<div id="vertical-nav">
			<div class="container clearfix">

				<nav>
					<ul>
						<li><a href="home.php"><i class="icon-home2"></i>Home</a></li>

                        <li><a href="categorie.php"><i class="icon-book2"></i>Categories</a></li>

						<li><a href="courses.php"><i class="icon-book3"></i>Courses</a></li>

						<li  class="current"><a href="content.php"><i class="icon-line-content-left"></i>Content</a> </li>

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

                        if(isset($message_name) || isset($submit_message) || isset($message_Content) || isset($course_error)  ){
                            echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";

                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Update Course Content</h3>

                        <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="nameId1">Lecture Name</label>
                        <input type="text" id="nameId1" value="<?php if(isset($content_Name)) echo $content_Name; ?>" placeholder="Lecture Name" name="name" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">                    
                       <label for="contentsel">Course Selection</label>
                        <select class="form-control"  name="course_op" id="contentsel">
                    <?php 
                        
                        $query = "SELECT * FROM `course`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
                        

                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>
                        
                        <option <?php if($row['id'] == $course_Id) { ?> selected <?php } ?> value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                <?php if(isset($course_error)) echo $course_error; ?>
                </div>
                    
                <textarea class="ckeditor" name="editor"><?= $contentFull ?></textarea>
                <?php if(isset($message_Content)) echo $message_Content; ?>
                    
                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>


					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>

<?php include('footer.php'); 

}

?>