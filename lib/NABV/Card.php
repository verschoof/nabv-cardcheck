<?php

namespace NABV;

class Card
{
    private $cardNumber;

    /**
     * @param string $cardNumber
     */
    public function __construct($cardNumber)
    {
        $this->cardNumber = (string) $cardNumber;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->cardNumber;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
