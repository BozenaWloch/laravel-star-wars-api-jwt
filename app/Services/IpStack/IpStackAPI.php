<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\IpStackAPIException;
use GuzzleHttp\Exception\ClientException;

class IpStackAPI
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $ipStackAPIGuzzleClient;

    /**
     * IpStackAPI constructor.
     *
     * @param \App\Services\IpStackAPIGuzzleClient $ipStackAPIGuzzleClient
     */
    public function __construct(IpStackAPIGuzzleClient $ipStackAPIGuzzleClient)
    {
        $this->ipStackAPIGuzzleClient = $ipStackAPIGuzzleClient->getClient();
    }

    public function getByIp(string $ip): string
    {
        try {
            $response = $this->ipStackAPIGuzzleClient->request('GET', $ip);
            $geolocation = $response->getBody()->getContents();
        } catch (ClientException $exception) {
            $error = \json_decode((string) $exception->getResponse()->getBody()->getContents(), true);

            throw new IpStackAPIException($error['detail'] ?? 'Something went wrong during ip request.');
        }

        return $geolocation;
    }
}
