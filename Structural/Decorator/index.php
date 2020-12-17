<?php

interface Book
{
	public function getFirstPublishRelease(int $year);
}

class Fantasy implements Book
{
	public function getFirstPublishRelease(int $year)
	{
		return $year;
	}
}

class Novel implements Book
{
	private $book;

	public function __construct(Book $book)
	{
		$this->book = $book;
	}

	public function getFirstPublishRelease(int $year)
	{
		return $this->book->getFirstPublishRelease($year);
	}
}

class HarryPotter extends Novel
{
	public function getFirstPublishRelease(int $year)
	{
		$year = parent::getFirstPublishRelease($year);
		return "Harry was released on $year";
	}
}

class Dune extends Novel
{
	public function getFirstPublishRelease(int $year)
	{
		$year = parent::getFirstPublishRelease($year);
		return strrev("Dune was released on $year");
	}
}

function publishBook(Book $book, int $year)
{
    return $book->getFirstPublishRelease($year);
}

$fantasy = new Fantasy;

$harryPotter = new HarryPotter($fantasy);
echo publishBook($harryPotter, 2001);

echo "\n";

$dune = new Dune($fantasy);
echo publishBook($dune, 1984);
