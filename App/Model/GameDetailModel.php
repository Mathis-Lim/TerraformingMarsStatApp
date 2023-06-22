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
			$trScore, $boardScore, $cardScore, $goalScore, $awardScore, $score = NULL) {

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
			if(is_null($score)){
				$this->score = $trScore + $boardScore + $cardScore +$goalScore + $awardScore;
			}
			else{
				$this->score = $score;
			}
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

		public function getScore(){
			return $this->score;
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

		public static function getByIds($gameId, $playerId){
			$sql = "SELECT * FROM GameDetails WHERE gameId = " . $gameId . " AND playerId = " . $playerId;
			$req = ConnectionModel::getPDO()->query($sql);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$res = $req->fetchAll();
			$res = $res[0];

			$chosenCorp = $res->chosenCorporation;
			$rejectedCorp = $res->rejectedCorporation;
			$rank = $res->rank;
			$tr = $res->trScore;
			$board = $res->boardScore;
			$card = $res->cardScore;
			$goal = $res->goalScore;
			$award = $res->awardScore;
			$score = $res->score;

			$gameDetails = new GameDetailModel($gameId, $playerId, $chosenCorp, $rejectedCorp, $rank, $tr, $board, $card, $goal,
				$award, $score);
			return $gameDetails;
			
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
			try{
				$sql = "SELECT ROUND(AVG(score), 2) as avg FROM GameDetails;";
            	$res = ConnectionModel::getPDO()->query($sql);
            	$res->setFetchMode(PDO::FETCH_OBJ);
            	$result = $res->fetchAll();
            	$nb = $result[0]->{'avg'};
            	return $nb;
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getMostPlayed(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT COUNT(gameId) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
            	$res->setFetchMode(PDO::FETCH_OBJ);
            	$result = $res->fetchAll();
            	$max = $result[0]->{'MAX(nb)'};

				$sql = "SELECT DISTINCT playerName FROM Players JOIN GameDetails 
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
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordTotalPoints($pointAttribute, $description){
			try{
				$sql = "SELECT MAX(nb) FROM 
					(SELECT SUM(" . $pointAttribute . ") as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};
				
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT SUM(" . $pointAttribute . ") as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => $description,
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getTotalPointsRecordsDetails(){
			$total = GameDetailModel::getRecordTotalPoints("score", "en tout");
			$tr = GameDetailModel::getRecordTotalPoints("trScore", "de NT");
			$board = GameDetailModel::getRecordTotalPoints("boardScore", "de plateau");
			$card = GameDetailModel::getRecordTotalPoints("cardScore", "de cartes");
			$goal =GameDetailModel::getRecordTotalPoints("goalScore", "d'objectif");
			$award = GameDetailModel::getRecordTotalPoints("awardScore", "de récompense");

			$details = array($total, $tr, $board, $card, $goal, $award);
			return($details);
		}

		private static function getGameIds($nbPlayers){
			$sql = "SELECT subquery2.gameId FROM 
				(SELECT gameId FROM 
					(SELECT gameId, COUNT(*) as nb FROM GameDetails GROUP BY gameId) as subquery 
				WHERE nb = :nb_player) as subquery2 
			JOIN GameDetails ON subquery2.gameId = GameDetails.gameId";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("nb_player" => $nbPlayers,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			
			$nbGames = sizeof($result);
			if($nbGames < 1){
				return 0;
			}
			$gameIds = "(";
			$nbGames = sizeof($result);
			
			for($i = 0; $i < $nbGames-1; $i++){
				$gameIds = $gameIds . $result[$i]->{'gameId'} . ", ";
			}
			$gameIds = $gameIds . $result[$nbGames - 1]->{'gameId'} . ")";

			return $gameIds;
		}

		public static function getRecordPoints($pointAttribute, $description, $gameIds){
			try{
				$sql = "SELECT MAX(" . $pointAttribute .") as max FROM GameDetails WHERE gameId IN " . $gameIds;
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'max'};
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId
				WHERE Players.playerId IN
					(SELECT playerId FROM GameDetails WHERE score = " . $max .")
				AND gameId IN " . $gameIds;
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => $description,
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordTrPoints(){
			try{
				$sql = "SELECT MAX(trScore) as max FROM GameDetails";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'max'};
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId
				WHERE Players.playerId IN
					(SELECT playerId FROM GameDetails WHERE trScore = " . $max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "de NT",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordBoardPoints(){
			try{
				$sql = "SELECT MAX(boardScore) as max FROM GameDetails";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'max'};
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId
				WHERE Players.playerId IN
					(SELECT playerId FROM GameDetails WHERE boardScore = " . $max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};

				return array(
					"description" => "de plateau",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}
		
		public static function getRecordCardPoints(){
			try{
				$sql = "SELECT MAX(cardScore) as max FROM GameDetails";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'max'};
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId
				WHERE Players.playerId IN
					(SELECT playerId FROM GameDetails WHERE cardScore = " . $max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "de cartes",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getPointsRecordDetails($gameIds){
			$total = GameDetailModel::getRecordPoints("score", "en tout", $gameIds);
			$tr = GameDetailModel::getRecordPoints("trScore", "de NT", $gameIds);
			$board = GameDetailModel::getRecordPoints("boardScore", "de plateau", $gameIds);
			$card = GameDetailModel::getRecordPoints("cardScore", "de carte", $gameIds);

			$detail = array($total, $tr, $board, $card);
			return ($detail);
		}

		public static function getStatsByNbPlayers(){
			$details = array();
			for($i = 2; $i < 6; $i++){
				$gameIds = GameDetailModel::getGameIds($i);
				if($gameIds === 0){
					array_push($details, 0);
					continue;
				}
				$pointRecords = GameDetailModel::getPointsRecordDetails($gameIds);

				$detail = array(
					"point_records" => $pointRecords;
				);
				array_push($details, $detail);
			}
			return $details;
		}

		public static function getRecordAvgPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(score), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(score),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "totaux",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgTrPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(trScore), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(trScore),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "de NT",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgBoardPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(boardScore), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(boardScore),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};

				return array(
					"description" => "de plateau",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgCardPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(cardScore), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(cardScore),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "de cartes",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgGoalPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(goalScore), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(goalScore),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "d'objectifs",
					"player" => $playerName,
					"number" => $max,
					"nb_games" =>$nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgAwardPoints(){
			try{
				$sql = "SELECT MAX(nb) FROM (SELECT ROUND(AVG(awardScore), 2) as nb, playerId FROM GameDetails GROUP BY playerId) as subquery";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$max = $result[0]->{'MAX(nb)'};   	
	
				$sql = "SELECT DISTINCT playerName, COUNT(*) as nbGames FROM Players JOIN GameDetails 
				ON Players.playerId = GameDetails.playerId  
				WHERE Players.playerId IN 
					(SELECT playerId FROM (SELECT ROUND(AVG(awardScore),2) as nb, playerId FROM GameDetails GROUP BY playerId)
				as subquery WHERE nb = " .$max .")";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
				$playerName = $result[0]->{'playerName'};
				$nbGames = $result[0]->{'nbGames'};
	
				return array(
					"description" => "de récompenses",
					"player" => $playerName,
					"number" => $max,
					"nb_games" => $nbGames,
				);
			} catch(PDOException $e) {
                return null;
            }
		}

		public static function getRecordAvgPointsDetail(){
			$total = GameDetailModel::getRecordAvgPoints();
			$tr = GameDetailModel::getRecordAvgTrPoints();
			$board = GameDetailModel::getRecordAvgBoardPoints();
			$card = GameDetailModel::getRecordAvgCardPoints();
			$goal = GameDetailModel::getRecordAvgGoalPoints();
			$award = GameDetailModel::getRecordAvgAwardPoints();

			$details = array($total, $tr, $board, $card, $goal, $award,);
			return($details);
		}

		public static function getRecordChosenCorporation(){
			try{
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
					"frequency" => 1,
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
	
					$records = array(
						"most" => $most,
						"least" => $least,
					);
				}
				return $records;
			} catch(PDOException $e) {
				return null;
			}
		}

		public static function getRecordWinsCorporation(){
			try{
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
			} catch(PDOException $e) {
				return null;
			}
		}

		public static function getRecordPointsCorporation(){
			try{
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
			} catch(PDOException $e) {
				return null;
			}
		}

		public function getTotalPointDetails($totalPoints){
			try{
				$sql = "SELECT SUM(trScore) as tr, SUM(boardScore) as board, SUM(cardScore) as card, SUM(goalScore) as goal,
				SUM(awardScore) as award FROM GameDetails";
				$res = ConnectionModel::getPDO()->query($sql);
				$res->setFetchMode(PDO::FETCH_OBJ);
				$result = $res->fetchAll();
	
				$tr = $result[0]->{'tr'};
				$board = $result[0]->{'board'};
				$card = $result[0]->{'card'};
				$goal = $result[0]->{'goal'};
				$award = $result[0]->{'award'};
	
				$sql = "SELECT COUNT(*) as nb FROM GameDetails";
				$req = ConnectionModel::getPDO()->query($sql);
				$req->setFetchMode(PDO::FETCH_OBJ);
				$result = $req->fetchAll();
				$nbEntries = $result[0]->{'nb'};
	
				$trDetail = array(
					"description" => "NT",
					"score" => $tr,
					"avg" => round($tr / $nbEntries, 2),
					"proportion" => $tr / $totalPoints,
				);
	
				$boardDetail = array(
					"description" => "Plateau",
					"score" => $board,
					"avg" => round($board / $nbEntries, 2),
					"proportion" => $board / $totalPoints,
				);
	
	
				$cardDetail = array(
					"description" => "Cartes",
					"score" => $card,
					"avg" => round($card / $nbEntries, 2),
					"proportion" => $card / $totalPoints,
				);
	
	
				$goalDetail = array(
					"description" => "Objectifs",
					"score" => $goal,
					"avg" => round($goal / $nbEntries, 2),
					"proportion" => $goal / $totalPoints,
				);
	
	
				$awardDetail = array(
					"description" => "Récompenses",
					"score" => $award,
					"avg" => round($award / $nbEntries, 2),
					"proportion" => $award / $totalPoints,
				);
	
				$details = array($trDetail, $boardDetail, $cardDetail, $goalDetail, $awardDetail);
				return($details);
			}catch(PDOException $e) {
				return null;
			}
        } 

    }



	