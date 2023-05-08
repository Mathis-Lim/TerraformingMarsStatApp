<?php
	$DS = DIRECTORY_SEPARATOR;
	require __DIR__.$DS."Core".$DS."File.php";
	require File::build_path(array('Controller','routeur.php'));
?>