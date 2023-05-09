<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));

    class ExtensionModel{

        private $extensionId;
        private $extensionName;

        public function getId(){
            return $this->extensionId;
        }

        public function getName(){
            return $this->extensionName;
        }

        public function __construct($id = NULL, $name = NULL){
            if(!is_null($id) && !is_null($name)){
                $this->extensionId = $id;
                $this->extensionName = $extensionName;
            }
            elseif(!is_null($name)){
                $this->extensionName = $name;
            }
        }

        public function save(){
            $sql = "INSERT INTO Extensions(extensionName) VALUES (:extension_name)";
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("extension_name" => $this->extensionName,);

            try{
                $req_prep->execute($values);
                return true;
            } catch(PDOExeception $e){
                return false;
            }
        }

        public static function readAll(){
            $req = ConnectionModel::getPDO()->query("SELECT * FROM Extensions");
            $req->setFetchMode(PDO::FETCH_CLASS, 'ExtensionModel');
            $res = $req->fetchAll();
            return $res;
        }

        public static function getExtensionId($name){
            $sql = ConnectionModel::getPDO()->query("SELECT extensionId FROM Extensions WHERE extensionName=:extension_name");
            $req_prep = ConnectionModel::getPDO()->prepare($sql);
            $values = array("extension_name" = > $name));

            try{
                $req_prep->execute($values);
                $req_prep->setFetchMode(PDO::FETCH_OBJ);
                $result = $req_prep->fetchAll();
                $extensionId = $result[0]->extensionId;
                return $extensionId;
            }
            catch(PDOException $e){
                return -1;
            }
        }
        //associer à la vue et tout
    }