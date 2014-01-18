<?php

require_once "Instruction.php";
require_once "DualInstruction.php";
require_once "PrintInstruction.php";
require_once "SetInstruction.php";
require_once "AddInstruction.php";
require_once "SubInstruction.php";
require_once "VariableOrLiteral.php";


class Interpreter
{

    /**
     * @var array Map of Line => Instruction
     */
    private $programMap = array();

    /**
     * @var array map of variables String => value.
     */
    private $variableMap = array();
    /**
     * Syntax is PROGRAM ::= <PROGRAM LINE> | <PROGRAM LINE> <EOL>
     *           PROGRAM LINE ::= <LINE> <INSTRUCTIONSPEC>
     *           <INSTRUCTIONSPEC> ::= <GOTO> <LINE> |
     *                                 <ADD> <VAR> <VARORLITERAL> |
     *                                 <SUB> <VAR> <VARORLITERAL> |
     *                                 <MUL> <VAR> <VARORLITERAL> |
     *                                 <DIV> <VAR> <VARORLITERAL> |
     *                                 <SET> <VAR> <VARORLITERAL>
     *                                 <PRINT> <VARORLITERAL> |
     *                                 <GOTOIF> <VAR> <LINE>
     *                                 <END>
     *
     * @param array $program as defined by the instruction.
     */
    public function interprete(array $program)
    {
         $this->fillMap($program);
         $programRunning = true;
         $instruction = reset($this->programMap);
         while($programRunning)
         {
             /**
              * @var $instruction Instruction
              */
             $nextLabel = $instruction->execute($this->variableMap);
             if ($nextLabel === null) {
                 $instruction = next($this->programMap);
             } else {
                 $instruction = $this->programMap[$nextLabel];
             }
             if ($instruction === false)
             {
                $programRunning = false;
             }
         }
        echo "Program has finished running.";
        return $this->variableMap;
    }

    /**
     * @param array $program
     */
    private function fillMap(array $program)
    {
        foreach($program as $programLine)
        {
            $tokens = explode(" ", $programLine);
            $line = $tokens[0];
            $opCode = $tokens[1];
            switch($opCode)
            {
                case 'PRINT':
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 2)));
                    $this->programMap[$line] = new PrintInstruction($variableOrliteral);
                    break;
                case 'SET':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new SetInstruction($variable, $variableOrliteral);
                    break;
                case 'ADD':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new AddInstruction($variable, $variableOrliteral);
                    break;
                case 'SUB':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new SubInstruction($variable, $variableOrliteral);
                    break;
            }
        }
    }
} 