<?php
	require_once File::build_path(array('Model', 'GameModel.php'));
    require_once File::build_path(array('Model', 'ExtensionModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));
    require_once File::build_path(array('Controller', 'GameDetailController.php'));

	class GameController{

        public static function home(){
            if(isset($_GET['creation'])){
                $creation = true;
            }

            /*$nbGames = GameModel::getNumberOfGamesPlayed();
            if(!isset($nbGames)){
                ErrorController::getNumberOfGamesPlayed();
                exit; 
            }*/

            $controller = "Game";
            $view = "home";
            $pageTitle = "Accueil";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $extensionArray = ExtensionModel::readAll();
            if(!isset($extensionArray)){
                ErrorController::readAllExtensions();
                exit;
            }
            $pageTitle = "Enregistrer une partie";
            $controller = "Game";
            $view = "create";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function created(){
            if(isset($_POST['number_player']) && isset($_POST['number_generation']) && isset($_POST['extensions_used'])){
                $nbPlayer = $_POST['number_player'];
                $nbGen = $_POST['number_generation'];
                $selectedExtensions = $_POST['extensions_used'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }

            $game = new GameModel(NULL, $nbPlayer, $nbGen, NULL);
            $gameSuccess = $game->save();
            $id = GameModel::getLastCreatedId();
            $game->setId($id);

            foreach ($selectedExtensions as $extensionId) {
                $linkSuccess = $game->linkToExtension($extensionId);
                if($linkSuccess != true){
                    ErrorController::linkGameToExtension();
                    exit;
                }
            }    

            if($gameSuccess == true){
                GameDetailController::setGameDetails($id, $nbPlayer);
            }
            else{
                ErrorController::createGame();
                exit;
            }
        }
    }