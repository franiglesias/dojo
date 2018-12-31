<?php
declare(strict_types=1);

namespace Dojo\Shop;

class Product implements ProductInterface
{
    /** @var string */
    private $id;
    /** @var float */
    private $price;

    public function __construct(string $id, float $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function price(): float
    {
        return $this->price;
    }
}
