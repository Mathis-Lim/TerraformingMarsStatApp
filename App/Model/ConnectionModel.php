<?php

	class ConnectionModel{

		private static $pdo = NULL;

		public static function init(){
			$hostname = "127.0.0.1";
			$port = "3306";
			$database_name = "TerraformingMars";
			$login = "root";
			$password = "Root1234";

			try {
				/*$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $database_name, $user, $pass);
				return $dbh
  				self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));*/
				  self::$pdo = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database_name, $login, $password);
			} catch (PDOException $e) {
    				echo 'Une erreur est survenue';
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