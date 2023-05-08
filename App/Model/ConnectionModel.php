<?php

	class ConnectionModel{

		private static $pdo = NULL;

		public static function init(){
			$hostname = "127.0.0.1";
			$port = "3306";
			$database_name = "TerraformingMars";
			$username = "root";
			$password = "Root1234";

			try {
				  self::$pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$database_name", $username, $password);
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