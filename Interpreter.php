<?php

require_once "Instruction.php";
require_once "DualInstruction.php";
require_once "PrintInstruction.php";
require_once "SetInstruction.php";
require_once "AddInstruction.php";
require_once "SubInstruction.php";
require_once "MulInstruction.php";
require_once "DivInstruction.php";
require_once "ModInstruction.php";
require_once "GotoInstruction.php";
require_once "GotoIfInstruction.php";
require_once "EndInstruction.php";
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
     *           <INSTRUCTIONSPEC> ::= <GOTO> <VARORLITERAL> |
     *                                 <ADD> <VAR> <VARORLITERAL> |
     *                                 <SUB> <VAR> <VARORLITERAL> |
     *                                 <MUL> <VAR> <VARORLITERAL> |
     *                                 <DIV> <VAR> <VARORLITERAL> |
     *                                 <MOD> <VAR> <VARORLITERAL> |
     *                                 <SET> <VAR> <VARORLITERAL>
     *                                 <PRINT> <VARORLITERAL> |
     *                                 <GOTOIF> <VAR> <VARORLITERAL> #goto if variable isn't null.
     *                                 <END>
     *
     * @param array $program as defined by the instruction.
     * @return array Array Map of all variables.
     */
    public function interprete(array $program)
    {
         $this->fillMap($program);
         $programRunning = true;
         $instruction = reset($this->programMap);
        try{

         while($programRunning)
         {
             /**
              * @var $instruction Instruction
              */
             $nextLabel = $instruction->execute($this->variableMap);
             if ($nextLabel === null) {
                 $instruction = next($this->programMap);
             } else {
                 reset($this->programMap);
                 do
                 {
                     list($label, $instruction) = each($this->programMap);
                 } while ($nextLabel != $label);
             }
             if ($instruction === false)
             {
                $programRunning = false;
             }
         }
        } catch (EndInstructionException $e)
        {
            //regular end of the instruction line.
        }
        echo "Program has finished running.";
        return $this->variableMap;
    }

    /**
     * @param array $program
     * @throws InvalidArgumentException
     * @return void
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
                case 'MUL':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new MulInstruction($variable, $variableOrliteral);
                    break;
                case 'DIV':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new DivInstruction($variable, $variableOrliteral);
                    break;
                case 'MOD':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new ModInstruction($variable, $variableOrliteral);
                    break;
                case 'GOTO':
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 2)));
                    $this->programMap[$line] = new GotoInstruction($variableOrliteral);
                    break;
                case 'GOTOIF':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $this->programMap[$line] = new GotoIfInstruction($variable, $variableOrliteral);
                    break;
                case 'END':
                    $this->programMap[$line] = new EndInstruction();
                    break;
                default:
                    throw new InvalidArgumentException('UNKNOWN OPCODE FOR ' . $programLine);
            }
        }
    }
} 