<?php

    Class ErrorController{

        public static function url(){
            $errorMessage = "Une erreur est survenue lors de la navigation vers votre page";
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
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function linkGameToExtension(){
            $errorMessage = "Une erreur est survenue lors de la sélection des extensions pour la partie";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function setGameDetails(){
            $errorMessage = "Une erreur est survenue lors de l'enregistrement des détails de la partie";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getNumberOfGamesPlayed(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de parties jouées";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getNumberOfGenerationsPlayed(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de générations jouées";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getTotalPoints(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre total de points marqués";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAveragePoints(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de points marqués en moyenne";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAverageGenerationNumber(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre moyen de génération par parties";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getMostPlayed(){
            $errorMessage = "Une erreur est survenue lors de la récupération du joueur avec le plus de parties";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getLastCreatedGameId(){
            $errorMessage = "Une erreur est survenue lors de la récupération de la dernière partie créee";
            require File::build_path(array("View", "ErrorView.php"));
        }
        
        public static function getRecordWinner(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record de victoires";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getRecordPoints(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record de points totals";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getRecordChosenCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération des fréquences de choix des corporations";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getRecordWinsCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record de victoires - Corporations";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getRecordPointsCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record de points totals - Corporations";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getNbVictoryPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de victoires du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getFreqVictoryPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération de la fréquence de victoire du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getTotalPointsPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre total de points marqués du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAveragePointsPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de points marqués en moyenne par le joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getRecordChosenCorporationPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération des fréquences de choix des corporations du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getNbPlayedCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de parties jouées de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAvgGameTimeCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du temps moyen dd'une partie de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getNbVictoryCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de victoires de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getFreqVictoryCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération de la fréquence de victoire de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getTotalPointsCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération ddu nombre de points total de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAvgPointsCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du nombre de points moyens de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getChoiceFreqCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération de la fréquence de choix de la croporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getPointDetailPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des points du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getPointDetailCorporation(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des points de la corporation";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function setGoals(){
            $errorMessage = "Une erreur est survenue lors de l'enregistrement des objectifs";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function setAwards(){
            $errorMessage = "Une erreur est survenue lors de l'enregistrement des récompenses";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getGameTotalPointDetail(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des points";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getMostGenerations(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record du plus de générations en une partie";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getLeastGenerations(){
            $errorMessage = "Une erreur est survenue lors de la récupération du record du moins de générations en une partie";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getPositionDetailPlayer(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des positions du joueur";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getGoalStats(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des objectifs";
            require File::build_path(array("View", "ErrorView.php"));
        }

        public static function getAwardStats(){
            $errorMessage = "Une erreur est survenue lors de la récupération du détail des récompenses";
            require File::build_path(array("View", "ErrorView.php"));
        }

        

    }