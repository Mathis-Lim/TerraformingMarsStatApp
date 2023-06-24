<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class GoalModel{

        private $goalId;
        private $goalName;
        private $mapId;

        public function getId(){
            return $this->goalId;
        }

        public function getName(){
            return $this->goalName;
        }

        public function __construct($id = NULL, $name = NULL, $mapId = NULL){
            if(!is_null($id) && !is_null($name) && !is_null($mapId)){
                $this->goalId = $id;
                $this->goalName = $name;
                $this->mapId = $mapId;
            }
            elseif(!is_null($name)){
                $this->goalName = $name;
            }
        }

        public function save(){
            $sql = "INSERT INTO Goals(goalName) VALUES (:goal_name)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("goal_name" => $this->goalName,);

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function readAll(){
            $req = ConnectionModel::getPDO()->query("SELECT * FROM Goals");
            $req->setFetchMode(PDO::FETCH_CLASS, 'GoalModel');
            $res = $req->fetchAll();
            return $res;
        }

        public static function getByMapId($mapId){
            $sql ="SELECT * FROM Goals WHERE mapId = :map_id OR mapId = 4";
            $req = ConnectionModel::getPDO()->prepare($sql);
            $values = array("map_id" => $mapId,);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, 'GoalModel');
            $res = $req->fetchAll();
            return $res;
        }

    }