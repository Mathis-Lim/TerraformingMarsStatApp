<?php
	require_once File::build_path(array('Model','ConnectionModel.php'));

	class GenericModel{

        public static function readAll($object){
            $sql = "SELECT * FROM :table";
            $req = ConnectionModel::getPDO()->prepare($sql);
            $values = array("table" => $object . "s",);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, $object . 'Model');
            $res = $req->fetchAll();
            return $res;
        }

    }