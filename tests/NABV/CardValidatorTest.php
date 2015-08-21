<?php

namespace NABV;

use Goutte\Client;
use GuzzleHttp\ClientInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DomCrawler\Crawler;

class CardValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy|ClientInterface
     */
    private $client;

    /**
     * @var ObjectProphecy|CardValidator
     */
    private $cardValidator;

    public function setUp()
    {
        $this->client = $this->prophesize(Client::class);

        $this->cardValidator = new CardValidator($this->client->reveal());
    }

    /**
     * @test
     */
    public function itReceivesAValidCard()
    {
        $validResponse = '
<div class="alert alert-success" role="alert">
    De relatie <strong>validcard</strong> heeft een <u>geldig</u> lidmaatschap.
</div>';

        $crawler = new Crawler();
        $crawler->addContent($validResponse);

        $card = new Card('validcard');

        $this->client->request(
            'POST',
            'https://mijn.nabv.nl/portal/controle',
            ['relation_number' => $card->toString()]
        )->willReturn($crawler);

        $this->assertTrue($this->cardValidator->isValidCard($card));
    }

    /**
     * @test
     */
    public function itReceivesAInvalidCard()
    {
        $invalidResponse = '
<div class="alert alert-danger" role="alert">
    De relatie <strong>invalidcard</strong> heeft geen (geldig) lidmaatschap.
</div>';

        $crawler = new Crawler();
        $crawler->addContent($invalidResponse);

        $card = new Card('invalidcard');

        $this->client->request(
            'POST',
            'https://mijn.nabv.nl/portal/controle',
            ['relation_number' => $card->toString()]
        )->willReturn($crawler);

        $this->assertFalse($this->cardValidator->isValidCard(new Card('invalidcard')));
    }
}
