<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Geolocation;

class GeolocationRepository
{
    public function model(): Geolocation
    {
        return new Geolocation();
    }

    public function getById(int $geolocationId): Geolocation
    {
        /** @var \App\Models\Geolocation $geolocation */
        $geolocation = $this->model()->query()->findOrFail($geolocationId);

        return $geolocation;
    }

    public function save(Geolocation $geolocation): bool
    {
        return $geolocation->save();
    }

    public function delete(Geolocation $geolocation): ?bool
    {
        return $geolocation->delete();
    }
}
