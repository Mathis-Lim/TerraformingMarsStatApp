<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class PlayerModel{

        private $playerId;
        private $playerName;

        public function getId(){
            return $this->playerId;
        }

        public function getName(){
            return $this->playerName;
        }

        public function __construct($id = NULL, $name = NULL){
            if(!is_null($id) && !is_null($name)){
                $this->playerId = $id;
                $this->playerName = $name;
            }
            elseif(!is_null($name)){
                $this->playerName = $name;
            }
        }

        public function save(){
            $sql = "INSERT INTO Players(playerName) VALUES (:player_name)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_name" => $this->playerName,);

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function readAll(){
            $req = ConnectionModel::getPDO()->query("SELECT * FROM Players");
            $req->setFetchMode(PDO::FETCH_CLASS, 'PlayerModel');
            $res = $req->fetchAll();
            return $res;
        }

        public static function getPlayerById($id){
            $sql = "SELECT * FROM Players WHERE playerId=:player_id";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $id,);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'PlayerModel');
            $res = $req_prep->fetchAll();
            $player = $res[0];
            return $player;
        }

        public function getNbGamesPlayed(){
			$sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE playerId = :player_id";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'nb'};
			return $nb;
		}

        public function getAvgGameTime(){
			$sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games JOIN GameDetails ON Games.gameId = GameDetails.gameId
			WHERE playerId=:player_id GROUP BY playerId";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'avg'};
			return $nb;
		}

        public function getNbPosition($rank){
			$sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE playerId=:player_id AND rank=:rank";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                "player_id" => $this->playerId,
                "rank" => $rank,
            );
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'nb'};
			return $nb;
		}

        public function getFreqPosition($rank){
			$nbPosition = $this->getNbPosition($rank);
			$nbGames = $this->getNbGamesPlayed();
			$freq = $nbPosition / $nbGames;
			return $freq;
		}

        public function getTotalPoints(){
            $sql = "SELECT SUM(score) as nb FROM GameDetails WHERE playerId=:player_id";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'nb'};
			return $nb;
        }

        public function getAvgPoints(){
            $sql = "SELECT ROUND(AVG(score), 2) as avg FROM GameDetails WHERE playerId=:player_id";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
            $avg = $result[0]->{'avg'};
            return $avg;
        }


    }

