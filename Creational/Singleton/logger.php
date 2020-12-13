<?php

class BaseLogger
{
    protected function __construct() { }

	public static function getInstance()
	{
		return new static;
	}
}

class Logger extends BaseLogger
{
	private $date;
	private $datetime;

	protected function __construct()
	{
		$this->date = date('Y-m-d');
		$this->datetime = date('Y-m-d h:i:s');
	}

	public function write($value)
	{
		$this->file = fopen("$this->date.log", "a+");
		fwrite($this->file, "$this->datetime $value");
		fclose($this->file);
	}

	public static function log($value)
	{
		$logger = static::getInstance();
		$logger->write($value);
	}
}

$logger1 = Logger::log('Lorem ipsum');

$logger2 = Logger::getInstance();
$logger3 = Logger::getInstance();

if ($logger2 === $logger3) {
	echo 'Single instance';
} else {
	echo 'Different instances';
}
