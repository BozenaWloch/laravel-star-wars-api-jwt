<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTManager
{
    public function generateForUser(User $user): string
    {
        return JWTAuth::fromUser($user);
    }
}
