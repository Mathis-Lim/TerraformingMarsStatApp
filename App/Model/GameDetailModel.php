<?php

require_once File::build_path(array('Model','ConnectionModel.php'));

    class GameDetailModel{

        private $gameId;
	    private $playerId;
	    private $chosenCorporation;
	    private $rejectedCorporation;
	    private $rank;
	    private $trScore;
	    private $boardScore;
	    private $cardScore;
	    private $goalScore;
	    private $awardScore;
		private $score;

		public function __construct($gameId, $playerId, $chosenCorporation, $rejectedCorporation, $rank,
			$trScore, $boardScore, $cardScore, $goalScore, $awardScore) {

			$this->gameId = $gameId;
			$this->playerId = $playerId;
			$this->chosenCorporation = $chosenCorporation;
			$this->rejectedCorporation = $rejectedCorporation;
			$this->rank = $rank;
			$this->trScore = $trScore;
			$this->boardScore = $boardScore;
			$this->cardScore = $cardScore;
			$this->goalScore = $goalScore;
			$this->awardScore = $awardScore;
			$this->score = $trScore + $boardScore + $cardScore +$goalScore + $awardScore;
		}

		public function getGameId() {
			return $this->gameId;
		}
	
		public function getPlayerId() {
			return $this->playerId;
		}
	
		public function getChosenCorporation() {
			return $this->chosenCorporation;
		}
	
		public function getRejectedCorporation() {
			return $this->rejectedCorporation;
		}
	
		public function getRank() {
			return $this->rank;
		}
	
		public function getTrScore() {
			return $this->trScore;
		}
	
		public function getBoardScore() {
			return $this->boardScore;
		}
	
		public function getCardScore() {
			return $this->cardScore;
		}
	
		public function getGoalScore() {
			return $this->goalScore;
		}
	
		public function getAwardScore() {
			return $this->awardScore;
		}

		public function save() {
            $sql = "INSERT INTO GameDetails (gameId, playerId, chosenCorporation, rejectedCorporation, rank, 
                trScore, boardScore, cardScore, goalScore, awardScore, score) 
                VALUES (:gameId, :playerId, :chosenCorporation, :rejectedCorporation, :rank, 
                :trScore, :boardScore, :cardScore, :goalScore, :awardScore, :score)";

            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
                "gameId" => $this->gameId,
                "playerId" => $this->playerId,
                "chosenCorporation" => $this->chosenCorporation,
                "rejectedCorporation" => $this->rejectedCorporation,
                "rank" => $this->rank,
                "trScore" => $this->trScore,
                "boardScore" => $this->boardScore,
                "cardScore" => $this->cardScore,
                "goalScore" => $this->goalScore,
                "awardScore" => $this->awardScore,
				"score" => $this->score,
            );
    
            try {
                $req_prep->execute($values);
                return true;
            } catch(PDOException $e) {
                return false;
            }
        }

		public static function getTotalPoints(){
			$sql = "SELECT SUM(score) FROM GameDetails";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $nb = $result[0]->{'SUM(score)'};
            return $nb;
		}

		public static function getAveragePoints(){
			$sql = "SELECT ROUND(AVG(score), 2) as avg FROM GameDetails;";
            $res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $nb = $result[0]->{'avg'};
            return $nb;
		}

		public static function getMostPlayed(){
			$sql = "SELECT MAX(nb) FROM (SELECT COUNT(gameId) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $max = $result[0]->{'MAX(nb)'};

			$sql = "SELECT playerName FROM Players JOIN GameDetails 
			ON Players.playerId = GameDetails.playerId 
			WHERE Players.playerId IN 
				(SELECT playerId FROM (SELECT COUNT(gameId) as nb, playerId FROM GameDetails GROUP BY playerId)
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

    }