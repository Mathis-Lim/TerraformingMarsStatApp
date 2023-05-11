<?php

    require_once File::build_path(array('Model', 'PlayerModel.php'));
    require_once File::build_path(array('Model', 'GameDetailModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

    class PlayerController{

        public static function readAll(){
            $playerArray = PlayerModel::readAll();
            if(!isset($playerArray)){
                ErrorController::readAllPlayers();
                exit;
            }
            else{
                if(isset($_GET['creation'])){
                    $creation = true;
                }
                $controller = "Player";
                $view = "list";
                $pageTitle = "Joueurs";
            }
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $controller = "Player";
            $view = "create";
            require File::build_path(array("View", "BaseView.php"));
        }

        public static function created(){

            if(isset($_GET['player_name'])){
                $playerName = $_GET['player_name'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }
            
            $player = new PlayerModel(NULL, $playerName);

            $success = $player->save();
            if($success == true){
                header('Location: index.php?controller=player&action=readAll&creation=true');
                exit;
            }
            else{
                ErrorController::createPlayer();
                exit;
            }
        }

        public static function read(){
            if(!isset($_GET['player_id'])){
                ErrorController::url();
                exit;
            }
            $playerId = $_GET['player_id'];

            $player = PlayerModel::getPlayerById($playerId);
            if(!isset($player)){
                ErrorController::getPlayer();
                exit;
            }

            $nbGames = GameDetailModel::getNbGamePlayedPlayer($playerId);
            if(!isset($nbGames)){
                ErrorController::getNumberOfGamesPlayed();
                exit;
            }

            $avgGen = GameDetailModel::getAvgGameTimePlayer($playerId);
            if(!isset($avgGen)){
                ErrorController::getAverageGenerationNumber();
                exit;
            }

            $nbVictories = GameDetailModel::getNbVictoryPlayer($playerId);
            if(!isset($nbVictories)){
                ErrorController::getNbVictoryPlayer();
                exit;
            }

            $freqVictory = GameDetailModel::getFreqVictoryPlayer($playerId);
            if(!isset($freqVictory)){
                ErrorController::getFreqVictoryPlayer();
                exit;
            }

            $controller = "Player";
            $view = "detail";
            $pageTitle = $player->getName() . " - Détails";
            require File::build_path(array('View', 'BaseView.php'));
        }

    }