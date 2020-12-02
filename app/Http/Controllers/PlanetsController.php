<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenException;
use App\Http\Requests\Request;
use App\Repositories\UserRepository;
use App\Services\StarWars\StarWars;

class PlanetsController extends Controller
{
    /**
     * @var \App\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * @var \App\Services\StarWars\StarWars
     */
    private $starWars;

    public function __construct(UserRepository $userRepository, StarWars $starWars)
    {
        $this->userRepository = $userRepository;
        $this->starWars = $starWars;
    }

    /**
     * @OA\Get(
     *     path="/users/{userId}/planets",
     *     summary="Display selected user planets",
     *     tags={"planets"},
     *     @OA\Parameter(
     *        in="path",
     *        name="userId",
     *        required=true,
     *        example="1",
     *        @OA\Schema(
     *           type="integer",
     *        )
     *     ),
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *       response=200,
     *       description="Success"
     *     )
     * )
     *
     * @param \App\Http\Requests\Request $request
     * @param int                        $userId
     *
     * @return array
     */
    public function list(Request $request, int $userId): array
    {
        $user = $this->userRepository->getById($userId);

        return $this->starWars->getPersonPlanets($user->external_id);
    }

    /**
     * @OA\Get(
     *     path="/users/{userId}/planets/{planetId}",
     *     summary="Display selected user planets",
     *     tags={"planets"},
     *     @OA\Parameter(
     *        in="path",
     *        name="userId",
     *        required=true,
     *        example="1",
     *        @OA\Schema(
     *           type="integer",
     *        )
     *     ),
     *     @OA\Parameter(
     *        in="path",
     *        name="planetId",
     *        required=true,
     *        example="1",
     *        @OA\Schema(
     *           type="integer",
     *        )
     *     ),
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *       response=200,
     *       description="Success"
     *     )
     * )
     *
     * @param \App\Http\Requests\Request $request
     * @param int                        $userId
     * @param int                        $planetId
     *
     * @throws \App\Exceptions\ForbiddenException
     *
     * @return array
     */
    public function read(Request $request, int $userId, int $planetId): array
    {
        $user = $this->userRepository->getById($userId);

        $person = $this->starWars->getPersonById($user->external_id);

        if (!\in_array($planetId, $person['planets_ids'] ?? [])) {
            throw new ForbiddenException();
        }

        return $film = $this->starWars->getPlanet($planetId);
    }
}
