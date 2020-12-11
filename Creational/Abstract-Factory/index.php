<?php

interface PlayerFactory
{
	public function getFile(string $fileName);
	public function processFile(File $file);
	public function player(Process $process);
}

class AudioFactory implements PlayerFactory
{
	public function getFile(string $fileName)
	{
		return new AudioFile($fileName);
	}

	public function processFile(File $file)
	{
		return new AudioProcess($file);
	}

	public function player(Process $process)
	{
		return new AudioPlayer($process);
	}
}

interface File
{
	public function getFile();
}

class AudioFile implements File
{
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

	public function getFile()
	{
		return $this->fileName;
	}
}

interface Process
{
	public function processFile();
}

class AudioProcess implements Process
{
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

	public function processFile()
	{
		return "Music file " . $this->file->getFile() . " has been received";
	}
}

interface Player
{
	public function play();
}

class AudioPlayer implements Player
{
    private $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

	public function play()
	{
		return $this->process->processFile() . " and now is playing.";
	}
}

class Media
{
	private $fileName;

	public function __construct($fileName)
	{
		$this->fileName = $fileName;
	}

	public function play(PlayerFactory $playerFactory)
	{
		$file = $playerFactory->getFile($this->fileName);
		$process = $playerFactory->processFile($file);
		$player = $playerFactory->player($process);
		return $player->play();
	}
}

$media = new Media('php.mp3');
$result = $media->play(new AudioFactory);

var_dump($result);
