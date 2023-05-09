<?php
	require_once File::build_path(array('Controller', 'GameController.php'));
	require_once File::build_path(array('Controller', 'CorporationController.php'));
	require_once File::build_path(array('Controller', 'ErrorController.php'));
	require_once File::build_path(array('Controller', 'PlayerController.php'));
	
	//verifie que $controller est pas nul
	if(!isset($_GET['controller'])){
		$controller = 'game';
	}
	else{
		$controller = $_GET['controller'];
	}

	//verification que le controleur existe
	$nom_controller = ucfirst($controller).'Controller'; 
	if(!class_exists($nom_controller)){
		$nom_controller = 'ErrorController';
	}

	//verifie que $action n'est pas null
	if (!isset($_GET['action'])){
		$action = "home";
	}
	else {
		$action = $_GET['action'];
	}

	//verifie que l'action existe
	$methods = get_class_methods($nom_controller);
	if(!in_array($action,$methods)){
		$action = "url";
		$nom_controller = 'ErrorController';
	}
	
	//appel du controleur
	$nom_controller::$action();
?>