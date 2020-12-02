<?php
declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class IpStackAPIGuzzleClient
{
    /**
     * @var array
     */
    private $options;

    public function __construct()
    {
        $this->options = [
            'base_uri' => env('IP_STACK_API_URL', 'http://api.ipstack.com/'),
            'timeout'  => 60,
            'query'    => [
                'access_key' => env('IP_STACK_ACCESS_KEY'),
            ],
        ];
    }

    public function getClient(): Client
    {
        return new Client($this->options);
    }
}
