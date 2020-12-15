<?php

abstract class EuropeVisa
{
	protected $visa;

    public function __construct(Visa $visa)
    {
        $this->visa = $visa;
    }

	abstract public function establishSchengen();
}

class GermanyVisa extends EuropeVisa
{
    public function __construct(Visa $visa)
    {
        parent::__construct($visa);
    }

	public function establishSchengen()
	{
		return $this->visa
			->generate([
				$this->visa->getName(),
				$this->visa->getFamily(),
				$this->visa->getPassportNumber(),
				$this->visa->getVisaType()
			]);
	}
}

class NetherlandsVisa extends EuropeVisa
{
    public function __construct(Visa $visa)
    {
        parent::__construct($visa);
    }

	public function establishSchengen()
	{
		return $this->visa
			->generate([
				$this->visa->getName(),
				$this->visa->getFamily(),
				$this->visa->getPassportNumber(),
				$this->visa->getVisaType()
			]);
	}
}

interface Visa
{
	public function getName();
	public function getFamily();
	public function getPassportNumber();
	public function getVisaType();
	public function generate(array $information);
}

class JobVisa implements Visa
{
	public function getName()
	{
		return 'Alex';
	}

	public function getFamily()
	{
		return 'Biden';
	}

	public function getPassportNumber()
	{
		return 'A10L32M';
	}

	public function getVisaType()
	{
		return 'Job';
	}

	public function generate(array $information)
	{
		return $information;
	}
}

class StudentVisa implements Visa
{
	public function getName()
	{
		return 'Mike';
	}

	public function getFamily()
	{
		return 'Jordan';
	}

	public function getPassportNumber()
	{
		return 'P034M1U';
	}

	public function getVisaType()
	{
		return 'Student';
	}

	public function generate(array $information)
	{
		return $information;
	}
}

function clientCode(EuropeVisa $europeVisa)
{
    return $europeVisa->establishSchengen();
}

$studentVisa = new StudentVisa;
$germanyVisa = new GermanyVisa($studentVisa);
print_r ( clientCode($germanyVisa) );

$jobVisa = new JobVisa;
$netherlandsVisa = new NetherlandsVisa($jobVisa);
print_r ( clientCode($netherlandsVisa) );
