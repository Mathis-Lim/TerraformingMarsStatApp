<?php

    Class ErrorController{

        public function url(){
            $controller = "error";
            $errorMessage = "Une erreur est survenue lors de la navigation vers vautre page";
            require File::build_path(array("View", "ErrorView.php"));
        }

    }