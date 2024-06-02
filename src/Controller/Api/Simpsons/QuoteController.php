<?php

namespace App\Controller\Api\Simpsons;

use App\Service\Simpsons\Quote as SimpsonsQuoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class QuoteController extends AbstractController
{
    public function __construct(readonly private SimpsonsQuoteService $simpsonsQuoteService)
    {
    }

    #[Route('/api/quote', name: 'api_quote_route', methods: ['GET'])]
    public function getQuotes(): JsonResponse
    {
        $quotes = $this->simpsonsQuoteService->getQuotes();

        return new JsonResponse($quotes);
    }
}