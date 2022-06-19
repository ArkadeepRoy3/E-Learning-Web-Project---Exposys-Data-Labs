<?php include("header.php"); ?>

<!-- Page Sub Menu
		============================================= -->
		<div id="page-menu">

			<div id="page-menu-wrap">

			</div>

		</div><!-- #page-menu end -->


		<section id="content">

			<div class="content-wrap" id="start">

			<div class="container clearfix">

					<!-- Post Content
					============================================= -->
					<div class="nobottommargin clearfix">

					<?php if(isset($_POST['categorie_op'])){

					 	$newOp = $_POST['categorie_op'];
					 	
					 }else if(isset($_GET['BookId'])){
					 	     
                                $newOp = $_GET['BookId'];	
                        
                            }else{
                                $newOp = "";
                            }

					 
					?>   

					<form method="post">

					    <div class="form-group">                    
                        <label>Course Categories Selection</label>
                        <select class="form-control"  name="categorie_op" id="categorie_op" onchange='if(this.value != 0) { this.form.submit(); }'>
                        <option value="a">All</option>
                    <?php 
                             $query = "SELECT * FROM `course`";

                        $result = mysqli_query($connection, $query);

                        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
                        while( $row = mysqli_fetch_assoc($result) ){
                    ?>

                        <option <?php if($row['bookId'] == $newOp) { ?> selected <?php } ?> value="<?php echo $row['bookId']; ?>" > <?php echo $row['name']; ?>  </option>

                        <?php       
                            } }
                        ?>

                        </select>
                </div>	

			</form>

<?php

	if(!empty($newOp) && $newOp != 'a'){ ?>

	<table class="table table-striped table-bordered">
    <tr>
        <th>Cover</th>
        <th>Name</th>
        <th>Description</th>
        <th>Download</th>
    </tr>
    <?php

        $query = "SELECT * FROM `library` WHERE id='$newOp'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
                echo "<tr>";


                echo "<td width='100px' height='100px'><img src=gotoep/images/library/".$row["image"]." width='100px' height='100px'>
                </td>";
                
                echo "<td><strong>".$row["name"]."</strong></td>";

                echo "<td>".$row["description"]."</td>";

                echo '<td width="50px"><a target="_blank" href="gotoep/books/'.$row['book']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-download-alt"></span></a></td>';             


                echo "<tr>";  
            }
    } else {
        echo "<div class='alert alert-danger'>Books Are Not Available Yet...!<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="5" id="end"><div class="text-center"><a href="library.php#start" type="button" class="btn btn-sm btn-success"><span class="icon-arrow-up"></span></a></div></td>
    </tr>
</table>
		
<?php	}else{

?>


<table class="table table-striped table-bordered">
    <tr>
        <th>Cover</th>
        <th>Name</th>
        <th>Description</th>
        <th>Download</th>
    </tr>
    <?php

        $query = "SELECT * FROM `library`";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
        
                        //We have data 
                        //output the data
         while( $row = mysqli_fetch_assoc($result) ){
                echo "<tr>";


                echo "<td width='100px' height='100px'><img src=gotoep/images/library/".$row["image"]." width='100px' height='100px'>
                </td>";
                
                echo "<td><strong>".$row["name"]."</strong></td>";

                echo "<td>".$row["description"]."</td>";

                echo '<td width="50px"><a target="_blank" href="gotoep/books/'.$row['book']. '" type= "button" class="btn btn-primary btn-sm">
                <span class="icon-download-alt"></span></a></td>';             


                echo "<tr>";

      
            }
    } else {
        echo "<div class='alert alert-danger'>Books Are Not Available Yet...!<a class='close' data-dismiss='alert'>&times</a></div>";
    }
    
    // close the mysql 
        mysqli_close($connection);
    ?>

    <tr>
        <td colspan="5" id="end"><div class="text-center"><a href="library.php#start" type="button" class="btn btn-sm btn-success"><span class="icon-arrow-up"></span></a></div></td>
    </tr>
</table>

<?php } ?>					
					
</div>	
</div>
</div>
</section>


<?php include("footer.php"); ?>