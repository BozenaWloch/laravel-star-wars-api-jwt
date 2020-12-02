<?php
declare(strict_types=1);

namespace App\Services\IpStack;

use App\Services\IpStackAPI;

class IpStack
{
    /**
     * @var \App\Services\IpStackAPI
     */
    private $ipStackAPI;

    public function __construct(IpStackAPI $ipStackAPI)
    {
        $this->ipStackAPI = $ipStackAPI;
    }

    public function getDetailsByIp(string $ip): string
    {
        return $this->ipStackAPI->getByIp($ip);
    }
}
