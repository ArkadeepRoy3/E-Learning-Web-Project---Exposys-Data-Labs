


<?php

	$file1 = $_GET['name'];

	header('Content-type: application/pdf');
	header('content-Description: inline; filename="' .$file1. '"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-ranges: bytes');
	@readfile($file1);

?>
