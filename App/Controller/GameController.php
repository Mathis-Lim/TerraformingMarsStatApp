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
            echo('breakpoint1');
            if(isset($_POST['number_player']) && isset($_POST['number_generation']) && isset($_POST['extensions_used'])){
                $nbPlayer = $_POST['number_player'];
                $nbGen = $_POST['number_generation'];
                $selectedExtensions = $_POST['extensions_used'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }

            var_dump($selectedExtensions);

            $game = new GameModel(NULL, $nbPlayer, $nbGen, NULL);
            $gameSuccess = $game->save();

            foreach ($selectedExtensions as $extensionId) {
                $linkSuccess = $game->linkToExtension($extensionId);
                if($linkSuccess != true){
                    ErrorController::linkGameToExtension();
                    exit;
                }
            }    

            if($gameSuccess == true){
                echo 'chouette';
            }
            else{
                ErrorController::createGame();
                exit;
            }
        }
    }