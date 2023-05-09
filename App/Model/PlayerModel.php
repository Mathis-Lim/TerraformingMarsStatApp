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

    }

