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
            $id = $result[0]->gameId;
            return $id;
        }

        public function linkToExtension($extensionId){
            echo("extid:" . $extensionId);
            echo("gameid:" . $this->gameId);
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

    }