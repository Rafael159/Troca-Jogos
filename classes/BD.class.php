<?php
	class BD{
		private static $conn;
		public function __construct(){}

		public function conn(){
			
			try{
				if(is_null(self::$conn)){					
					self::$conn = new PDO('mysql:host=localhost;dbname=trocajogos','root','');
					self::$conn->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
					self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);				
					self::$conn->exec("SET NAMES utf8"); 
					self::$conn->setAttribute("SET character_set='utf8'");				 
					self::$conn->setAttribute("SET collation_connection='utf8_general_ci'");				 
					self::$conn->setAttribute("SET character_set_connection='utf8'");				 
					self::$conn->setAttribute("SET character_set_client='utf8'");				 
					self::$conn->setAttribute("SET character_set_results='utf8'");
				}				
				return (self::$conn) ? self::$conn : false;

			}catch(PDOException $e){
				echo 'Houve um erro ao acessar o servidor. Tente novamente mais tarde';
				exit();
			}

		}
	}
?>