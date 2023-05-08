<?php
	require_once File::build_path(array('Model', 'GameModel.php'));

	class GameController{

        public static function home(){
            $someVar = "abcd";
            $controller = "Game";
            $view = "home";
            $pageTitle = "Accueil";
            require File::build_path(array('View', 'baseView.php'));
        }
    }