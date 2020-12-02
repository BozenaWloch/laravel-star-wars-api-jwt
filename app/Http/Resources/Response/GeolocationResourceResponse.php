<?php
declare(strict_types=1);

namespace App\Http\Resources\Response;

use App\Http\Resources\ResourceItem;
use App\Http\Resources\Transformers\GeolocationTransformer;
use Exception;
use Illuminate\Http\Request;

class GeolocationResourceResponse implements ResourceResponseInterface
{
    /**
     * @var \App\Http\Resources\Transformers\UserTransformer
     */
    private $transformer;

    public function __construct(GeolocationTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function transform(Request $request, $data): array
    {
        $item = new ResourceItem($request, $data, $this->transformer);

        return $item->toArray();
    }

    public function transformCollection(Request $request, $data): array
    {
        throw new Exception('Method not implemented');
    }

    public function transformPaginatedCollection(Request $request, array $data): array
    {
        throw new Exception('Method not implemented');
    }
}
