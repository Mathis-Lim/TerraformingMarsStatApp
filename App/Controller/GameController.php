<?php
	require_once File::build_path(array('Model', 'GameModel.php'));
    require_once File::build_path(array('Model', 'ExtensionModel.php'));
    require_once File::build_path(array('Model', 'MapModel.php'));
    require_once File::build_path(array('Model', 'PlayerModel.php'));
    require_once File::build_path(array('Model', 'CorporationModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));
    require_once File::build_path(array('Controller', 'GameDetailController.php'));

	class GameController{

        public static function home(){
            if(isset($_GET['creation'])){
                $creation = true;
            }

            $lastGameId = GameModel::getLastCreatedId();
            $lastGame = GameModel::getById($lastGameId);
            $lastGameWinnerDetails = GameDetailModel::getByIds($lastGameId, $lastGame->getWinner());

            $winner = PlayerModel::getNameById($lastGame->getWinner());
            $winnerScore = $lastGameWinnerDetails->getScore();
            $winnerCorp = CorporationModel::getNameById($lastGameWinnerDetails->getChosenCorporation());
            $nbPlayers = $lastGame->getNumberOfPlayers();
            $nbGen = $lastGame->getNumberOfGenerations();
            $mapUsed = MapModel::getNameById($lastGame->getMapId());

            $controller = "Game";
            $view = "home";
            $pageTitle = "Accueil";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $extensionArray = ExtensionModel::readAll();
            $mapArray = MapModel::readAll();
            $pageTitle = "Enregistrer une partie";
            $controller = "Game";
            $view = "create";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function created(){
            if(isset($_POST['number_player']) && isset($_POST['number_generation']) && isset($_POST['extensions_used'])
            && isset($_POST['map_id'])){
                $nbPlayer = $_POST['number_player'];
                $nbGen = $_POST['number_generation'];
                $selectedExtensions = $_POST['extensions_used'];
                $mapId = $_POST['map_id'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }

            $game = new GameModel(NULL, $nbPlayer, $nbGen, NULL, $mapId);
            $gameSuccess = $game->save();
            $id = GameModel::getLastCreatedId();
            if(!isset($id)){
                ErrorController::getLastCreatedGameId();
                exit;
            }
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

        public static function playerStats(){

            $mostPlayed = GameDetailModel::getMostPlayed();
            $recordWinner = GameModel::getRecordWinner();
            $recordTotalPoints = GameDetailModel::getTotalPointsRecordsDetails();
            //$recordPoints = GameDetailModel::getPointsRecordDetails();
            $recordAvgPoints = GameDetailModel::getRecordAvgPointsDetail();
            $nbPlayerDetails = GameDetailModel::getStatsByNbPlayer();

            $controller = "Game";
            $view = "playerStats";
            $pageTitle = "Statistiques";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function corporationStats(){

            $corporationFrequencyRecords = GameDetailModel::getRecordChosenCorporation();
            $mostChosenCorp = $corporationFrequencyRecords['most'];
            $leastChosenCorp = $corporationFrequencyRecords['least'];
            $recordWinnerCorporation = GameDetailModel::getRecordWinsCorporation();
            $recordPointsCorporation = GameDetailModel::getRecordPointsCorporation();

            $controller = "Game";
            $view = "corporationStats";
            $pageTitle = "Statistiques";
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function otherStats(){

            $nbGames = GameModel::getNumberOfGamesPlayed();
            $nbGenerations = GameModel::getNumberOfGenerationsPlayed();
            $maxGen = GameModel::getMostGenerations();
            $minGen = GameModel::getLeastGenerations();
            $nbPoints = GameDetailModel::getTotalPoints();
            $avgPoints = GameDetailModel::getAveragePoints();
            $pointDetails = GameDetailModel::getTotalPointDetails($nbPoints);
            $avgGen = GameModel::getAverageGenerationNumber();

            $goalStats = GameModel::getGoalStats($nbGames);
            $awardStats = GameModel::getAwardStats($nbGames);

            $controller = "Game";
            $view = "otherStats";
            $pageTitle = "Statistiques";
            require File::build_path(array('View', 'BaseView.php'));
        }
        
    }