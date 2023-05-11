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

		public static function getRecordPoints(){
			$sql = "SELECT MAX(nb) FROM (SELECT SUM(score) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $max = $result[0]->{'MAX(nb)'};

			$sql = "SELECT playerName FROM Players JOIN GameDetails 
			ON Players.playerId = GameDetails.playerId  
			WHERE Players.playerId IN 
				(SELECT playerId FROM (SELECT SUM(score) as nb, playerId FROM GameDetails GROUP BY playerId)
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

		public static function getRecordChosenCorporation(){
			$sql = "SELECT Corporations.corporationId, corporationName, SUM(chosenCount) AS chosenCount, 
				SUM(rejectedCount) AS rejectedCount 
				FROM ( SELECT chosenCorporation AS corporationId, COUNT(gameId) AS chosenCount, 
				0 AS rejectedCount FROM GameDetails GROUP BY chosenCorporation 
				UNION SELECT rejectedCorporation AS corporationId, 0 AS chosenCount, COUNT(gameId) AS rejectedCount 
				FROM GameDetails GROUP BY rejectedCorporation) AS subquery 
				JOIN Corporations ON subquery.corporationId = Corporations.corporationId 
				GROUP BY Corporations.corporationId, corporationName";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
			
			$most = array(
				"name" => "placeholder",
				"frequency" => 0,
				"total" => 0,
			);
			$least = array(
				"name" => "placeholder",
				"frequency" => 0,
				"total" => 0,
			);

			foreach($result as $line){
				$nbChosen = $line->{'chosenCount'};
				$total = $nbChosen + $line->{'rejectedCount'};
				$freqChosen = $nbChosen / $total;

				if($most['frequency'] < $freqChosen){
					$most = array(
						"name" => $line->{'corporationName'},
						"frequency" => $freqChosen,
						"total" => $total,
					);
				}
				elseif($most['frequency'] == $freqChosen && $most['total'] < $total){
					$most = array(
						"name" => $line->{'corporationName'},
						"frequency" => $freqChosen,
						"total" => $total,
					);
				}
				
				if($least['frequency'] > $freqChosen){
					$least = array(
						"name" => $line->{'corporationName'},
						"frequency" => $freqChosen,
						"total" => $total,
					);
				}
				elseif($least['frequency'] == $freqChosen && $least['total'] < $total){
					$least = array(
						"name" => $line->{'corporationName'},
						"frequency" => $freqChosen,
						"total" => $total,
					);
				}		
			}

			$records = array(
				"most" => $most,
				"least" => $least,
			);
			return $records;
		}

		public static function getRecordWinsCorporation(){
			$sql = "SELECT MAX(nb) FROM (SELECT COUNT(gameId) as nb, chosenCorporation FROM GameDetails
			WHERE rank = 1 GROUP BY chosenCorporation) as subquery";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $max = $result[0]->{'MAX(nb)'};

			$sql = "SELECT corporationName FROM Corporations JOIN GameDetails 
			ON Corporations.corporationId = GameDetails.chosenCorporation  
			WHERE corporationId IN 
				(SELECT chosenCorporation FROM (SELECT COUNT(gameId) as nb, chosenCorporation FROM GameDetails
				WHERE rank = 1 GROUP BY chosenCorporation)
			as subquery WHERE nb = " .$max .")";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
			$playerName = $result[0]->{'corporationName'};

			return array(
				"corporation" => $playerName,
				"number" => $max,
			);
		}

		public static function getRecordPointsCorporation(){
			$sql = "SELECT MAX(nb) FROM (SELECT SUM(score) as nb, chosenCorporation FROM GameDetails GROUP BY chosenCorporation) as subquery";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
            $max = $result[0]->{'MAX(nb)'};

			$sql = "SELECT corporationName FROM Corporations JOIN GameDetails 
			ON Corporations.corporationId = GameDetails.chosenCorporation  
			WHERE corporationId IN 
				(SELECT chosenCorporation FROM (SELECT SUM(score) as nb, chosenCorporation FROM GameDetails GROUP BY chosenCorporation)
			as subquery WHERE nb = " .$max .")";
			$res = ConnectionModel::getPDO()->query($sql);
            $res->setFetchMode(PDO::FETCH_OBJ);
            $result = $res->fetchAll();
			$playerName = $result[0]->{'corporationName'};

			return array(
				"corporation" => $playerName,
				"number" => $max,
			);
		}

		public static function getNbGamePlayedPlayer($id){
			$sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE playerId = :player_id";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $id,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'nb'};
			return $nb;
		}

		public static function getAvgGameTimePlayer($id){
			$sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games JOIN GameDetails ON Games.gameId = GameDetails.gameId
			WHERE playerId=:player_id GROUP BY playerId";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $id,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'avg'};
			return $nb;
		}

		public static function getNbVictoryPlayer($id){
			$sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE playerId=:player_id AND rank=1";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("player_id" => $id,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'nb'};
			return $nb;
		}

		public static function getFreqVictoryPlayer($id){
			$nbVictory = GameDetailModel::getNbVictoryPlayer($id);
			$nbGames = GameDetailModel::getNbGamePlayedPlayer($id);
			$freq = $nbVictory / $nbGames;
			return $freq;
		}

    }



	