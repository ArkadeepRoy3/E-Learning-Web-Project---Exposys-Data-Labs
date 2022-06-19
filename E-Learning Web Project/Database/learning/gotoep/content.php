
<?php

    include("../include/config.php");

    if((!isset($_SESSION['userId']) && empty($_SESSION['userId'])) && (!isset($_SESSION['userName']) && empty($_SESSION['userName']))) {

        header('Location: index.php');
    } else {

        $loginName = $_SESSION['userName'];
        $loginId = $_SESSION['userId'];
        $power = $_SESSION['adminType'];
        $alertMessage = " ";

        /* %%%%%%%%%%%%% START CODE SUBMIT %%%%%%%%%%%% */

        if( isset($_POST['submit']) ){

            if($power == 'yes'){ //*********************

                if(isset($_POST["course_op"]) && !empty($_POST["course_op"])){

                    $course_option = $_POST["course_op"];
                } else {
                    $course_error = '<b class="text-danger text-center">Please select Course option OR Insert Course. .</b>';
                }

            
                if( isset($_POST['editor']) && !empty($_POST['editor']) ){
                        
                        $lectureContent = $_POST['editor'];
                }else{
                        $message_Content = '<b class="text-danger text-center">Please fill the Content.</b>';
                } // end of description    



                if( isset($_POST['name']) && !empty($_POST['name'])){
                        
                    if(preg_match('/^[A-Za-z\s]+$/',$_POST['name'])){
                            $name = mysqli_real_escape_string($connection,$_POST['name']);
                        }else{

                            $message_name = '<b class="text-danger text-center">Please enter valid Name.</b>';
                        }

                }else{
                    $message_name = '<b class="text-danger text-center">Please fill the Name field.</b>';
                }


                if( ( isset($name) && !empty($name) ) && ( isset($course_option) && !empty($course_option) ) && ( isset($lectureContent) && !empty($lectureContent) ) ) {

                                    $insert_query = "INSERT INTO `content` ( content, courseId, lectureName) VALUES ('$lectureContent','$course_option','$name')";


                                    if(mysqli_query($connection, $insert_query)){
                                        
                                        header('Location: content.php#end');
                                    }else{
                                        $submit_message = '<div class="alert alert-danger">
                                            <strong>Warning!</strong>
                                            You are not able to submit please try later
                                        </div>';
                                    }
                        

                } // end of if 


        }else{
        
             $alertMessage = "<div class='alert alert-danger'> 
                <p>You are not a Sophisticated Admin. So, You cannot right to add Content. <strong>THANK YOU.</strong> </p><br>       
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                </div>";    
        } // *****************************
    }//submit button */

       /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */

    
        if(isset($_GET['sucess'])){
            $alertMessage = "<div class='alert alert-success'> 
                <p>Record Deleted successfully.</p><br>       
                <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                </div>";
        }  

        if(isset($_GET['delid'])){ 

            $deluser = $_GET['delid'];

            if($power == 'yes'){
                               
                $alertMessage = "<div class='alert alert-danger'> 
                 <p>Are you sure want to delete this Record? No take baacks!</p><br>
                        <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$deluser' method='post'>
                           <input type='submit' class='btn btn-danger btn-sm'
                           name='confirm-delete' value='Yes' delete!>
                           <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a>                    
                        </form>
            
                </div>";
        } else {
            $alertMessage = "<div class='alert alert-danger'> 
            <p>You are not a Sophisticated Admin. So, You cannot right to delete any Record <strong>THANK YOU.</strong> </p><br>       
            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
            </div>";
        }
    }


    // return from update Update
    if(isset($_GET['back'])){

        $back = $_GET['back'];

        if($back!=2){
                $update_status = "<div class='alert alert-danger'> 
        <p>You are not a Sophisticated Admin. You can update your own record.<strong>THANK YOU.</strong> </p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";
        }else{

            $update_status = "<div class='alert alert-success'> 
        <p>Update successfully.</p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";
        }

    } 


     // conform delete button
    if(isset($_POST['confirm-delete'])){

        $id = $_GET['id'];
 
        // new database query 
        $query = "DELETE FROM `content` WHERE id='$id'";
        $result = mysqli_query($connection,$query);
        
        if($result){
            // redirect
            header("Location: content.php?sucess=1");
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
                 
						<h3>Insert Course Content</h3>

                        <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="nameId1">Lecture Name</label>
                        <input type="text" id="nameId1" placeholder="Lecture Name" name="name" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">                    
                       <label>Course Selection</label>
                        <select class="form-control"  name="course_op">
                    <?php 
                        
                        $query = "SELECT * FROM `course`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
                        

                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>
                        <option value="">Select Option</option>
                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                <?php if(isset($course_error)) echo $course_error; ?>
                </div>
                    
                <textarea class="ckeditor" name="editor"></textarea>
                <?php if(isset($message_Content)) echo $message_Content; ?>
                    
                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>
                 		

<!--%%%%%%%%%%%%%%%% HERE DISPLAY TABLE %%%%%%%%%%%%%%%%% -->
    
    
    <table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Content</th>
        <th>Lecture Name</th>
        <th>Course Name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

        $query = "SELECT * FROM `content`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){

                $temp = $row['courseId'];
                $query2 = "SELECT * FROM `course` WHERE id ='$temp' ";
                $result2 = mysqli_query($connection, $query2);

                if(mysqli_num_rows($result2) > 0){
        
                        //We have data 
                        //output the data
                while( $row2 = mysqli_fetch_assoc($result2) ){

                   $courseName = $row2['name']; 
                }} else{$courseName='Insert Course Name';}

                echo "<tr>";
                
                echo "<td>".$row["id"]."</td>";


                echo "<td>".$row["lectureName"]."</td>"; 

                echo "<td>".$courseName."</td>";
                
                echo '<td><a href="view.php?id='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-eye-open"></span></a></td>';


                echo '<td><a href="updatecontent.php?id='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-edit"></span></a></td>';
                
                echo '<td><a href="content.php?delid='.$row['id']. '" type= "button" class="btn btn-danger btn-sm">
                <span class="icon-trash2"></span></a></td>';

                echo "<tr>";  
            }
    } else {
        echo "<div class='alert alert-danger'>You have no Content.<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="6" id="end"><div class="text-center"><a href="content.php" type="button" class="btn btn-sm btn-success"><span class="icon-plus"></span></a></div></td>
    </tr>
</table>

<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
    



					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>

<?php include('footer.php'); 

}

?>

