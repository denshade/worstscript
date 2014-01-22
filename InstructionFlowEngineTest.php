<?php

require_once "InstructionFlowEngine.php";

class InstructionFlowEngineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getNextInstruction()
    {

        $instructionFlowEngine = new InstructionFlowEngine(array('A' => 'I1', 'B' => 'I2', 'C' => 'I3'));
        $this->assertEquals('I1', $instructionFlowEngine->getCurrentInstruction());
        $instructionFlowEngine->setNext();
        $this->assertEquals('I2', $instructionFlowEngine->getCurrentInstruction());
        $instructionFlowEngine->setNext();
        $this->assertEquals('I3', $instructionFlowEngine->getCurrentInstruction());
        $instructionFlowEngine->setNext();
        $this->assertNull($instructionFlowEngine->getCurrentInstruction());

        $instructionFlowEngine->setNextLocation('A');
        $this->assertEquals('I1', $instructionFlowEngine->getCurrentInstruction());
    }
}
 