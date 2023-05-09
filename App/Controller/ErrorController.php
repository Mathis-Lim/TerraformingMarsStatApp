<?php

    Class ErrorController{

        public static function url(){
            $errorMessage = "Une erreur est survenue lors de la navigation vers vautre page";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function retrieveFormData(){
            $errorMessage = "Une erreur est survenue lors de la récupération des données du formulaire";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function createCorporation(){
            $errorMessage = "Une erreur est survenue lors de la création de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function readAllCorporations(){
            $errorMessage = "Une erreur est survenue lors de l'affichage des corporations";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function createPlayer(){
            $errorMessage = "Une erreur est survenue lors de la création du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function readAllPlayers(){
            $errorMessage = "Une erreur est survenue lors de l'affichage des joueurs";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function createGame(){
            $errorMessage = "Une erreur est survenue lors de la création de la partie";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function createExtension(){
            $errorMessage = "Une erreur est survenue lors de la création de l'extension";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function readAllExtensions(){
            $errorMessage = "Une erreur est survenue lors de l'affichage des extensions";
            require File::buildpath(array("View"; "ErrorView.php"));
        }

    }