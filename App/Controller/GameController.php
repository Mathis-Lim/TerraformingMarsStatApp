<?php
	require_once File::build_path(array('Model', 'GameModel.php'));
    require_once File::build_path(array('Model', 'ExtensionModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

	class GameController{

        public static function home(){
            $extensionArray = ExtensionModel::readAll();
            if(!isset($extensionArray)){
                ErrorController::readAllExtensions();
                exit;
            }
            else{
                $controller = "Game";
                $view = "home";
                $pageTitle = "Accueil";
                require File::build_path(array('View', 'BaseView.php'));
            }
        }

        public static function create(){
            $controller = "Game";
            $view = "create";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function created(){
            if(isset($_GET['number_player']) && isset($_GET['number_generation'])){
                $nbPlayer = $_GET['number_player'];
                $nbGen = $_GET['number_generation'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }

            $game = new GameModel(NULL, $nbPlayer, $nbGen, NULL);
            $success = $game->save();

            if($success == true){
                echo 'chouette';
            }
            else{
                ErrorController::createGame();
                exit;
            }

        }
    }