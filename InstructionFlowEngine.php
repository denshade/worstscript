<?php


class InstructionFlowEngine
{
    /**
     * @var array
     */
    private $instructionMap;

    /**
     * @var string| null if out of bounds.
     */
    private $currentLocation;

    /**
     * @param array $instructionMap
     */
    public function __construct($instructionMap)
    {
        $this->instructionMap = $instructionMap;
        reset($instructionMap);
        $this->currentLocation = key($instructionMap);
    }

    /**
     * @param string $location
     * @return void
     */
    public function setNextLocation($location)
    {
        $this->currentLocation = $location;
    }

    /**
     * @return void
     */
    public function setNext()
    {
        $keys = array_keys($this->instructionMap);
        $position = array_search($this->currentLocation, $keys);
        if (isset($keys[$position + 1]))
        {
            $this->currentLocation = $keys[$position + 1];
        }
        else
        {
            $this->currentLocation = null;
        }
    }

    /**
     * @return Instruction|null
     */
    public function getCurrentInstruction()
    {
        if ($this->currentLocation === null)
        {
            return null;
        }
        return $this->instructionMap[$this->currentLocation];
    }
} 