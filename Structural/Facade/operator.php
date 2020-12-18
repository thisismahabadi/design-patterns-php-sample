<?php

class Operator
{
	private $product;

	public function __construct()
	{
		$this->product = new Product;
	}

	public function action(array $productData, string $actionType)
	{
		$product = $this->product
			->create($productData['name'], $productData['color']);

		$warehouse = new Warehouse($product);

		switch ($actionType) {
			case 'buy':
				$warehouse->add();
				break;
			case 'sell':
				$warehouse->remove();
				break;

			default:
				break;
		}

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

	return $operator->action($productData, 'sell');

	// Uncomment this line to buy a product from operator
	// return $operator->action($productData, 'buy');
}

echo clientCode(new Operator);
