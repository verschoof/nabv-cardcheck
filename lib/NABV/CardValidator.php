<?php

namespace NABV;

use Goutte\Client;

class CardValidator
{
    /**
     * @var string
     */
    private $url = 'https://mijn.nabv.nl/portal/controle';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Checks at the NABV site if the given card is correct
     * @param Card $card
     *
     * @return bool
     */
    public function isValidCard(Card $card)
    {
        $crawler = $this->client->request('POST', $this->url, ['relation_number' => $card->toString()]);

        $status = false;
        $crawler->filter('.alert.alert-success')->each(function () use (&$status) {
            $status = true;
        });

        return $status;
    }
}
