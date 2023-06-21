<?php
	require_once File::build_path(array('Model','ConnectionModel.php'));

	class GenericModel{

        public static function readAll($object){
            $model = $object . 'Model';

            $sql = "SELECT * FROM " . $object . "s";
            $req = ConnectionModel::getPDO()->query($sql);
            $values = array("table" => $object . "s",);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, $model);
            $res = $req->fetchAll();

            return $res;
        }

    }