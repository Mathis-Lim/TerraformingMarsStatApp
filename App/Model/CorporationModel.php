<?php
	require_once File::build_path(array('Model','ConnectionModel.php'));
    require_once File::build_path(array('Model','GenericModel.php'));

	class CorporationModel{

        private $corporationId;
        private $corporationName;

        public function getId(){
            return $this->corporationId;
        }

        public function getName(){
            return $this->corporationName;
        }
        
        public function __construct($id = NULL, $name = NULL){
            if(!is_null($id) && !is_null($name)){
                $this->corporationId = $id;
                $this->corporationName = $name;
            }
            elseif(!is_null($name)){
                $this->corporationName = $name;
            }
        }

        public function save(){
            $sql = "INSERT INTO Corporations(corporationName) VALUES (:corporation_name)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("corporation_name" => $this->corporationName,);

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function readAll(){
            return GenericModel::readAll('Corporation');
        }

        public static function getNameById($id){
            return GenericModel::getNameById('Corporation', $id);
        }

        public static function getCorporationById($id){
            return GenericModel::getById('Corporation', $id);
        }

        public function getNbGamesPlayed(){
            try{
                $sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE chosenCorporation = :corporation_id";
                $req = ConnectionModel::getPDO()->prepare($sql);
                $values = array("corporation_id" => $this->corporationId,);
                $req->execute($values);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();
                $nb = $result[0]->{'nb'};
                return $nb;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public function getAvgGameTime(){
            try{
                $sql = "SELECT ROUND(AVG(numberOfGenerations), 2) as avg FROM Games JOIN GameDetails ON 
                Games.gameId = GameDetails.gameId WHERE chosenCorporation=:corporation_id";
                $req = ConnectionModel::getPDO()->prepare($sql);
                $values = array("corporation_id" => $this->corporationId,);
                $req->execute($values);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();
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

        public function getNbPosition($rank){
            try{
                $sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE chosenCorporation=:corporation_id AND rank=:rank";
                $req_prep = ConnectionModel::getPDO()->prepare($sql);
                $values = array(
                    "corporation_id" => $this->corporationId,
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

        public function getTotalPoints(){
            try{
                $sql = "SELECT SUM(score) as nb FROM GameDetails WHERE chosenCorporation = :corporation_id";
                $req = ConnectionModel::getPDO()->prepare($sql);
                $values = array("corporation_id" => $this->corporationId,);
                $req->execute($values);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();
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

        public function getAvgPoints($totalPoints, $nbGames){
            if($nbGames <= 0){
                return 0;
            }
            $avg = $totalPoints / $nbGames;
            return round($avg, 2);
        }

        public function getChoiceFreq($nbGames){
            try{
                $sql = "SELECT COUNT(*) as nb FROM GameDetails WHERE rejectedCorporation = :corporation_id";
                $req = ConnectionModel::getPDO()->prepare($sql);
                $values = array("corporation_id" => $this->corporationId,);
                $req->execute($values);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $result = $req->fetchAll();
                $nbRejected = $result[0]->{'nb'};
    
                $totalDraw = $nbGames + $nbRejected;
                if($totalDraw <= 0){
                    $freqChoice = 0;
                }
                else{
                    $freqChoice = $nbGames / $totalDraw;
                }
    
                $choice = array(
                    "freq" => $freqChoice,
                    "total" => $totalDraw,
                );
    
                return $choice;
            } catch(PDOExeception $e){
                return null;
            }
        }

        public function getPointsDetail($total, $nbGames){
			try{
                $sql = "SELECT SUM(trScore) as tr, SUM(boardScore) as board, SUM(cardScore) as card, SUM(goalScore) as goal,
                SUM(awardScore) as award FROM GameDetails WHERE chosenCorporation=:corporation_id";
                $req_prep = ConnectionModel::getPDO()->prepare($sql);
                $values = array("corporation_id" => $this->corporationId,);
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
            } catch(PDOExeception $e){
                return null;
            }
		}
        

    }
?>