<?php

class Company
{
	private $name;
	private $owner;

	public function __construct($name, Owner $owner)
	{
		$this->name = $name;
		$this->owner = $owner;
		$this->owner->addProperty($this);
	}

	public function __clone()
	{
		$this->name = "Clone version - $this->name";
		$this->owner->addProperty($this);
	}
}

class Owner
{
	private $name;
	private $properties;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function addProperty(Company $property)
	{
		$this->properties[] = $property;
	}
}

function clientCode()
{
    $owner = new Owner("Moe Mah");
    $company = new Company("Comp", $owner);

    $anotherCompany = clone $company;

    return $anotherCompany;
}

$anotherCompany = clientCode();

var_dump($anotherCompany);
