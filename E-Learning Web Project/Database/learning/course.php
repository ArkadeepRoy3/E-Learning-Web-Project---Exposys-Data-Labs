<?php include("header.php"); ?>

		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Some courses are <strong>Comming Soon...!</strong></h1>
				<span>Exceptional Courses</span>
			</div>

		</section><!-- #page-title end -->

		<!-- Page Sub Menu
		============================================= -->
		<div id="page-menu">

			<div id="page-menu-wrap">


			</div>

		</div><!-- #page-menu end -->

		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class=" bottommargin clearfix ">

						<div class="row">
							<?php				        
		
		$query = "SELECT * FROM `course`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
         		$courseId = $row["id"];
         	 	$coursePic = $row["cover"];
                $coursename = $row["name"];
                $courseDescription = $row["description"];

                echo '<div class="col-sm-6 col-md-3">
							<div class="thumbnail image_fade">
							  <img data-src="holder.js/300x200" alt="Image" src="gotoep/images/courses/'.$coursePic.'" style="display: block; border: 2px solid #555;">
							  <div class="caption">
							  	
								<h5>'.$coursename.'</h5>
								<p>'.$courseDescription.'</p>
								<a href="lecture.php?id='.$courseId.'" class="btn btn-success btn-lg btn-block"  role="button"><strong>Go To Course</strong></a>
							  </div>
							</div>
						  </div>';
         }
     }else{echo '<div class="section notopmargin notopborder">
					<div class="container clearfix">
						<div class="heading-block center nomargin">
							<h3>Courses are not available Yet</h3>
							</div>
						</div>
					</div>';}
?>
						  
					</div>
				</div>		
			</div>
		</div>
	</section>

<?php include("footer.php"); ?>