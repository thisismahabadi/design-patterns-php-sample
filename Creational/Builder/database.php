<?php

interface SQL
{
	public function select(string $table, array $fields);
	public function where(string $field, string $value, string $operator = '=');
	public function get();
}

class MySQL implements SQL
{
	private $con;
	private $query;

	public function __construct($host, $port, $username, $password, $database)
	{
		$this->con = new PDO("mysql:host=$host:$port;dbname=$database", $username, $password);
	}

	public function select(string $table, array $fields = ['*'])
	{
		$fields = implode(", ", $fields);
		$this->query = "select $fields from $table";
		return $this;
	}

	public function where(string $field, string $value, string $operator = '=')
	{
		$this->query .= " where $field $operator $value";
		return $this;
	}

	public function get()
	{
		$query = $this->con
			->prepare($this->query);
		$query->execute();
		return $query->fetchAll();
	}
}

function clientCode(SQL $sql)
{
	$query = $sql->select('users', ['id', 'name'])
		->where('id', 1)
		->get();

	return $query;
}

$db = clientCode(new MySQL('127.0.0.1', 3306, 'root', 'toor', 'lol'));

var_dump($db);
