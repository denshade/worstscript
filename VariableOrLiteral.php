<?php


class VariableOrLiteral
{
    /**
     * @var string
     */
    private $variableOrLiteral;

    /**
     * @param string $variableOrLiteral
     */
    public function __construct($variableOrLiteral)
    {
        $this->variableOrLiteral = $variableOrLiteral;
    }


    /**
     * @param array $variableMap
     * @return string
     */
    public function getValue($variableMap)
    {
        if (strpos($this->variableOrLiteral, '"') === 0)
        {
            $value = substr ( $this->variableOrLiteral, 1, count($this->variableOrLiteral) - 2);
        } else {
            $value = $variableMap[$this->variableOrLiteral];
        }
        return $value;
    }
} 