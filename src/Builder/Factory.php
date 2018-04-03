<?php
declare(strict_types=1);

namespace Dojo\Builder;

use InvalidArgumentException;

interface Relation
{
    public function data(): array;
}

class Customer implements Relation
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function data(): array
    {
        return $this->data;
    }
}

class Provider implements Relation
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function data(): array
    {
        return $this->data;
    }
}

class RelationFactory
{
    public function create($type, array $someData) : Relation
    {
        switch ($type) {
            case 'customer':
                return new Customer($someData);
            case 'provider':
                return new Provider($someData);
            default:
                throw new InvalidArgumentException('Unsupported type');
        }
    }
}
