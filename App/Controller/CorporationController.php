<?php
	require_once File::build_path(array('Model', 'CorporationModel.php'));

	class CorporationController{

        public static function list(){
            $controller = "Corporation";
            $view = "list";
            $pageTitle = "Accueil";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $controller = "Corporation";
            $view = "create";
            $pageTitle = "on verra hein";
            require File::build_path(array("View", "BaseView.php"))
        }


        public static function created(){

            $corporationName = $_GET["corporation_name"];
            $corpo = new CorporationModel($corporationName);

            $success = $corpo->save();
            if($success == true){
                $controller = "Corporation";
                $view = "created";
                $pageTitle = "on verra hein";
            }
            else{
                $someVar = "nnnnn";
                $controller = "Game";
                $view = "home";
                $pageTitle = "home";
            }
            require File::build_path(array("View", "BaseView.php"))
    }   
}











