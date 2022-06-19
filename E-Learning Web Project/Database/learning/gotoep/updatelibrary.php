<?php

    include("../include/config.php");

    if((!isset($_SESSION['userId']) && empty($_SESSION['userId'])) && (!isset($_SESSION['userName']) && empty($_SESSION['userName']))) {

        header('Location: index.php');
    } else {

        $loginName = $_SESSION['userName'];
        $loginId = $_SESSION['userId'];
        $bookId = $_GET["id"];
        $power = $_SESSION['adminType'];

        /* %%%%%%%%%%%%% START CODE SUBMIT %%%%%%%%%%%% */

        if( isset($_POST['submit']) ){

            //Name Condition
            if( isset($_POST['fullname']) && !empty($_POST['fullname'])){
        
                if(preg_match('/^[A-Za-z\s]+$/',$_POST['fullname'])){
                  $name = mysqli_real_escape_string($connection,$_POST['fullname']);
                }else{
                  $message_name = '<b class="text-danger text-center">Please type correct name</b>';
                }

            }else{
                $message_name = '<b class="text-danger text-center">Please fill the name field</b>';
            }

            //Categorie Condition
            if(isset($_POST["categorie_op"]) && !empty($_POST["categorie_op"])){

                    $categorie_option = $_POST["categorie_op"];
            } else {
                $categorie_error = '<b class="text-danger text-center">Please select categorie option OR Insert course categorie.</b>';
            }

            // Description Condition 
            if( isset($_POST['description']) && !empty($_POST['description']) ){
                
                if(preg_match('/^[A-Za-z.\s]+$/',$_POST['description'])){
                    $description = mysqli_real_escape_string($connection,$_POST['description']);
                }else{

                    $message_des = '<b class="text-danger text-center">Please enter valid Description field.</b>';
                }

            }else{
                $message_des = '<b class="text-danger text-center">Please fill the Description field.</b>';
            }    

            if (isset($_FILES["file1"]["name"]) && !empty($_FILES["file1"]["name"] ) )  {

                $allowedExts = array("pdf");
                $temp = explode(".", $_FILES["file1"]["name"]);
                $extension = end($temp);
                
                if (($_FILES["file1"]["type"] == "application/pdf") && in_array($extension, $allowedExts))
                {
                    if ($_FILES["file1"]["error"] > 0)
                    {
                        $file_error = "Return Code: " . $_FILES["file1"]["error"];
                    }else{

                        $target_dir = "books/"; 
                        $delfile = 'yes';

                        $fileName = $_FILES["file1"]["name"]; // the name of file
                        $fileTmpLoc = $_FILES["file1"]["tmp_name"]; // file name in PHP folder
                        $fileType = $_FILES["file1"]["type"];
                        $fileSize =$_FILES["file1"]["size"]; // file size in bytes 
                        // *******************New Code Start from here

                        $temp = explode(".", $_FILES["file1"]["name"]);
                         $newfilename = mysqli_real_escape_string($connection,round(microtime(true)) . '.' . end($temp));
                        if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_dir . $newfilename)) {
                        
                        } else {
                            $file_error =  '<b class="text-danger">Sorry, there was an error uploading your file.';
                        }

                        //********************End code
                    } 
                }else{
                    $file_error = '<b class="text-danger">File is not PDF.</b>';   
                }   
            }else{
                $newfilename = $_POST['pdfValue'];
                $delfile = 'no';

            } // end else 


            // Cover Photo'''''''''''''

            if( isset($_FILES["profilePic"]["name"]) && !empty($_FILES["profilePic"]["name"]) ){
                $target_dir = "images/library/";
                $del = 'yes';
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
                    $newfilename1 = mysqli_real_escape_string($connection,round(microtime(true)) . '.' . end($temp));
                    if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_dir . $newfilename1)) {
                        
                    } else {
                        $message_picture =  '<b class="text-danger">Sorry, there was an error uploading your file';
                    }
                }

            }else{
                $newfilename1 =  $_POST['picValue'];
                $del = 'no';
            } 


            if( ( isset($name) && !empty($name) )  && ( isset($newfilename) && !empty($newfilename) ) && (isset($categorie_option) && !empty($categorie_option)) && ( isset($description) && !empty($description) ) && ( isset($newfilename1) && !empty($newfilename1) ) ){

                    $insert_query = "UPDATE `library` SET
                    name = '$name', 
                    categorieId = '$categorie_option',  
                    description = '$description', 
                    book = '$newfilename',
                    image = '$newfilename1' 
                    WHERE id = '$bookId' ";

                    if(mysqli_query($connection, $insert_query)){
                        
                        if($del == 'yes'){
                        $base_directory = "images/library/";
                        if(unlink($base_directory.$_POST['picValue']))
                        $delVar = " ";
                    }

                    if($delfile == 'yes'){
                        $base_directory = "books/";
                        if(unlink($base_directory.$_POST['pdfValue']))
                        $delVar = " ";
                    }
                       
                        header('Location: library.php?back=2');
                    }else{
                        $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to submit please try later
                        </div>';
                    }
        

        }else{
            $submit_message = '<div class="alert alert-danger">
                            <strong>Warning!</strong>
                            You are not able to submit please try later
                        </div>';
        }


} // end of submission 

       /* %%%%%%%%%%%%% END CODE SUBMIT %%%%%%%%%%%% */


if(isset($_GET['id'])){

        $bookId = $_GET["id"];

        if( $power == 'yes') {

           $query = "SELECT * FROM `library` WHERE id='$bookId' ";

            $result = mysqli_query($connection,$query);

            if(mysqli_num_rows($result) > 0){
                  while( $row = mysqli_fetch_assoc($result) ){

                $bookName = $row["name"];
                $bookDescription = $row["description"];
                $bookCategorie = $row["categorieId"];
                $bookPdf = $row["book"];
                $coverPic = $row["image"];
            
             }
            }
        }else header('Location: library.php?back=1');    

    } else header('Location: library.php?back=1');


    
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

						<li><a href="content.php"><i class="icon-line-content-left"></i>Content</a> </li>

						<li><a href="blog.php"><i class="icon-blogger"></i>Blog</a></li>

						<li class="current"><a href="library.php"><i class="icon-line-align-center"></i>Library</a></li>

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

                        if(isset($message_name) || isset($message_picture) || isset($submit_message) || isset($message_des) || isset($categorie_error) || isset($file_error) ){

                            echo "<div class='alert alert-danger'>";
                            
                            echo "Please fill the form carefully and correctly<br>";
                            
                            echo "<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Cancel</a>
                            </div>";    

                        }

                 ?>
                 
						<h3>Update Book</h3>

                        <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fullnameId">Book Name</label>
                        <input type="text" id="fullnameId" value="<?php if(isset($bookName)) echo $bookName; ?>" placeholder="Full Name" name="fullname" class="form-control" title="Only lower and upper case and space" pattern="[A-Za-z/\s]+">
                        <?php if(isset($message_name)){ echo $message_name; } ?>
                    </div>

                    <div class="form-group">
                    <img src="images/library/<?php if(isset($coverPic)) echo $coverPic; ?>" width="100px" height="100px">
                    </div>

                    <div class="form-group">
                        <label class="btn btn-success" for="my-file-selector">
                            <input id="my-file-selector" name="profilePic" type="file" style="display:none;" onchange="$('#upload-file-info1').html($(this).val());">
                            Update Cover Photo
                        </label>
                        <span class='label label-success' id="upload-file-info1"></span>
                        <?php if(isset($message_picture)){ echo $message_picture; } ?>
                    </div>
                 
                <div class="form-group">                    
                        <label> Categorie Selection</label>
                        <select class="form-control"  name="categorie_op">
                    <?php 
                             $query = "SELECT * FROM `categories`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>

                        <option <?php if($row['id'] == $bookCategorie) { ?> selected <?php } ?> value="<?php echo $row['id']; ?>" > <?php echo $row['categorie']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                    <?php if(isset($categorie_error)) echo $categorie_error; ?>
                </div>
                <h3>Book</h3>
                <?php echo '<a href="books/book.php?name='.$bookPdf. '" type= "button" class="btn btn-success btn-sm">
                <span class="icon-eye-open"></span></a>'; ?>
                <br>
                <br>
                    <div class="form-group">
                        <label class="btn btn-success" for="my-file-selector1">
                            <input id="my-file-selector1"  name="file1" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
                            Update Book
                        </label>
                        <span class='label label-success' id="upload-file-info"></span>
                        <?php if(isset($file_error)){ echo $file_error; } ?>

                        <progress id="progressBar" value="0" max="100" style="width: 300px;"></progress>
                        <h3 id="status"></h3>
                        <p id="loaded_n_total"></p>
                    
                    </div>
                    <div class="form-group">
                		<label for="descriptionId">Description</label>
                		<textarea id="descriptionId" class="form-control" 
                		 name="description"><?php if(isset($bookDescription)) echo $bookDescription;?></textarea>
             		</div>
             		<?php if(isset($message_des)){ echo $message_des; } ?>

                    <input type="hidden" name="pdfValue" value="<?php if(isset($bookPdf))  echo $bookPdf; ?>">

                    <input type="hidden" value="<?php if(isset($coverPic)) echo $coverPic; ?>" name="picValue"/>

                    <div class="form-group">
                        <button name="submit" class="btn btn-block btn-success" onclick="uploadFile()" type="submit">Submit</button>
                    </div>
                </form>

					</div><!-- .postcontent end -->


				</div>

			</div>

		</section><!-- #content end -->

<?php include('footer.php'); 
}

?>

<script>
        
    function _(el){
        return document.getElementById(el);
    }

    function uploadFile(){
        var file = _("my-file-selector").files[0];
    //  alter(file.name+" | "+file.size+" | "+file.type);

        var formdata = new FormData();
        formdata.append("my-file-selector", file);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);

        ajax.open("POST", "library.php");

        ajax.send(formdata);

    }

    function progressHandler(event){
        _("loaded_n_total").innerHTML= "Upload "+event.loaded+"bytes of"+event.total;

        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value= Math.round(percent);
        _("status").innerHTML= Math.round(percent)+"% uploaded... Please wait";
    }

    function completeHandler(event){
        
        _("status").innerHTML= event.target.responseText;
        _("progressBar").value= 0;
        
    }

    function errorHandler(event){
        
        _("status").innerHTML= "Upload failed";
        
    }

    function abortHandler(event){
        
        _("status").innerHTML= "Upload aborted";
        
    }
    </script>