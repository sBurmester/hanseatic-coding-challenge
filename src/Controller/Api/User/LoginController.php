<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Entity\User;
use App\Repository\ApiTokenRepository;
use App\Service\ApiToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    public function __construct(
        readonly private ApiTokenRepository $apiTokenRepository,
        readonly private ApiToken $apiTokenService
    ) {
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json(['error' => 'missing credentials!'], Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = null;
        $apiTokens = $this->apiTokenRepository->findBy(['user' => $user]);
        foreach ($apiTokens as $apiToken) {
            if ($apiToken->isValid()) {
                $accessToken = $apiToken->getAccessToken();
            }
        }

        if (null === $accessToken) {
            $accessToken = $this->apiTokenService->generateToken($user);
            $this->apiTokenService->saveToken($user, $accessToken);
        }

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token_type' => 'bearer',
            'access_token' => $accessToken,
        ]);
    }
}
