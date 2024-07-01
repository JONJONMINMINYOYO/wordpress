<?php
use PHPUnit\Framework\TestCase; 
class DiceTest extends TestCase
{
    protected Dice $dice;

    protected function setUp() :void{
        $this->dice = new Dice();
    }

    public function testInstanceOf() {
        $this->assertInstanceOf(Dice::class, $this->dice);
    }

    public function testEmpty(){
        $this->assertTrue(empty($this->dice->sided));
    }

    public function testSided(){
        $this->dice->setSided();
        $this->assertCount(6, $this->dice->getSided());
        $this->assertContains(1, $this->dice->getSided());
        $this->assertContains(2, $this->dice->getSided());
        $this->assertContains(3, $this->dice->getSided());
        $this->assertContains(4, $this->dice->getSided());
        $this->assertContains(5, $this->dice->getSided());
        $this->assertContains(6, $this->dice->getSided());

        return $this->dice;
    }

    /**
     * @depends testSided
     */
    public function testRoll($dice){
        $dice->roll();
        $this->assertTrue(1 <= $dice->getNumber() && 6 >= $dice->getNumber());
    }
}