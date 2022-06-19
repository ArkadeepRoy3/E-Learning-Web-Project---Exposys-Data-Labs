<?php


	if(isset($_GET['page']) && !empty($_GET['page'])){

		$page = $_GET['page'];

		if($page=='home')
			include("home.php");

		else if($page=='blog')
			include("blog.php");

		else if($page=='contact')
			include("contact.php");

		else if($page=='course')
			include("course.php");
		
		else if ($page== 'library') 
			include("library.php");

		else if ($page== 'login') 
			include("login.php");
		
		elseif ($page== 'team') 
			include("team.php");

		else if($page=='privacy')
			include("privacy.php");
		
		else
			include("404.php");


	} else {
		include("home.php");
	}

?>