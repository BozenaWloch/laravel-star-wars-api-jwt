<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class IpStackAPIException extends Exception
{
    public function __construct($message = 'Something wnt wrong with IpStack API request.', $code = JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
    {
        parent::__construct($message, $code);
    }
}
