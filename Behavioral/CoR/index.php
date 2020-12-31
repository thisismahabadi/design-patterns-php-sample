<?php

abstract class Transfer
{
	private $condition;

	public function addCondition(Transfer $condition)
	{
		$this->condition = $condition;

		return $condition;
	}

	public function confirm($fromCard, $cardPassword)
	{
        if (!$this->condition) {
            return true;
        }

        return $this->condition->confirm($fromCard, $cardPassword);
	}
}

class Authentication extends Transfer
{
	private $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function confirm($fromCard, $cardPassword)
	{
		if (isset($this->client->card[$fromCard])) {
			if ($this->client->card[$fromCard]['pass'] === $cardPassword) {
				echo 1;
        		return parent::confirm($fromCard, $cardPassword);
				// return true;
			}
		}

		echo 4;
		return false;
	}
}

class CheckBalance extends Transfer
{
	private $amount;

	public function __construct($amount)
	{
		$this->amount = $amount;
	}

	public function confirm($fromCard, $cardPassword)
	{
		echo 2;
		print_r($this->condition);
		return parent::confirm($fromCard, $cardPassword);
		// return true;
	}
}

class CardExists extends Transfer
{
	private $fromCard;

	public function __construct($fromCard)
	{
		$this->fromCard = $fromCard;
	}

	public function confirm($fromCard, $cardPassword)
	{
		echo 3;
		return parent::confirm($fromCard, $cardPassword);
		// return true;
	}
}

class Client
{
	public $card = [];
	private $transfer;

	public function addCard($fromCard, $cardPassword, $amount)
	{
		$this->card[$fromCard]['pass'] = $cardPassword;
		$this->card[$fromCard]['amount'] = $amount;
	}

	public function setProperties(Transfer $transfer)
	{
		$this->transfer = $transfer;
	}

	public function check($fromCard, $cardPassword)
	{
		$this->transfer->confirm($fromCard, $cardPassword);
	}
}

function transfer($fromCard, $cardPassword, $amount, $toCard)
{
	$client = new Client;
	$client->addCard($fromCard, $cardPassword, 100);

	$c2c = new Authentication($client);
	$c2c->addCondition(new CheckBalance($amount))
		->addCondition(new CardExists($toCard));

	$client->setProperties($c2c);
	$client->check($fromCard, $cardPassword);
}

print_r( transfer(5022, 123, 50, 5023) );
