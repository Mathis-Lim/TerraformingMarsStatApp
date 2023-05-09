<?php
	require_once File::build_path(array('Model', 'ExtensionModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

	class ExtensionController{

        public static function readAll(){
            $extensionArray = ExtensionModel::readAll();
            if(!isset($extensionArray)){
                ErrorController::readAllExtensions();
                exit;
            }
            else{
                if(isset($_GET['creation'])){
                    $creation = true;
                }
                $controller = "Extension";
                $view = "list";
                $pageTitle = "Extensions";
            }
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $controller = "Extension";
            $view = "create";
            require File::build_path(array("View", "BaseView.php"));
        }


        public static function created(){

            if(isset($_GET['extension_name'])){
                $extensionName= $_GET['extension_name'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }
            
            $extension = new ExtensionModel(NULL, $extensionName);
            $success = $extension->save();
            
            if($success == true){
                header('Location: index.php?controller=extension&action=readAll&creation=true');
                exit;
            }
            else{
                ErrorController::createExtension();
                exit;
            }
    } 



    }