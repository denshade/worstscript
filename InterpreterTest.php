<?php

require_once "Interpreter.php";


class InterpreterTest extends PHPUnit_Framework_TestCase
{

    public function testPrint()
    {
        $interpreter = new Interpreter();
        $interpreter->interprete(array('10 PRINT "HELLO WORLD"'));
    }
    public function testSet()
    {
        $interpreter = new Interpreter();
        $map = $interpreter->interprete(array('10 SET TEST "HELLO WORLD"'));
        $this->assertEquals('HELLO WORLD', $map['TEST']);
    }
    public function testAdd()
    {
        $interpreter = new Interpreter();
        $map = $interpreter->interprete(array('10 SET A "1"', '20 ADD A "1"'));
        $this->assertEquals('2', $map['A']);
    }

    public function testAddStrings()
    {
        $interpreter = new Interpreter();
        $map = $interpreter->interprete(array('10 SET A "H"', '20 ADD A "ELLO"'));
        $this->assertEquals('HELLO', $map['A']);
    }

    public function testSub()
    {
        $interpreter = new Interpreter();
        $map = $interpreter->interprete(array('10 SET A "1"', '20 SUB A "1"'));
        $this->assertEquals('0', $map['A']);
    }

    public function testMul()
    {
        $interpreter = new Interpreter();
        $map = $interpreter->interprete(array('10 SET A "1"', '20 SUB A "1"'));
        $this->assertEquals('0', $map['A']);
    }

}
 