<?php


class SetInstruction extends DualInstruction
{
    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    public function execute(array &$variableMap)
    {
        $value = $this->variableOrLiteral->getValue($variableMap);
        $variableMap[$this->variable] = $value;
    }
}