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

        public static function getById($object, $id){
            $model = $object . 'Model';
            $idAttribute = strtolower($object) . "Id";

            $sql = "SELECT * FROM " . $object . "s WHERE " . $idAttribute . " = " . $id;
            $req = ConnectionModel::getPDO()->query($sql);
            $values = array("table" => $object . "s",);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_CLASS, $model);
            $res = $req->fetchAll();

            return $res[0];
        }

        public static function getNameById($object, $id){
            $model = $object . 'Model';
            $idAttribute = strtolower($object) . "Id";
            $nameAttribute = strtolower($object) . "Name";

            $sql = "SELECT " . $nameAttribute . " FROM " . $object . "s WHERE " . $idAttribute . " = " . $id;
            $req = ConnectionModel::getPDO()->query($sql);
            $values = array("table" => $object . "s",);
            $req->execute($values);
            $req->setFetchMode(PDO::FETCH_OBJ);
            $res = $req->fetchAll();

            return $res[0]->{$nameAttribute};
        }

    }