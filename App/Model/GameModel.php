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
            try{
                $sql = "SELECT MAX(gameId) FROM Games";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $id = $result[0]->{'MAX(gameId)'};
                return $id;
            } catch(PDOExeception $e){
                return null;
            } 
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
            try{
                $sql = "SELECT COUNT(*) FROM Games";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nb = $result[0]->{'COUNT(*)'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public static function getNumberOfGenerationsPlayed(){
            try{
                $sql = "SELECT SUM(numberOfGenerations) FROM Games";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nb = $result[0]->{'SUM(numberOfGenerations)'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }    

        public static function getAverageGenerationNumber(){
            try{
                $sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games;";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nb = $result[0]->{'avg'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public static function getRecordWinner(){
            try{
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

                $sql = "SELECT COUNT(*) as nbGames FROM GameDetails JOIN Players ON GameDetails.playerId = Players.playerId
                WHERE playerName = '" . $playerName . "' GROUP BY playerName";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nbGames = $result[0]->{'nbGames'};
    
                return array(
                    "player" => $playerName,
                    "number" => $max,
                    "nb_games" => $nbGames,
                );
            } catch(PDOExeception $e){
                return null;
            }
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

        public static function getMostGenerations(){
            try{
                $sql = "SELECT MAX(numberOfGenerations) as max FROM Games";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nb = $result[0]->{'max'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public static function getLeastGenerations(){
            try{
                $sql = "SELECT MIN(numberOfGenerations) as min FROM Games";
                $res = ConnectionModel::getPDO()->query($sql);
                $res->setFetchMode(PDO::FETCH_OBJ);
                $result = $res->fetchAll();
                $nb = $result[0]->{'min'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public static function getGoalStats($nbGames){
            try{
                $sql = "SELECT IFNULL(subquery2.nb, 0) AS count, goalName FROM
                    (SELECT goalId, goalName FROM Goals) as subquery
                LEFT JOIN
                    (SELECT COUNT(*) as nb, goalId FROM GoalFinanced GROUP BY goalId) as subquery2
                ON subquery.goalId = subquery2.goalId ORDER BY count DESC";
                $req = ConnectionModel::getPDO()->query($sql);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();

                $goalStats = array();
                $totalGoalsFinanced = 0;

                foreach($result as $row){
                    $count = $row->{'count'};
                    $goalStat = array(
                        "goal" => $row->{'goalName'},
                        "count" => $count,
                        "proportion" => 0,
                    );
                    if($count > 0){
                        $goalStat['proportion'] = round(($count / $nbGames) * 100, 2);
                        $totalGoalsFinanced = $totalGoalsFinanced + $count;
                    }
                    array_push($goalStats, $goalStat);
                }

                $nbNoGoalFinanced = (3 * $nbGames) -$totalGoalsFinanced;

                array_push($goalStats, array(
                    "goal" => "Aucun",
                    "count" => $nbNoGoalFinanced,
                    "proportion" => round(($nbNoGoalFinanced / $nbGames) * 100, 2),
                ));
            
                return($goalStats);
            } catch(PDOExeception $e){
                return null;
            }
        }

        public static function getAwardStats($nbGames){
            try{
                $sql = "SELECT IFNULL(subquery2.nb, 0) AS count, awardName FROM
                    (SELECT awardId, awardName FROM Awards) as subquery
                LEFT JOIN
                    (SELECT COUNT(*) as nb, awardId FROM AwardFinanced GROUP BY awardId) as subquery2
                ON subquery.awardId = subquery2.awardId ORDER BY count DESC";
                $req = ConnectionModel::getPDO()->query($sql);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();

                $awardStats = array();
                $nbAwardsFinanced = 0;

                foreach($result as $row){
                    $count = $row->{'count'};
                    $awardStat = array(
                        "award" => $row->{'awardName'},
                        "count" => $count,
                        "proportion" => 0,
                    );
                    if($count > 0){
                        $awardStat['proportion'] = round(($count / $nbGames) * 100, 2);
                        $nbAwardsFinanced = $nbAwardsFinanced + $count;
                    }

                    array_push($awardStats, $awardStat);
                }

                $nbNoAwardFinanced = (3 * $nbGames) - $nbAwardsFinanced;
                
                array_push($awardStats, array(
                    "award" => "Aucune",
                    "count" => $nbNoAwardFinanced,
                    "proportion" => round(($nbNoAwardFinanced / $nbGames) * 100, 2),
                ));
            
            return($awardStats);
            } catch(PDOExeception $e){
                return null;
            }
        }

    }