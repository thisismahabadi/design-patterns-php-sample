<?php

interface Messenger
{
	public function send(string $message);
}

class TwilioApi
{
	private $accountSID;
	private $authToken;
	private $number;

	public function __construct($accountSID, $authToken, $number)
	{
		$this->accountSID = $accountSID;
		$this->authToken = $authToken;
		$this->number = $number;
	}

	public function login()
	{
		$this->client = new \Twilio\Rest\Client($this->accountSID, $this->authToken);
		return $this;
	}

	public function send($receiver, $message)
	{
		return $this->client
			->messages
			->create($receiver, [
			    'from' => $this->number,
			    'body' => $message
			]);
	}
}

class SMS implements Messenger
{
	private $twilio;
	private $receiver;

	public function __construct(TwilioApi $twilio, $receiver)
	{
		$this->twilio = $twilio;
		$this->receiver = $receiver;
	}

	public function send(string $message)
	{
		return $this->twilio
			->login()
			->send($receiver, $message);
	}
}

class Mail implements Messenger
{
	private $receiver;
	private $title;

	public function __construct($receiver, $title)
	{
		$this->receiver = $receiver;
		$this->title = $title;
	}

	public function send(string $message)
	{
		return mail($this->receiver, $this->title, $message);
	}
}

function clientCode(Messenger $messenger)
{
    return $messenger->send('Hi');
}

// Uncomment these lines if you want to test Twilio api, imagine to install its dependency
// $twilio  = new TwilioApi(123, 'abc', 456);
// $sms  = new SMS($twilio, 535125);
// clientCode($sms);

$mail = new Mail('thisismahabadi@gmail.com', 'PHP - Adapter Pattern');
clientCode($mail);
