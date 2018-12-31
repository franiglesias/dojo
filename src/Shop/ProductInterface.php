<?php
declare(strict_types=1);

namespace Dojo\Shop;

interface ProductInterface
{
    public function id(): string;

    public function price(): float;
}
