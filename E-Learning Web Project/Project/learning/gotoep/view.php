
<?php

include("../include/config.php");

	if((!isset($_SESSION['userId']) && empty($_SESSION['userId'])) && (!isset($_SESSION['userName']) && empty($_SESSION['userName']))) {

        header('Location: index.php');
    } else {
        $loginName = $_SESSION['userName'];

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

						<li <?php if(isset($_GET['courseId'])) { ?> class="current" <?php } ?>><a href="courses.php"><i class="icon-book3"></i>Courses</a></li>

						<li <?php if(isset($_GET['id'])) { ?> class="current" <?php } ?> ><a href="content.php"><i class="icon-line-content-left"></i>Content</a> </li>

						<li><a href="blog.php"><i class="icon-blogger"></i>Blog</a></li>

						<li <?php if(isset($_GET['libId'])) { ?> class="current" <?php } ?> ><a href="library.php"><i class="icon-line-align-center"></i>Library</a></li>

						<li <?php if(isset($_GET['instructorId'])) { ?> class="current" <?php } ?> ><a href="instructors.php"><i class="icon-guest"></i>Instructors</a></li>

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


            <h3>Content</h3>

<!-- :::::::::::::::::::::: Content.php ::::::::::::::::::::::: -->

    <?php
    if(isset($_GET['id']) || isset($_GET['courseId']) || isset($_GET['instructorId']) || isset($_GET['libId'])){

        if(isset($_GET['id'])){
        
        $content_Id = $_GET['id'];

        $query = "SELECT * FROM `content` WHERE id= '$content_Id'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
         while( $row = mysqli_fetch_assoc($result) ){

                echo $row['content'];
                
            }
    
    }else {

        echo '<h1>No Content Found..!</h1>';

       } } 

       //:::::::::::::::::::::: Course.php :::::::::::::::::

      

        if(isset($_GET['courseId'])){
        
        $content_Id = $_GET['courseId'];

        $query = "SELECT * FROM `course` WHERE id= '$content_Id'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
         while( $row = mysqli_fetch_assoc($result) ){

                echo $row['description'];
                
            }
    
    }else {

        echo '<h1>No Content Found..!</h1>';

       } }



       //:::::::::::::::::::::: instructor.php :::::::::::::::::

        if(isset($_GET['instructorId'])){
        
        $content_Id = $_GET['instructorId'];

        $query = "SELECT * FROM `teacher` WHERE id= '$content_Id'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
         while( $row = mysqli_fetch_assoc($result) ){

                echo $row['description'];
                
            }
    
    }else {

        echo '<h1>No Content Found..!</h1>';

       } }

       //:::::::::::::::::::::: library.php :::::::::::::::::

        if(isset($_GET['libId'])){
        
        $content_Id = $_GET['libId'];

        $query = "SELECT * FROM `library` WHERE id= '$content_Id'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
         while( $row = mysqli_fetch_assoc($result) ){

                echo "<h5>Name</h5>";
                echo $row['name'];
                echo "<br><br><h5>Description</h5>";
                echo $row['description'];
                
            }
    
    }else {

        echo '<h1>No Content Found..!</h1>';

       } }


}

?>
   
					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->

<?php 
// close the mysql 
    mysqli_close($connection);
include('footer.php'); 

}
?>