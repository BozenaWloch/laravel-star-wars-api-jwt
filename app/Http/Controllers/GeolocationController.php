<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Geolocation\CreateRequest;
use App\Http\Requests\Geolocation\ReadRequest;
use App\Http\Requests\Geolocation\DeleteRequest;
use App\Http\Resources\Response\GeolocationResourceResponse;
use App\Models\Geolocation;
use App\Repositories\GeolocationRepository;
use App\Services\IpStack\IpStack;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class GeolocationController extends Controller
{
    /**
     * @var \App\Http\Resources\Response\GeolocationResourceResponse
     */
    private $geolocationResourceResponse;

    /**
     * @var \App\Repositories\GeolocationRepository
     */
    private $geolocationRepository;

    /**
     * @var \App\Services\IpStack\IpStack
     */
    private $ipStack;

    public function __construct(
        GeolocationResourceResponse $geolocationResourceResponse,
        GeolocationRepository $geolocationRepository,
        IpStack $ipStack
    ) {
        $this->geolocationResourceResponse = $geolocationResourceResponse;
        $this->geolocationRepository = $geolocationRepository;
        $this->ipStack = $ipStack;
    }

    /**
     * @OA\Post(
     *     path="/geolocation",
     *     summary="Create new geolocation from ip or url",
     *     tags={"geolocation"},
     *     @OA\RequestBody(
     *        required=true,
     *        description="Pass url or ip",
     *        @OA\JsonContent(
     *           @OA\Property(property="ip", type="string", example="172.217.20.206"),
     *           @OA\Property(property="url", type="string", example="https://www.google.com/"),
     *        ),
     *     ),
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *       response=200,
     *       description="Success",
     *       @OA\JsonContent(
     *          ref="#/components/schemas/Geolocation",
     *       )
     *     )
     * )
     *
     * @param \App\Http\Requests\Geolocation\CreateRequest $request
     * @param \App\Models\Geolocation                      $geolocationModel
     */
    public function create(CreateRequest $request, Geolocation $geolocationModel): array
    {
        if ($request->has('ip') && $request->has('url')) {
            throw new UnprocessableEntityHttpException('Choose only one param: ip or url');
        }

        if ($request->has('url')) {
            $domain = \str_replace('www.', '', \parse_url($request->get('url'), PHP_URL_HOST));
            $ip = \gethostbyname($domain);
        }

        $details = $this->ipStack->getDetailsByIp($ip ?? $request->get('ip'));
        $geolocationModel->details = $details;

        $this->geolocationRepository->save($geolocationModel);

        return $this->geolocationResourceResponse->transform($request, $geolocationModel);
    }

    /**
     * @OA\Get(
     *     path="/geolocation/{geolocationId}",
     *     summary="Display selected geolocation data",
     *     tags={"geolocation"},
     *     @OA\Parameter(
     *        in="path",
     *        name="geolocationId",
     *        required=true,
     *        example="1",
     *        @OA\Schema(
     *           type="integer",
     *        )
     *     ),
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *       response=200,
     *       description="Success",
     *       @OA\JsonContent(
     *          ref="#/components/schemas/Geolocation",
     *       )
     *     )
     * )
     *
     * @param \App\Http\Requests\Geolocation\ReadRequest $request
     * @param int                                        $geolocationId
     *
     * @return array
     */
    public function read(ReadRequest $request, int $geolocationId): array
    {
        $geolocation = $this->geolocationRepository->getById($geolocationId);

        return $this->geolocationResourceResponse->transform($request, $geolocation);
    }

    /**
     * @OA\Delete(
     *     path="/geolocation/{geolocationId}",
     *     summary="Delete selected geolocation",
     *     tags={"geolocation"},
     *     @OA\Parameter(
     *        in="path",
     *        name="geolocationId",
     *        required=true,
     *        example="1",
     *        @OA\Schema(
     *           type="integer",
     *        )
     *     ),
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *       response=200,
     *       description="Success",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Geolocation data removed successfully."),
     *         )
     *     )
     * )
     *
     * @param \App\Http\Requests\Geolocation\DeleteRequest $request
     * @param int                                          $geolocationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteRequest $request, int $geolocationId): JsonResponse
    {
        $geolocation = $this->geolocationRepository->getById($geolocationId);

        $this->geolocationRepository->delete($geolocation);

        return new JsonResponse(['message' => 'Geolocation data removed successfully.'], JsonResponse::HTTP_OK);
    }
}
