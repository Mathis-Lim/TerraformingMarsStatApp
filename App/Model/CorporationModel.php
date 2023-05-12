<?php
	require_once File::build_path(array('Model','ConnectionModel.php'));

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
            $req = ConnectionModel::getPDO()->query("SELECT * FROM Corporations");
            $req->setFetchMode(PDO::FETCH_CLASS, 'CorporationModel');
            $res = $req->fetchAll();
            return $res;
        }

        public static function getCorporationById($id){
            $sql = "SELECT * FROM Corporations WHERE corporationId = :corporation_id";
            $req = ConnectionModel::getPDO()->prepare($sql);
            $values = array("corporation_id" => $id,);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, 'CorporationModel');
            $res = $req->fetchAll();
            $corporation = $res[0];
            return $corporation;
        }

    }
?>