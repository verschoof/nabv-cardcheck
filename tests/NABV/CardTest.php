<?php

namespace NABV;

class CardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itCreatesSuccessfullyACard()
    {
        $card = new Card('cardnumber');

        $this->assertEquals('cardnumber', $card->toString());
    }
}
