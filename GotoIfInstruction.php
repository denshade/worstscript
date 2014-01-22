<?php


class GotoIfInstruction extends DualInstruction
{
    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    public function execute(array &$variableMap)
    {
        if ($variableMap[$this->variable] != 0)
        {
            return $this->variableOrLiteral->getValue($variableMap);
        }
        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "GOTOIF" . $this->variable . " " . $this->variableOrLiteral;
    }
}