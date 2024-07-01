<?php
use PHPUnit\Framework\TestCase;

class Test123 extends TestCase
{
    protected array $sided;
    protected int $number;

    public function __construct (){
    }

    public function setSided() :void{
        $this->sided = [1,2,3,4,5,6];
    }

    public function getSided() :array{
        return $this->sided;
    }

    public function roll() :void{
        $this->number = $this->sided[array_rand($this->sided)];
    }

    public function getNumber() :int{
        return $this->number;
    }
    public function testHoge1()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
    }

  
      
     
}
