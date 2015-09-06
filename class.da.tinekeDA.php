<?php
class tinekeDA
{
	public $conn;

	function __construct() {
		$host   = "mysqlhost";
		$db 	= "popupKariboeni";
		$user   = "kariboeni";
		$pass   = "popup";

		try {
			$this->conn = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
		}
		catch(PDOException $pe){
			die('Connection error:: '.$pe->getMessage());
		}
	}

	public function query($query) {
		$r = $this->conn->query($query) or die("failed!");
		if(!$r){
			die("Query error: ".$conn->errorInfo());
		}
		return $r;
	}

	public function execute($query) {
		$r = $this->conn->exec($query);
		return $r;
	}
} // end class
?>