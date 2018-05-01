<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Customer;

class Customer
{
    /** @var string */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function email() : string
    {
        return $this->email;
    }
}
