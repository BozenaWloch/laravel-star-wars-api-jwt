<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    public function __construct($message = 'Unauthorized', $code = JsonResponse::HTTP_UNAUTHORIZED)
    {
        parent::__construct($message, $code);
    }
}
