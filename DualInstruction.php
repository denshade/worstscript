<?php


abstract class DualInstruction implements Instruction
{
    /**
     * @var VariableOrLiteral
     */
    protected $variableOrLiteral;
    /**
     * @var string
     */
    protected $variable;

    public function __construct($variable, VariableOrLiteral $variableOrLiteral)
    {
        $this->variable = $variable;
        $this->variableOrLiteral = $variableOrLiteral;
    }


    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    abstract public function execute(array &$variableMap);
}