<?php
declare(strict_types=1);

namespace Dojo\Shop;

use ArrayIterator;
use Countable;
use DomainException;
use Iterator;
use IteratorAggregate;
use UnderflowException;

class Cart implements IteratorAggregate, Countable
{
    /** @var string */
    private $id;
    /** @var array */
    private $lines;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->lines = [];
    }

    public static function pickUp(): Cart
    {
        $id = md5(uniqid('cart.', true));

        return new static($id);
    }

    public static function pickUpWithProduct(
        ProductInterface $product,
        int $quantity
    ): Cart {
        $cart = static::pickUp();

        $cart->addCartLine(new CartLine($product, $quantity));

        return $cart;
    }

    public function checkout(): array
    {
        if ($this->isEmpty()) {
            throw new DomainException('Cart is empty. Can not checkout.');
        }

        return $this->lines;
    }

    public function drop()
    {
        $this->lines = [];
    }

    public function id(): string
    {
        return $this->id;
    }

    public function addProductInQuantity(
        ProductInterface $product,
        int $quantity
    ): void {
        $this->addCartLine(new CartLine($product, $quantity));
    }

    public function removeProduct(ProductInterface $product): void
    {
        if (isset($this->lines[$product->id()])) {
            throw new UnderflowException(
                sprintf('Product %s not in this cart', $product->id())
            );
        }

        unset($this->lines[$product->id()]);
    }

    public function changeProductQuantity(
        ProductInterface $product,
        int $newQuantity
    ) {
        $this->removeProduct($product);
        $this->addProductInQuantity($product, $newQuantity);
    }

    public function amount(): float
    {
        return array_reduce(
            $this->lines,
            function (
                float $accumulated,
                CartLine $line
            ) {
                $product = $line->product();
                $accumulated += $product->price() * $line->quantity();
                return $accumulated;
            },
            0
        );
    }

    public function totalProducts(): int
    {
        return array_reduce(
            $this->lines,
            function (
                int $accumulated,
                CartLine $line
            ) {
                $accumulated += $line->quantity();

                return $accumulated;
            },
            0
        );
    }

    public function isEmpty()
    {
        return 0 === $this->count();
    }

    public function count(): int
    {
        return \count($this->lines);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->lines);
    }

    private function addCartLine(Cartline $cartLine): void
    {
        $product = $cartLine->product();
        $this->lines[$product->id()] = $cartLine;
    }

    private function addAccumulatedCartLine(Cartline $cartLine): void
    {
        $product = $cartLine->product();
        if (! isset($this->lines[$product->id()])) {
            $this->lines[$product->id()] = $cartLine;

            return;
        }
        $newCartLine = new CartLine(
            $product,
            $cartLine->quantity() + $this->lines[$product->id()]->quantity()
        );

        $this->lines[$product->id()] = $newCartLine;
    }
}
