<?php

namespace App\Service\Simpsons;

use \App\Entity\Simpsons\Quote as QuoteEntity;
use App\Repository\Simpsons\QuoteRepository;
use App\Api\Simpsons\Quote as QuoteApi;
use Doctrine\Common\Collections\ArrayCollection;

class Quote
{
    private const MAX_OLD_QUOTES = 4;

    public function __construct(
        readonly private QuoteRepository $quoteRepository,
        readonly private QuoteApi $quoteApi
    ) {
    }

    public function getQuotes(): array
    {
        $currentQuotes = $this->quoteRepository->getQuotes('DESC');
        $quote = null;

        while (null === $quote || $this->doesQuoteExistInDatabase($quote->getQuoteHash(), $currentQuotes)) {
            $quote = $this->quoteApi->fetchNewQuote();
        }

        if (count($currentQuotes) > self::MAX_OLD_QUOTES) {
            $oldQuote = array_pop($currentQuotes);
            $this->quoteRepository->removeQuote($oldQuote);
        }

        $this->quoteRepository->addQuote(quote: $quote);
        // adds new quote at first position
        array_unshift($currentQuotes, $quote);

        return $currentQuotes;
    }

    /**
     * @param QuoteEntity[] $currentQuotes
     */
    private function doesQuoteExistInDatabase(string $quoteHash, array $currentQuotes): bool
    {
        foreach ($currentQuotes as $currentQuote) {
            if (!is_a($currentQuote, QuoteEntity::class)) {
                continue;
            }
            if($currentQuote->getQuoteHash() === $quoteHash) {
                return true;
            }
        }
        return false;
    }
}