<?php

interface Product
{
	public function getCount();
	public function setCount($count);
	public function addContent(Product $product);
	public function removeContent(Product $product);
}

class Box implements Product
{
	private $count;

	public function getCount()
	{
		return $this->count;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function addContent(Product $product)
	{
		$this->setCount($product->getCount() + $this->getCount());
	}

	public function removeContent(Product $product)
	{
		$this->setCount($this->getCount() - $product->getCount());
	}

}

class MiniBox implements Product
{
	private $count;

	public function getCount()
	{
		return $this->count;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function addContent(Product $product)
	{
		$this->setCount($product->getCount() + $this->getCount());
	}

	public function removeContent(Product $product)
	{
		$this->setCount($this->getCount() - $product->getCount());
	}
}

class Tool implements Product
{
	public function getCount()
	{
		return 1;
	}

	public function setCount($count)
	{
		return 1;
	}

	public function addContent(Product $product)
	{
		return false;
	}

	public function removeContent(Product $product)
	{
		return false;
	}
}

$tool = new Tool;
echo $tool->getCount();

echo "\n";

$miniBox = new MiniBox;
$miniBox->addContent($tool);
$miniBox->addContent($tool);
echo $miniBox->getCount();

echo "\n";

$box = new Box;
$box->addContent($miniBox);
echo $box->getCount();

echo "\n";

$miniBox->removeContent($tool);
echo $miniBox->getCount();
