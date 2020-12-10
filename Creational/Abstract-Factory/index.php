<?php

interface PlayerFactory
{
	public function getFile();
	public function processFile();
	public function play();
}

class AudioFactory implements PlayerFactory
{
	public function getFile()
	{
		return new AudioFile;
	}

	public function processFile()
	{
		return new AudioProcess;
	}

	public function play()
	{
		return new AudioPlayer;
	}
}

interface File
{
	public function getFile();
}

class AudioFile implements File
{
	public function getFile()
	{
		echo 'Get File';
	}
}

interface Process
{
	public function processFile();
}

class AudioProcess implements Process
{
	public function processFile()
	{
		echo 'Process File';
	}
}

interface Player
{
	public function play();
}

class AudioPlayer implements Player
{
	public function play()
	{
		echo 'Play';
	}
}

class Media
{
	private $fileName;
	private $fileFormat;

	public function __construct($fileName, $fileFormat)
	{
		$this->fileName = $fileName;
		$this->fileFormat = $fileFormat;
	}

	public function play(PlayerFactory $playerFactory)
	{
		$playerFactory->getFile($this->fileName);
		$playerFactory->processFile($this->fileFormat);
		return $playerFactory->play();
	}
}

$media = new Media('php', 'mp3');
$result = $media->play(new AudioFactory);

var_dump($result);
// echo $result;
