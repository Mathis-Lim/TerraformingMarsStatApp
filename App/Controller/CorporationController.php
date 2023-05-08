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
                if(isset $_GET['creation']){
                    $creation = true;
                }
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
                //CorporationController::readAll();
                header('Location: index.php?controller=corporation&action=readAll&creation=true');
            }
            else{
                $controller = "Error";
                $action = "corporationCreation";
                require File::build_path(array("View", "BaseView.php"));
            }
    }   
}











