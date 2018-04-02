<?php
declare(strict_types=1);

namespace Tests\Dojo\Snakes;

use Dojo\Snakes\Dice;
use Dojo\Snakes\Player;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @var Player
     */
    private $player;
    /**
     * @var Dice
     */
    private $dice;

    public function setUp()
    {
        $this->dice = $this->prophesize(Dice::class);
        $this->player = new Player($this->dice->reveal());
    }

    public function testPlayerShouldStartAtFirstSquare()
    {
        $this->assertEquals(1, $this->player->positionToken());
    }

    public function testMoveMovesPlayer()
    {
        $this->player->move(3);
        $this->assertEquals(4, $this->player->positionToken());
    }

    public function testMoveAgainMovesPlayerToAccumulatedPosition()
    {
        $this->player->move(3);
        $this->player->move(4);
        $this->assertEquals(8, $this->player->positionToken());
    }

    public function testPlayerRollsAMinimumOfOnePosition()
    {
        $this->dice->roll()->willReturn(-4);
        $roll = $this->player->roll();
        $this->assertEquals(1, $roll);
    }

    public function testPlayerRollsAMaximumOfSixPositions()
    {
        $this->dice->roll()->willReturn(10);
        $roll = $this->player->roll();
        $this->assertEquals(6, $roll);
    }

    public function testPlayerDoesNotMoveIfMoveIsFurtherThanEndOfBoard()
    {

    }
}
