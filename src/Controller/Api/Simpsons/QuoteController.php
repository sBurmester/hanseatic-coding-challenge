<?php

namespace App\Controller\Api\Simpsons;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Simpsons\Quote as SimpsonsQuoteService;

class QuoteController extends AbstractController
{
    public function __construct(readonly private SimpsonsQuoteService $simpsonsQuoteService)
    {
    }

    #[Route('/api/quote', name: 'quote', methods: ['GET'])]
    public function getQuotes(): JsonResponse
    {
        $quotes = $this->simpsonsQuoteService->getQuotes();

        return new JsonResponse($quotes);
    }
}