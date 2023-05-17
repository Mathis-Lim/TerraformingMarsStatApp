<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class GoalModel{

        private $goalId;
        private $goalName;

        public function getId(){
            return $this->goalId;
        }

        public function getName(){
            return $this->goalName;
        }

        public function __construct($id = NULL, $name = NULL){
            if(!is_null($id) && !is_null($name)){
                $this->goalId = $id;
                $this->goalName = $name;
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

    }