<?php

    require_once File::build_path(array('Model', 'GameDetailModel.php'));
    require_once File::build_path(array('Model', 'GameModel.php'));
    require_once File::build_path(array('Model', 'PlayerModel.php'));
    require_once File::build_path(array('Model', 'CorporationModel.php'));
    require_once File::build_path(array('Model', 'GoalModel.php'));
    require_once File::build_path(array('Model', 'AwardModel.php'));
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

            $playersId = array();

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

                array_push($playersId, $playerId);

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
                GameDetailController::setGoalsAwards($gameId, $playersId);
            }
            else{
                ErrorController::setGameDetails();
                    exit;
            }
        }

        public static function setGoalsAwards($gameId, $playersId){
            $playerArray = array();
            foreach($playersId as $playerId){
                $player = PlayerModel::getPlayerById($playerId);
                array_push($playerArray, $player);
            }
            $goalArray = GoalModel::readAll();
            $awardArray = AwardModel::readAll();

            $controller = "GameDetail";
            $view = "setGoalsAwards";
            $pageTitle = "Enregistrer une partie";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function goalsAwardsSet(){
            $gameId = $_POST['game_id'];
            $game = new GameModel($gameId, NULL, NULL, NULL);

            for($i = 1; $i < 4; $i++){
                if(isset($_POST['goal_' . $i])){
                    $goalId = $_POST['goal_' . $i];
                    $playerId = $_POST['goal_player_' . $i];
                    if(empty($goalId) || empty($playerId)){
                        break;
                    }
                    else{
                        $success = $game->setGoal($goalId, $playerId);
                        if($success == FALSE){
                            ErrorController::setGoals();
                            exit;
                        }
                    }
                }
            }    

            for($i = 1; $i < 4; $i++){
                if(isset($_POST['award_' . $i])){
                    $awardId = $_POST['award_' . $i];
                    $playerId = $_POST['award_player_' . $i];
                    if(empty($awardId) || empty($playerId)){
                        break;
                    }
                    else{
                        $success = $game->setAward($awardId, $playerId);
                        if($success == FALSE){
                            ErrorController::setAwards();
                            exit;
                        }
                    }
                }
            }

            header('Location: index.php?controller=game&action=home&creation=true');
        }

    }    

