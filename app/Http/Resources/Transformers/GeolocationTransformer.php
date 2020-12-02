<?php
declare(strict_types=1);

namespace App\Http\Resources\Transformers;

use App\Models\Geolocation;

class GeolocationTransformer extends AbstractTransformer
{
    /**
     * @var string[]
     */
    protected $availableIncludes = [
    ];

    public function transform(Geolocation $geolocation)
    {
        return [
            'id'         => $geolocation->id,
            'details'    => \json_decode($geolocation->details, true),
            'created_at' => $this->formatDate($geolocation->created_at),
            'updated_at' => $this->formatDate($geolocation->updated_at),
        ];
    }
}
