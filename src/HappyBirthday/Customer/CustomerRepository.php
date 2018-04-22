<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Customer;


use DateTimeInterface;

interface CustomerRepository
{
    public function findAllByBirthday(DateTimeInterface $birthday) : array;
}
