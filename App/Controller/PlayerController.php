<?php

    require_once File::build_path(array('Model', 'PlayerModel.php'));
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

            $nbGames = $player->getNbGamesPlayed();
            if(!isset($nbGames)){
                ErrorController::getNumberOfGamesPlayed();
                exit;
            }

            $avgGen = $player->getAvgGameTime();
            if(!isset($avgGen)){
                ErrorController::getAverageGenerationNumber();
                exit;
            }

            $nbVictories = $player->getNbPosition(1);
            if(!isset($nbVictories)){
                ErrorController::getNbVictoryPlayer();
                exit;
            }

            $freqVictory = $player->getFreqPosition($nbVictories, $nbGames);
            if(!isset($freqVictory)){
                ErrorController::getFreqVictoryPlayer();
                exit;
            }

            $totalPoints = $player->getTotalPoints();
            if(!isset($totalPoints)){
                ErrorController::getTotalPointsPlayer();
                exit;
            }

            $pointDetails = null;
            if($totalPoints > 0){
                $pointDetails = $player->getPointsDetail($totalPoints, $nbGames);
                if(!isset($totalPoints)){
                    ErrorController::getPointDetailPlayer();
                    exit;
                }
            }

            $avgPoints = $player->getAvgPoints();
            if(!isset($avgPoints)){
                ErrorController::getAveragePointsPlayer();
                exit;
            }
            
            $corporationChoices = $player->getCorporationFrequencyChoice();
            if(!isset($corporationChoices)){
                ErrorController::getRecordChosenCorporationPlayer();
                exit;
            }
            $mostChosenCorp = $corporationChoices['records']['most'];
            $leastChosenCorp = $corporationChoices['records']['least'];
            unset($corporationChoices['records']);

            $positionDetails = $player->getPositionDetail();
            if(!isset($positionDetails)){
                ErrorController::getPositionDetailPlayer();
                exit;
            }

            $controller = "Player";
            $view = "detail";
            $pageTitle = $player->getName() . " - Détails";
            require File::build_path(array('View', 'BaseView.php'));
        }

    }