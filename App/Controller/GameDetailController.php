<?php

    require_once File::build_path(array('Model', 'GameDetailModel.php'));
    require_once File::build_path(array('Model', 'PlayerModel.php'));
    require_once File::build_path(array('Model', 'CorporationModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

    class GameDetailController{

        public static function setGameDetails($gameId, $nbPlayer){

            $playerArray = PlayerModel::readAll();
            $corporationArray = CorporationMode::readAll();
            $controller = "GameDetail";
            $view = "create";
            $pageTitle = "Enregistrer une partie";
            require File::build_path(array('View', 'BaseView.php'));

        }


    }