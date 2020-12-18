<?php

class Operator
{
	private $product;

	public function __construct()
	{
		$this->product = new Product;
	}

	public function sell(array $productData)
	{
		$product = $this->product
			->create($productData['name'], $productData['color']);

		$warehouse = new Warehouse($product);
		$warehouse->remove();

		return $warehouse->get($product->getId());
	}

	public function buy(array $productData)
	{
		$product = $this->product
			->create($productData['name'], $productData['color']);

		$warehouse = new Warehouse($product);
		$warehouse->add();

		return $warehouse->get($product->getId());
	}
}

class Warehouse
{
	private $product;
	private $inventory;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	public function remove()
	{
		unset($this->inventory[$this->product->getId()]);
	}

	public function add()
	{
		$this->inventory[$this->product->getId()] = $this->product;
	}

	public function get(int $id)
	{
		if (isset($this->inventory[$id])) {
			if (array_key_exists($id, $this->inventory)) {
				return 'Product has added to inventory.';
			}
		}

		return 'Product has removed from inventory.';
	}
}

class Product
{
	private $id;
	private $name;
	private $color;

	public function getId()
	{
		return $this->id;
	}

	public function setId(int $id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function getColor()
	{
		return $this->color;
	}

	public function setColor(string $color)
	{
		$this->color = $color;
	}

	public function create(string $name, string $color)
	{
		$product = new Product;
		$product->setId(rand());
		$product->setName($name);
		$product->setColor($color);
		return $product;
	}
}

function clientCode(Operator $operator)
{
	$productData = ['name' => 'Monitor', 'color' => 'Black'];

	return $operator->sell($productData);

	// Uncomment this line to buy a product from operator
	// return $operator->buy($productData);
}

echo clientCode(new Operator);
