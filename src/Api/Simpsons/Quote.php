<?php

namespace App\Api\Simpsons;

use App\Entity\Simpsons\Quote as QuoteEntity;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class Quote
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function fetchNewQuote(): QuoteEntity
    {
        $response = $this->client->request(
            'GET',
            'https://thesimpsonsquoteapi.glitch.me/quotes',
            ['query' => [
                'count' => 1
            ]]
        );
        $quote = json_decode($response->getContent(), null, 512, JSON_THROW_ON_ERROR)[0];

        return new QuoteEntity($quote->quote);
    }
}