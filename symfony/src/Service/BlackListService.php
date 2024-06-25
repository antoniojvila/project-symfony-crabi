<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BlackListService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function checkBlackList(array $data): bool
    {
        $response = $this->httpClient->request('POST', 'http://44.210.144.170/check-blacklist/', [
            'json' => $data,
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception('Error checking blacklist');
        }

        $responseData = $response->toArray(false);

        return $responseData['is_in_blacklist'];
    }
}