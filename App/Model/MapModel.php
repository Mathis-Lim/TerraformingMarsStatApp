<?php

	require_once File::build_path(array('Model','ConnectionModel.php'));
    require_once File::build_path(array('Model','GenericModel.php'));

    class MapModel{

        $private mapId;
        $private $mapName;

        public function getId(){
            return $this->mapId;
        }

        public function getName(){
            return $this->mapName;
        }

        public function __construct($id = NULL, $name = NULL){
            if((!is_null($id)) && (!is_null($name))){
                $this->mapId = $id;
                $this->mapName = $name;
            }

            elseif(!is_null($id)){
                $this->mapId = $id;
            }
        }

        public static function readAll(){

        }

    }