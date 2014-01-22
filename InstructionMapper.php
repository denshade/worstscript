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

class InstructionMapper
{
    /**
     * @param array $program
     * @throws InvalidArgumentException
     * @return array Map of <line:int> <instruction:Instruction>
     */
    public function fillMap(array $program)
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
                    $programMap[$line] = new PrintInstruction($variableOrliteral);
                    break;
                case 'SET':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new SetInstruction($variable, $variableOrliteral);
                    break;
                case 'ADD':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new AddInstruction($variable, $variableOrliteral);
                    break;
                case 'SUB':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new SubInstruction($variable, $variableOrliteral);
                    break;
                case 'MUL':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new MulInstruction($variable, $variableOrliteral);
                    break;
                case 'DIV':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new DivInstruction($variable, $variableOrliteral);
                    break;
                case 'MOD':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new ModInstruction($variable, $variableOrliteral);
                    break;
                case 'GOTO':
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 2)));
                    $programMap[$line] = new GotoInstruction($variableOrliteral);
                    break;
                case 'GOTOIF':
                    $variable = $tokens[2];
                    $variableOrliteral = new VariableOrLiteral(implode(' ', array_slice($tokens, 3)));
                    $programMap[$line] = new GotoIfInstruction($variable, $variableOrliteral);
                    break;
                case 'END':
                    $programMap[$line] = new EndInstruction();
                    break;
                default:
                    throw new InvalidArgumentException('UNKNOWN OPCODE FOR ' . $programLine);
            }
        }
        return $programMap;
    }
} 