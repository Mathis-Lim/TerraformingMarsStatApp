<?php

	class ConnectionModel{

		private static $pdo = NULL;

		public static function init(){
			$hostname = "192.168.56.1";
			$database_name = "TerraformingMars";
			$login = "root";
			$password = "Root1234";

			try {
  				self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			} catch (PDOException $e) {
  				if (Conf::getDebug()) {
    				echo $e->getMessage(); // affiche un message d'erreur
  				} else {
    				echo 'Une erreur est survenue';
  				}
  				die();
			}

			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		}

		public static function getPDO(){
			if(is_null(self::$pdo)){
				self::init();
			}
			return self::$pdo;
		}
	}

?>