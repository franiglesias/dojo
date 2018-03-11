<?php
namespace Dojo\ClassifyDocument\Domain;


interface StudentRepository
{
    public function byId(string $id): Student;
}