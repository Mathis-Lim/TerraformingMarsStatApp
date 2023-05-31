<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class  GameModel{

        private $gameId;
        private $numberOfPlayers;
        private $numberOfGenerations;
        private $winner;

        public function getId(){
            return $this->gameId;
        }

        public function getNumberOfPlayers(){
            return $this->numberOfPlayers;
        }

        public function getNumberOfGenerations(){
            return $this->numberOfGenerations;
        }

        public function getWinner(){
            return $this->winner;
        }

        public function setId($id){
            $this->gameId = $id;
        }

        public function setWinner($winner){
            $this->winner = $winner;
        }

        public function __construct($id = NULL, $nbPlayer = NULL, $nbGen = NULL, $winner = NULL){
            if(!is_null($id) && !is_null($nbPlayer) && !is_null($nbGen) && !is_null($winner)){
                $this->gameId = $id;
                $this->numberOfPlayers = $nbPlayer;
                $this->numberOfGenerations = $nbGen;
                $this->$winner = $winner;
                
            }
            elseif(!is_null($nbPlayer) && !is_null($nbGen)){
                $this->numberOfPlayers = $nbPlayer;
                $this->numberOfGenerations = $nbGen;
            }
            elseif(!is_null($id)){
                $this->gameId = $id;
            }
        }

        public function save(){
            $sql = "INSERT INTO Games(numberOfPlayers, numberOfGenerations) VALUES (:number_player, :number_generation)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                "number_player" => $this->numberOfPlayers,
                "number_generation" => $this->numberOfGenerations,
            );

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function getLastCreatedId(){
            $sql = "SELECT MAX(gameId) FROM Games";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $id = $result[0]->{'MAX(gameId)'};
            return $id;
        }

        public function linkToExtension($extensionId){
            $sql = "INSERT INTO ExtensionUsed(gameId, extensionId) VALUES (:game_id, :extension_id)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                "game_id" => $this->gameId,
                "extension_id" => $extensionId,
            );

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public function saveWinner(){
            $sql = "UPDATE Games SET winner = :winner WHERE gameId = :game_id";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                "game_id" => $this->gameId,
                "winner" => $this->winner,
            );

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function getNumberOfGamesPlayed(){
            $sql = "SELECT COUNT(*) FROM Games";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $nb = $result[0]->{'COUNT(*)'};
            return $nb;
        }

        public static function getNumberOfGenerationsPlayed(){
            $sql = "SELECT SUM(numberOfGenerations) FROM Games";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $nb = $result[0]->{'SUM(numberOfGenerations)'};
            return $nb;
        }

        public static function getAverageGenerationNumber(){
            $sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games;";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $nb = $result[0]->{'avg'};
            return $nb;
        }

        public static function getRecordWinner(){
            $sql = "SELECT MAX(nb) FROM (SELECT COUNT(gameId) as nb, winner FROM Games GROUP BY winner) as subquery";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $max = $result[0]->{'MAX(nb)'};

            $sql = "SELECT playerName FROM Players JOIN Games 
			ON Players.playerId = Games.winner 
			WHERE playerId IN 
				(SELECT winner FROM (SELECT COUNT(gameId) as nb, winner FROM Games GROUP BY winner)
			as subquery WHERE nb = " .$max .")";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
			$playerName = $result[0]->{'playerName'};

			return array(
				"player" => $playerName,
				"number" => $max,
			);
        }

        public function setGoal($goalId, $playerId){
            $sql = "INSERT INTO GoalFinanced(gameId, goalId, playerId) VALUES(:game_id, :goal_id, :player_id)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                ":game_id" => $this->gameId,
                ":goal_id" => $goalId,
                ":player_id" => $playerId,
            );
            
            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public function setAward($awardId, $playerId){
            $sql = "INSERT INTO AwardFinanced(gameId, awardId, playerId) VALUES(:game_id, :award_id, :player_id)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                ":game_id" => $this->gameId,
                ":award_id" => $awardId,
                ":player_id" => $playerId,
            );
            
            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

    }