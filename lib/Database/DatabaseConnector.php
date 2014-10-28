<?php
	include_once(__DIR__ . "/../General/Settings.php");
	
	final class DatabaseConnector
	{
		public static function getConnection() 
		{
			return self::getInstance()->connection; 
		}
		
		public static function getLastError()
		{
			return self::getInstance()->connection->error;
		}
		
		public static function getLastInsertedID()
		{
			return self::getInstance()->connection->insert_id;
		}
		
		public static function isConnected()
		{
			return self::getInstance()->connection->ping();
		}
		
		private static function getInstance()
		{
			if (self::$instance == false) {
				self::$instance = new DatabaseConnector(dirname(__FILE__) . "/../../cfg/Database.xml");
				self::$instance->connect();
			}
			return self::$instance;
		}
	
		/*
		 * Wszystkie dane potrzebne do połączenia z bazą danych będzeimy wczytywać z pliku.
		 * Jest to uzasadanione rozwiązanie ponieważ, każdy u siebie lokalnie będzie mógł sobie zdefiniować
		 * ten plik.
		 */
		private function __construct($cfgPath) 
		{
			if (!file_exists($cfgPath)) {
				echo "Nie udało się odnaleźść pliku \"" . $cfgPath . "\".\n";
				return;
			}
			
			$xml = simplexml_load_file($cfgPath);
			
			$this->server   = $xml->Server;
			$this->user     = $xml->User;
			$this->password = $xml->Password;
			$this->database = $xml->Name;
		}
		
		private function connect()
		{
			$this->connection = new mysqli($this->server, $this->user, $this->password, $this->database);
			if ($this->connection->connect_errno) {
				echo "<b>Nie udało się połączyć z bazą danych MySQL: (" . $this->connection->connect_errno . ")</b>\n";
				if (Settings::getDebug() == 1) {
					echo "<br \> <br \>\n";
					echo $this->toString();
				}
				return;
			}
			
			$this->connection->query('SET NAMES \'utf8\'');
		}
		
		private function toString()
		{
			$str = "Server:   " . $this->server   . "<br \>" .
				   "User:     " . $this->user     . "<br \>" .
				   "Password: " . $this->password . "<br \>" .
			       "Database: " . $this->database . "<br \>"
				   ;
			
			return $str;
		}
	
		private $connection;
		private $server; 
		private $user; 
		private $password; 
		private $database;
		
		private static $instance = false;
	}
	
?>
