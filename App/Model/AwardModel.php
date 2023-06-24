<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class AwardModel{

        private $awardId;
        private $awardName;

        public function getId(){
            return $this->awardId;
        }

        public function getName(){
            return $this->awardName;
        }

        public function __construct($id = NULL, $name = NULL){
            if(!is_null($id) && !is_null($name)){
                $this->awardId = $id;
                $this->awardName = $name;
            }
            elseif(!is_null($name)){
                $this->awardName = $name;
            }
        }

        public function save(){
            $sql = "INSERT INTO Awards(awardName) VALUES (:award_name)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("award_name" => $this->awardName,);

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function readAll(){
            $req = ConnectionModel::getPDO()->query("SELECT * FROM Awards");
            $req->setFetchMode(PDO::FETCH_CLASS, 'AwardModel');
            $res = $req->fetchAll();
            return $res;
        }

        public static function getByMapId($mapId){
            $sql ="SELECT * FROM Awards WHERE mapId = :map_id OR mapId = 4";
            $req = ConnectionModel::getPDO()->prepare($sql);
            $values = array("map_id" => $mapId,);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, 'AwardModel');
            $res = $req->fetchAll();
            return $res;
        }

    }