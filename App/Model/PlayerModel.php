<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));
	require_once File::build_path(array('Model','GenericModel.php'));

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
			return GenericModel::readAll('Player');
        }

        public static function getPlayerById($id){
			try{
				$sql = "SELECT * FROM Players WHERE playerId=:player_id";
				$req_prep = ConnectionModel::getPDO()->prepare($sql);
				$values = array("player_id" => $id,);
				$req_prep->execute($values);
				$req_prep->setFetchMode(PDO::FETCH_CLASS, 'PlayerModel');
				$res = $req_prep->fetchAll();
				$player = $res[0];
				return $player;
			} catch(PDOExeception $e){
                return null;
            }
        }

		private function getGameIds($nbPlayers){
			$sql = "SELECT subquery2.gameId FROM 
				(SELECT gameId FROM 
					(SELECT gameId, COUNT(*) as nb FROM GameDetails GROUP BY gameId) as subquery 
				WHERE nb = :nb_player) as subquery2 
			JOIN GameDetails ON subquery2.gameId = GameDetails.gameId WHERE playerId = :player_id";
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array(
				"player_id" => $this->playerId,
				"nb_player" => $nbPlayers,
			);
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

        public function getAvgGameTime($gameIds){
			$sql = null;
			if(is_null($gameIds)){
				$sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games JOIN 
					GameDetails ON Games.gameId = GameDetails.gameId
				WHERE playerId=:player_id";
			}
			else{
				$sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games JOIN 
					GameDetails ON Games.gameId = GameDetails.gameId
				WHERE playerId=:player_id AND Games.gameId IN " .$gameIds ;
			}
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
			$values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$nb = $result[0]->{'avg'};
			if(isset($nb)){
				return $nb;
			}
			else{
				return 0;
			}
		}

        public function getNbPosition($rank){
			try{
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
			} catch(PDOExeception $e){
                return null;
            }
		}

        public function getFreqPosition($nbPosition, $nbGames){
			if($nbGames <= 0){
				return 0;
			}
			$freq = $nbPosition / $nbGames;
			return $freq;
		}

        public function getTotalPoints($gameIds){
			try{
				$sql = null;
				if(is_null($gameIds)){
					$sql = "SELECT SUM(score) as nb FROM GameDetails WHERE playerId=:player_id";
				}
				else{
					$sql = "SELECT SUM(score) as nb FROM GameDetails WHERE playerId=:player_id AND gameId IN " . $gameIds;
				}
				$req_prep = ConnectionModel::getPDO()->prepare($sql);
				$values = array("player_id" => $this->playerId,);
				$req_prep->execute($values);
				$req_prep->setFetchMode(PDO::FETCH_OBJ);
				$result = $req_prep->fetchAll();
				$nb = $result[0]->{'nb'};
				if(isset($nb)){
					return $nb;
				}
				else{
					return 0;
				}
			} catch(PDOExeception $e){
                return null;
            }
        }

        public function getAvgPoints(){
			try{
				$sql = "SELECT ROUND(AVG(score), 2) as avg FROM GameDetails WHERE playerId=:player_id";
				$req_prep = ConnectionModel::getPDO()->prepare($sql);
				$values = array("player_id" => $this->playerId,);
				$req_prep->execute($values);
				$req_prep->setFetchMode(PDO::FETCH_OBJ);
				$result = $req_prep->fetchAll();
				$avg = $result[0]->{'avg'};
				if(isset($avg)){
					return $avg;
				}
				else{
					return 0;
				}
			} catch(PDOExeception $e){
                return null;
            }
        }

        public function getCorporationFrequencyChoice(){
			try{
				$sql = "SELECT Corporations.corporationId, corporationName, SUM(chosenCount) AS chosenCount, 
				SUM(rejectedCount) AS rejectedCount FROM 
					( SELECT chosenCorporation AS corporationId, COUNT(gameId) AS chosenCount, 
					0 AS rejectedCount FROM GameDetails WHERE playerId=:player_id GROUP BY chosenCorporation 
				UNION 
					SELECT rejectedCorporation AS corporationId, 0 AS chosenCount, COUNT(gameId) AS rejectedCount 
					FROM GameDetails WHERE playerId=:player_id GROUP BY rejectedCorporation) AS subquery 
				JOIN Corporations ON subquery.corporationId = Corporations.corporationId 
				GROUP BY Corporations.corporationId, corporationName";
            	$res = ConnectionModel::getPDO()->prepare($sql);  
            	$values = array("player_id" => $this->playerId,);  
				$res->execute($values);
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

				$all = array();

				foreach($result as $line){
					$nbChosen = $line->{'chosenCount'};
					$total = $nbChosen + $line->{'rejectedCount'};
					$name = $line->{'corporationName'};
					if($total <= 0){
						$freqChosen = 0;
					}
					else{
						$freqChosen = $nbChosen / $total;
					}

					$currentCorp = array(
						"name" => $name,
						"frequency" => $freqChosen,
						"total" => $total,
					);

					if($most['frequency'] < $freqChosen){
					$most = $currentCorp;
					}
					elseif($most['frequency'] == $freqChosen && $most['total'] < $total){
						$most = $currentCorp;
					}
				
					if($least['frequency'] > $freqChosen){
						$least = $currentCorp;
					}
					elseif($least['frequency'] == $freqChosen && $least['total'] < $total){
						$least = $currentCorp;
					}
			
					array_push($all, $currentCorp);
				}

				$records = array(
					"most" => $most,
					"least" => $least,
				);
			
				$all['records'] = $records;
				return $all;
			} catch(PDOExeception $e){
                return null;
            }
		}

		public function getPointsDetail($total, $nbGames, $gameIds){
			$sql = null;
			if(is_null($gameIds)){
				$sql = "SELECT SUM(trScore) as tr, SUM(boardScore) as board, SUM(cardScore) as card, SUM(goalScore) as goal,
				SUM(awardScore) as award FROM GameDetails WHERE playerId=:player_id";
			}
			else{
				$sql = "SELECT SUM(trScore) as tr, SUM(boardScore) as board, SUM(cardScore) as card, SUM(goalScore) as goal,
				SUM(awardScore) as award FROM GameDetails WHERE playerId=:player_id AND gameId IN " . $gameIds;
			}
			$req_prep = ConnectionModel::getPDO()->prepare($sql);
			$values = array("player_id" => $this->playerId,);
			$req_prep->execute($values);
			$req_prep->setFetchMode(PDO::FETCH_OBJ);
			$result = $req_prep->fetchAll();
			$trScore = $result[0]->{'tr'};
			$boardScore = $result[0]->{'board'};
			$cardScore = $result[0]->{'card'};
			$goalScore = $result[0]->{'goal'};
			$awardScore = $result[0]->{'award'};

			$tr = array(
				"description" => "NT",
				"score" => $trScore,
				"avg" => round($trScore / $nbGames, 2),
				"proportion" => $trScore/$total,
			);

			$board = array(
				"description" => "Plateau",
				"score" => $boardScore,
				"avg" => round($boardScore / $nbGames, 2),
				"proportion" => $boardScore/$total,
			);

			$cards = array(
				"description" => "Cartes",
				"score" => $cardScore,
				"avg" => round($cardScore / $nbGames, 2),
				"proportion" => $cardScore/$total,
			);

			$goals = array(
				"description" => "Objectifs",
				"score" => $goalScore,
				"avg" => round($goalScore / $nbGames, 2),
				"proportion" => $goalScore/$total,
			);

			$awards = array(
				"description" => "Récompenses",
				"score" => $awardScore,
				"avg" => round($awardScore / $nbGames, 2),
				"proportion" => $awardScore/$total,
			);

			$details = array($tr, $board, $cards, $goals, $awards,);

			return $details;
		}

		public function getPositionDetailAux($gameIds, $nbPlayers, $nbGames){
			$detailByPosition = array();

			for($i = 1; $i <= $nbPlayers; $i++){
				$sql = "SELECT COUNT(*) as nb FROM GameDetails 
				WHERE gameId IN " . $gameIds . " AND playerId = " . $this->playerId . " AND rank = ". $i;
				$req = ConnectionModel::getPDO()->query($sql);
				$req->setFetchMode(PDO::FETCH_OBJ);
				$result = $req->fetchAll();
				$nb = $result[0]->{'nb'};

				$positionDetail = array(
					"position" => $i,
					"total" => $nb,
					"proportion" => 0,
				);

				if($nb > 0){
					$positionDetail['proportion'] = round(($nb / $nbGames) * 100, 2);
				}

				array_push($detailByPosition, $positionDetail);

			}
			return $detailByPosition;
		}

		/*public function getPositionDetail(){
			$details = array();
			for($i = 2; $i < 6; $i++){
				$gameIds = $this->getGameIds($i);
				if($gameIds === 0){
					array_push($details, 0);
					continue;
				}
				$detail = $this->getPositionDetailAux($gameIds, $i);
				array_push($details, $detail);
			}
			return $details;
		}*/

		public function getStatsByNbPlayers(){
			$details = array();
			for($i = 2; $i < 6; $i++){
				$gameIds = $this->getGameIds($i);
				if($gameIds === 0){
					array_push($details, 0);
					continue;
				}
				$nbGames = $nbGames = substr_count($gameIds, ',') + 1;
				$avgGameTime = $this->getAvgGameTime($gameIds);
				$totalPoints = $this->getTotalPoints($gameIds);
				$rankDetail = $this->getPositionDetailAux($gameIds, $i, $nbGames);
				$scoreDetail = $this->getPointsDetail($totalPoints, $nbGames, $gameIds);

				$detail = array(
					"nb_players" => $i,
					"nb_games" => $nbGames,
					"avg_game_time" => $avgGameTime,
					"total_score" => $totalPoints,
					"rank" => $rankDetail,
					"score" => $scoreDetail,
				);
				array_push($details, $detail);
			}
			return $details;
		}

    }

