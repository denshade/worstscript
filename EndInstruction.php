<?php

class EndInstructionException extends Exception
{}

class EndInstruction implements Instruction {

    /**
     * @param array $variableMap Parameter map.
     * @return integer The next line to go to or null if next line.
     */
    public function execute(array &$variableMap)
    {
        throw new EndInstructionException();
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return "END";
    }
}