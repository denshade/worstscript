<?php


class GotoInstruction implements Instruction
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
        return $this->variableOrLiteral->getValue($variableMap);
    }
}