<?php
	require_once File::build_path(array('Model', 'CorporationModel.php'));
    require_once File::build_path(array('Controller', 'ErrorController.php'));

	class CorporationController{

        public static function readAll(){
            $corporationArray = CorporationModel::readAll();
            if(!isset($corporationArray)){
                ErrorController::readAllCorporations();
                exit;
            }
            else{
                if(isset($_GET['creation'])){
                    $creation = true;
                }
                $controller = "Corporation";
                $view = "list";
                $pageTitle = "Corporations";
            }
            require File::build_path(array('View', 'BaseView.php'));
        }

        public static function create(){
            $controller = "Corporation";
            $view = "create";
            require File::build_path(array("View", "BaseView.php"));
        }


        public static function created(){

            if(isset($_GET['corporation_name'])){
                $corporationName = $_GET['corporation_name'];
            }
            else{
                ErrorController::retrieveFormData();
                exit;
            }
            
            $corpo = new CorporationModel(NULL, $corporationName);
            $success = $corpo->save();
            
            if($success == true){
                header('Location: index.php?controller=corporation&action=readAll&creation=true');
                exit;
            }
            else{
                ErrorController::createCorporation();
                exit;
            }
        }   

        public static function read(){
            if(!isset($_GET['corporation_id'])){
                ErrorController::url();
                exit;
            }
            $corporationId = $_GET['corporation_id'];
            $corporation = CorporationModel::getCorporationById($corporationId);

            $nbPlayed = $corporation->getNbGamesPlayed();
            if(!isset($nbPlayed)){
                ErrorController::getNbPlayedCorporation();
                exit;
            }

            $avgGameTime = $corporation->getAvgGameTime();
            if(!isset($avgGameTime)){
                ErrorController::getAvgGameTimeCorporation();
                exit;
            }

            $nbVictories = $corporation->getNbPosition(1);
            if(!isset($nbVictories)){
                ErrorController::getNbVictoryCorporation();
                exit;
            }

            $freqVictory = $corporation->getFreqPosition($nbVictories, $nbPlayed);
            if(!isset($freqVictory)){
                ErrorController::getFreqVictoryCorporation();
                exit;
            }

            $totalPoints = $corporation->getTotalPoints();
            if(!isset($totalPoints)){
                ErrorController::getTotalPointsCorporation();
                exit;
            }

            $avgPoints = $corporation->getAvgPoints($totalPoints, $nbPlayed);
            if(!isset($avgPoints)){
                ErrorController::getAvgPointsCorporation();
                exit;
            }

            $choice = $corporation->getChoiceFreq($nbPlayed);
            $freqChoice = $choice['freq'];
            $totalDistributed = $choice['total'];
            if(!isset($choice)){
                ErrorController::getChoiceFreqCorporation();
                exit;
            }

            $controller = "Corporation";
            $view = "detail";
            $pageTitle = $corporation->getName();
            require File::build_path(array("View", "BaseView.php"));
        }

}











