<?php


class PrintInstruction implements Instruction
{
    /**
     * @var VariableOrLiteral
     */
    private $variableOrLiteral;

    /**
     * @param VariableOrLiteral $variableOrLiteral
     */
    public function __construct(VariableOrLiteral $variableOrLiteral)
    {
        $this->variableOrLiteral = $variableOrLiteral;
    }

    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    public function execute(array &$variableMap)
    {
        echo $this->variableOrLiteral->getValue($variableMap)."\n";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "PRINT " . $this->variableOrLiteral;
    }

}