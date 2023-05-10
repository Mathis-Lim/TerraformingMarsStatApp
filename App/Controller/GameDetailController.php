<?php

    require_once File::build_path(array('Model', 'GameDetailModel.php'));
    require_once File::build_path(array('Model', 'GameModel.php'));
    require_once File::build_path(array('Model', 'PlayerModel.php'));
    require_once File::build_path(array('Model', 'CorporationModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

    class GameDetailController{

        public static function setGameDetails($gameId, $nbPlayer){
            $playerArray = PlayerModel::readAll();
            $corporationArray = CorporationModel::readAll();
            $controller = "GameDetail";
            $view = "create";
            $pageTitle = "Enregistrer une partie";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function gameDetailsSet(){
            $nbPlayer = $_POST['player_number'];
            $gameId = $_POST['game_id'];
            $game = new GameModel($gameId, NULL, NULL, NULL);

            for ($i = 1; $i <= $nbPlayer; $i++) {
                $playerId = $_POST['player_' . $i];
                $chosenCorporation = $_POST['chosen_corporation_' . $i];
                $rejectedCorporation = $_POST['rejected_corporation_' . $i];
                $rank = $_POST['rank_' . $i];
                $trScore = $_POST['tr_score_' . $i];
                $boardScore = $_POST['board_score_' . $i];
                $cardScore = $_POST['card_score_' . $i];
                $goalScore = $_POST['goal_score_' . $i];
                $awardScore = $_POST['award_score_' . $i];

                if($rank == 1){
                    $game->setWinner($playerId);
                }

                $gameDetail = new GameDetailModel($gameId, $playerId, $chosenCorporation, $rejectedCorporation, $rank,
                    $trScore, $boardScore, $cardScore, $goalScore, $awardScore);
                $success = $gameDetail->save();    
                if($success == FALSE){
                    ErrorController::setGameDetails();
                    exit;
                }
            }    

            $success = $game->saveWinner();
            if($success == TRUE){
                header('Location: index.php?controller=game&action=home&creation=true');
                exit;
            }
            else{
                ErrorController::setGameDetails();
                    exit;
            }
        }
    }    

