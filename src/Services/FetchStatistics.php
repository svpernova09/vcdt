<?php

namespace VCDT\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FetchStatistics
{
    private $box;

    public function __construct(string $box)
    {
        $this->box = $box;
    }

    public function getStats()
    {
        $headers = [
            'Authorization' => 'Bearer '.config('app.vc_token'),
            'Accept' => 'application/json',
        ];
        $client = new Client([
            'base_uri' => 'https://app.vagrantup.com/api/v1/box/',
            'timeout' => 2.0,
        ]);

        try {
            $response = $client->request('GET', $this->box, [
                'headers' => $headers
            ]);

            return json_decode($response->getBody(), true);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e);
        }
    }
}
