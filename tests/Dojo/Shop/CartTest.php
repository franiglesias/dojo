<?php
declare(strict_types=1);

namespace Dojo\Shop;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testShouldInstantiateAnEmptyCartIdentifiedWithAnId(): void
    {
        $cart = Cart::pickUp();

        $this->assertNotEmpty($cart->id());
        $this->assertEquals(0, $cart->totalProducts());
    }

    public function testShouldInstantiateCartWithAPreselectedProduct(): void
    {
        $product = $this->getProduct('product-1', 10);
        $cart = Cart::pickUpWithProduct($product, 1);

        $this->assertNotEmpty($cart->id());
        $this->assertEquals(1, $cart->totalProducts());
    }

    public function testShouldAddAProduct(): void
    {
        $product = $this->getProduct('product-1', 10);
        $cart = Cart::pickUp();

        $cart->addProductInQuantity($product, 1);
        $this->assertCount(1, $cart);
    }

    public function testShouldAddAProductInQuantity(): void
    {
        $product = $this->getProduct('product-1', 10);
        $cart = Cart::pickUp();

        $cart->addProductInQuantity($product, 10);
        $this->assertCount(1, $cart);
        $this->assertEquals(10, $cart->totalProducts());
    }

    public function testShouldAddSeveralProductsInQuantity(): void
    {
        $product1 = $this->getProduct('product-1', 10);
        $product2 = $this->getProduct('product-2', 15);
        $cart = Cart::pickUp();

        $cart->addProductInQuantity($product1, 5);
        $cart->addProductInQuantity($product2, 7);

        $this->assertCount(2, $cart);
        $this->assertEquals(12, $cart->totalProducts());
    }

    public function testShouldAddSameProductsInDifferentMoments(): void
    {
        $product1 = $this->getProduct('product-1', 10);
        $product2 = $this->getProduct('product-2', 15);

        $cart = Cart::pickUp();

        $cart->addProductInQuantity($product1, 5);
        $cart->addProductInQuantity($product2, 7);
        $cart->addProductInQuantity($product2, 3);

        $this->assertCount(2, $cart);
        $this->assertEquals(15, $cart->totalProducts());
    }

    public function testEmptyCartShouldHaveZeroAmount(): void
    {
        $cart = Cart::pickUp();

        $this->assertEquals(0, $cart->amount());
    }

    public function testShouldCalculateAmountWhenAddingProduct(): void
    {
        $cart = Cart::pickUp();

        $product = $this->getProduct('product-01', 10);
        $cart->addProductInQuantity($product, 1);

        $this->assertEquals(10, $cart->amount());
    }

    public function testShouldTakeCareOfQuantitiesToCalculateAmount(): void
    {
        $cart = Cart::pickUp();

        $product = $this->getProduct('product-01', 10);
        $cart->addProductInQuantity($product, 3);

        $this->assertEquals(30, $cart->amount());
    }

    public function testShouldTakeCareOfQuantitiesAndDifferentProductsToCalculateAmount(): void
    {
        $cart = Cart::pickUp();

        $product1 = $this->getProduct('product-01', 10);
        $product2 = $this->getProduct('product-02x', 7);

        $cart->addProductInQuantity($product1, 3);
        $cart->addProductInQuantity($product2, 4);

        $this->assertEquals(58, $cart->amount());
    }

    private function getProduct(
        $id,
        $price
    ): ProductInterface {
        /** @var ProductInterface | MockObject $product */
        $product = $this->createMock(ProductInterface::class);
        $product->method('id')->willReturn($id);
        $product->method('price')->willReturn($price);

        return $product;
    }
}
