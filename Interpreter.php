<?php

require_once "InstructionMapper.php";
require_once "InstructionFlowEngine.php";
require_once "VariableOrLiteral.php";


class Interpreter
{

    /**
     * @param array $parameters These are the initial parameters as program parameters.
     */
    public function __construct(array $parameters = array())
    {
        $argumentNumber = 0;
        foreach($parameters as $parameter)
        {
            $this->variableMap[$argumentNumber] = $parameter;
        }
    }
    /**
     * @var array Map of Line => Instruction
     */
    private $programMap = array();

    /**
     * @var boolean
     */
    private $showMapOnCommand = false;

    /**
     * @param boolean $showMapOnCommand
     */
    public function setShowMapOnCommand($showMapOnCommand)
    {
        $this->showMapOnCommand = $showMapOnCommand;
    }

    /**
     * @return boolean
     */
    public function getShowMapOnCommand()
    {
        return $this->showMapOnCommand;
    }

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
        $mapper = new InstructionMapper();
        $this->programMap = $mapper->fillMap($program);
        $flowEngine = new InstructionFlowEngine($this->programMap);
        try{
         while(true)
         {
             $instruction = $flowEngine->getCurrentInstruction();
             if ($instruction === null)
             {
                 break;
             }
             /**
              * @var $instruction Instruction
              */
             $nextLabel = $instruction->execute($this->variableMap);
             if( $this->getShowMapOnCommand())
             {
                 echo $instruction. "\n";
                 print_r($this->variableMap);
             }
             if ($nextLabel === null) {
                 $flowEngine->setNext();
             } else {
                 $flowEngine->setNextLocation($nextLabel);
             }

         }
        } catch (EndInstructionException $e)
        {
            //regular end of the instruction line.
        }
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