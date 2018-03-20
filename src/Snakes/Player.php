<?php
declare(strict_types=1);

namespace Dojo\Snakes;

class Player
{
    private $positionToken = self::MIN_ROLL;
    private const MAX_ROLL = 6;
    private const MIN_ROLL = 1;
    /**
     * @var Dice
     */
    private $dice;

    /**
     * Game constructor.
     */
    public function __construct(Dice $dice)
    {
        $this->dice = $dice;
    }

    public function positionToken()
    {
        return $this->positionToken;
    }

    public function move($roll)
    {
        $this->positionToken += $roll;
    }

    public function roll()
    {
        $roll = $this->dice->roll();
        if ($roll > self::MAX_ROLL) {
            return self::MAX_ROLL;
        }
        return $roll < self::MIN_ROLL ? self::MIN_ROLL : $roll;
    }
}
