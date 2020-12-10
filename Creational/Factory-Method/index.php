<?php

abstract class Database
{
	abstract public function connect();

	public function getDatabase()
	{
		$connection = $this->connect();
		$connection->logIn();
		return $connection->getDatabase();
	}
}

class Mysql extends Database
{
	private $host;
	private $port;
	private $username;
	private $password;
	private $database;

	public function __construct($host, $port, $username, $password, $database)
	{
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}

	public function connect()
	{
		return new MysqlConnector($this->host, $this->port, $this->username, $this->password, $this->database);
	}
}

interface DatabaseConnector
{
	public function logIn();
}

class MysqlConnector implements DatabaseConnector
{
	private $host;
	private $port;
	private $username;
	private $password;
	private $database;

	public function __construct($host, $port, $username, $password, $database)
	{
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}

	public function logIn()
	{
		try {
			$con = new PDO("mysql:host=$this->host:$this->port;dbname=$this->database", $this->username, $this->password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function getDatabase()
	{
		return $this->database;
	}
}

function clientCode(Database $database)
{
    return $database->getDatabase();
}

$db = clientCode(new Mysql('127.0.0.1', 3306, 'root', 'toor', 'lol'));

var_dump($db);
