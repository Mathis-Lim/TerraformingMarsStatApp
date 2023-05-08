<?php
	require_once File::build_path(array('Model', 'CorporationModel.php'));

	class CorporationController{

        public static function readAll(){
            $corporationArray = CorporationModel::readAll();
            if(!isset($corporationArray)){
                $controller = "Error";
                $action = "readAllCorporation";
            }
            else{
                $controller = "Corporation";
                $view = "list";
                $pageTitle = "Corporations";
            }
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $controller = "Corporation";
            $view = "create";
            $pageTitle = "on verra hein";
            require File::build_path(array("View", "BaseView.php"));
        }


        public static function created(){

            $corporationName = $_GET['corporation_name'];
            $corpo = new CorporationModel(NULL, $corporationName);

            $success = $corpo->save();
            if($success == true){
                $creation = true;
                /*$controller = "Corporation";
                $view = "list";
                $pageTitle = "Corporations";*/
                CorporationController::readAll();
            }
            else{
                $controller = "Error";
                $action = "corporationCreation";
                require File::build_path(array("View", "BaseView.php"));
            }
    }   
}











