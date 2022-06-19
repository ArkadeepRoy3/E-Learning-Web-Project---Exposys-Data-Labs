
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
                // Title Condition
                if( isset($_POST['fullname']) && !empty($_POST['fullname'])){

                    if(preg_match('/^[A-Za-z\s]+$/',$_POST['fullname'])){
                      $name = mysqli_real_escape_string($connection,$_POST['fullname']);
                    }else{
                      $message_name = '<b class="text-danger text-center">Please type correct name</b>';
                    }

                }else{
                    $message_name = '<b class="text-danger text-center">Please fill the name field</b>';
                }//name if condition


                if( isset($name) && !empty($name)  ){

                    $insert_query = "INSERT INTO `categories` (categorie) VALUES ('$name')";

                    if(mysqli_query($connection, $insert_query)){
                        
                       
                        header('Location: categorie.php#end');
                    }else{
                        $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to submit please try later
                        </div>';
                    }
                }

            } else{
    
                 $alertMessage = "<div class='alert alert-danger'> 
                    <p>You are not a Sophisticated Admin. So, You cannot right to add any categorie. <strong>THANK YOU.</strong> </p><br>       
                    <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
                    </div>";    
            } // *********

        } // End of Submit 


	   /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */


    if(isset($_GET['sucess'])){
        $alertMessage = "<div class='alert alert-success'> 
        <p>Record Deleted successfully.</p><br>       
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a> 
        </div>";
    }

    if(isset($_GET['delid'])){ 

        $delCatecorie = $_GET['delid'];

        if($power == 'yes'){
                           
            $alertMessage = "<div class='alert alert-danger'> 
                    <p>Are you sure want to delete this Record? No take baacks!</p><br>
                    <form action='".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$delCatecorie' method='post'>
                       <input type='submit' class='btn btn-danger btn-sm'
                       name='confirm-delete' value='Yes' delete!>
                       <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a> 
                    </form>
            </div>";
        }else{
            $alertMessage = "<div class='alert alert-danger'> 
            <p>You are not a Sophisticated Admin. So, You cannot right to delete any Record. <strong>THANK YOU.</strong> </p><br>       
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
 
        // new database query 
        $query = "DELETE FROM `categories` WHERE id='$id'";
        $result = mysqli_query($connection,$query);
        
        if($result){
            // redirect
            header("Location: categorie.php?sucess");
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

                        <li  class="current"><a href="categorie.php"><i class="icon-book2"></i>Categories</a></li> 

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

                    echo $alertMessage; 
                    if(isset($update_status)) echo $update_status;

                        if(isset($message_name) || isset($submit_message)){
                            echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";

                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Insert Course Categories</h3>

                        <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="CourseId1">Course Categorie</label>
                        <input type="text" id="CourseId1" placeholder="Full Name" name="fullname" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>
                    
                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" type="submit">Submit</button>
                    </div>
                </form>
                        
							

							
						

<!--%%%%%%%%%%%%%%%% HERE DISPLAY TABLE %%%%%%%%%%%%%%%%% -->
    
    
    <table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Course Categories</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

        $query = "SELECT * FROM `categories`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
                echo "<tr>";
echo "<td>".$row["id"]."</td> <td>".$row["categorie"]."</td>";

                echo '<td><a href="updatecategorie.php?id='.$row['id']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-edit"></span></a></td>';
                
                echo '<td><a href="categorie.php?delid='.$row['id']. '" type= "button" class="btn btn-danger btn-sm">
                <span class="icon-trash2"></span></a></td>';

                echo "<tr>";  
            }
    } else {
        echo "<div class='alert alert-danger'>You have no courses.<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="4" id="end"><div class="text-center"><a href="categorie.php" type="button" class="btn btn-sm btn-success"><span class="icon-plus"></span></a></div></td>
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