<?php

namespace VCDT\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FetchStatistics
{
    private string $box;

    private Client $client;

    public function __construct(string $box)
    {
        $this->box = $box;
        $this->client = new Client(['timeout' => 10.0]);
    }

    public function getStats(): ?array
    {
        $token = $this->getAccessToken();

        if (! $token) {
            Log::error('Failed to obtain HCP access token');

            return null;
        }

        try {
            $response = $this->client->request('GET', 'https://app.vagrantup.com/api/v1/box/'.$this->box, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($this->box);

            return null;
        }
    }

    private function getAccessToken(): ?string
    {
        return Cache::remember('hcp_access_token', 3500, function () {
            $clientId = config('app.hcp_client_id');
            $clientSecret = config('app.hcp_client_secret');

            if (! $clientId || ! $clientSecret) {
                Log::error('HCP_CLIENT_ID or HCP_CLIENT_SECRET not configured');

                return null;
            }

            try {
                $response = $this->client->request('POST', 'https://auth.idp.hashicorp.com/oauth2/token', [
                    'form_params' => [
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'grant_type' => 'client_credentials',
                        'audience' => 'https://api.hashicorp.cloud',
                    ],
                ]);

                $data = json_decode($response->getBody(), true);

                return $data['access_token'] ?? null;
            } catch (\Exception $e) {
                Log::error('Failed to get HCP access token: '.$e->getMessage());

                return null;
            }
        });
    }
}
