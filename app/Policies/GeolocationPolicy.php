<?php
declare(strict_types=1);

namespace App\Policies;

use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeolocationPolicy extends AbstractPolicy
{
    use HandlesAuthorization;

    public function read(User $user, Request $request): bool
    {
        return true;
    }

    public function delete(User $user, Request $request): bool
    {
        return true;
    }

    public function create(User $user, Request $request): bool
    {
        return true;
    }
}
