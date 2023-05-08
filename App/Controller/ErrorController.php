<?php

    Class ErrorController{

        public static function url(){
            $errorMessage = "Une erreur est survenue lors de la navigation vers vautre page";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function corporationCreation(){
            $errorMessage = "Une erreur est survenue lors de la création de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function readAllCorporation(){
            $errorMessage = "Une erreur est survenue lors de l'affichage des corporations";
            require File::build_path(array("View", "ErrorView.php"));
        }

    }