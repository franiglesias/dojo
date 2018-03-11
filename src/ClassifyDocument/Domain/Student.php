<?php

namespace Dojo\ClassifyDocument\Domain;

class Student
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $level;
    /**
     * @var string
     */
    private $stage;
    /**
     * @var string
     */
    private $group;

    public function __construct(string $id, string $name, string $level, string $stage, string $group)
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->stage = $stage;
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function Id() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function Name() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function Level() : string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function Stage() : string
    {
        return $this->stage;
    }

    /**
     * @return string
     */
    public function Group() : string
    {
        return $this->group;
    }
}