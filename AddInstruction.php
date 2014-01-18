<?php


class AddInstruction extends DualInstruction
{

    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    public function execute(array &$variableMap)
    {
        $value = $this->variableOrLiteral->getValue($variableMap);
        if (is_numeric($variableMap[$this->variable]) && is_numeric($value)) {
            $variableMap[$this->variable] += $value;
        } else {
            $variableMap[$this->variable] .= $value;
        }
    }
}