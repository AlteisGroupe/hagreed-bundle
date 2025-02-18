<?php

namespace Alteis\HagreedBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiHagreedService implements ApiHagreedInterface
{
    const URL = 'https://api.hagreed.com/api/export-consents';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $token,
    ) {}

    public function exportConsents(string $email): array
    {
        $response = $this->client->request('POST', self::URL, [
            'body' => [
                'token' => $this->token,
                'output' => $email,
            ]
        ]);

        return $response->toArray();
    }
}