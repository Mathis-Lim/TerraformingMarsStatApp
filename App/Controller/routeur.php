<?php
	require_once File::build_path(array('Controller', 'GameController.php'));
	require_once File::build_path(array('Controller', 'CorporationController.php'));
	/*require_once File::build_path(array('controller', 'ControllerVetement.php'));
	require_once File::build_path(array('controller', 'ControllerErreur.php'));
	require_once File::build_path(array('controller', 'ControllerCommande.php'));*/
	
	//verifie que $controller est pas nul
	if(!isset($_GET['controller'])){
		$controller = 'game';
	}
	else{
		$controller = $_GET["controller"];
	}

	//verification que le controleur existe
	$nom_controller = 'Controller'.ucfirst($controller); 
	if(!class_exists($nom_controller)){
		$nom_controller = 'GameController';
	}

	//verifie que $action n'est pas null
	if (!isset($_GET['action'])){
		$action = "home";
	}
	else {
		$action = $_GET["action"];
	}

	//verifie que l'action existe
	$methods = get_class_methods($nom_controller);
	if(!in_array($action,$methods)){
		$action ="home";
	}
	
	//appel du controleur
	$nom_controller::$action();
?>