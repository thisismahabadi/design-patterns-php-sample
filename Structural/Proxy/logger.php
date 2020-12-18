<?php

interface Logger
{
	public function log($value);
}

class File implements Logger
{
	public function log($value)
	{
		$date = date('Y-m-d');
		$datetime = date('Y-m-d h:i:s');
		$file = fopen("$date.log", "a+");
		fwrite($file, "$datetime $value");
		fclose($file);
	}
}

class Proxy implements Logger
{
	private $file;

	public function __construct(File $file)
	{
		$this->file = $file;
	}

	public function log($value)
	{
		return $this->file
			->log($value);
	}
}

function clientCode(Logger $logger, $value)
{
	return $logger->log($value);
}

$file = new File;
clientCode($file, 'Lorem ipsum');

$proxy = new Proxy($file);
clientCode($proxy, 'Lorem ipsum');
