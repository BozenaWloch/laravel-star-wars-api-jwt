<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IpStack.
 *
 * @OA\Schema (
 *  @OA\Property(property="id", type="integer", readOnly="true", example=1),
 *  @OA\Property(property="details", type="json"),
 *  @OA\Property(property="created_at", type="string", description="Initial creation timestamp", readOnly="true", example="2018-04-16 11:11:11"),
 *  @OA\Property(property="updated_at", type="string", description="Last update timestamp", readOnly="true", example="2018-04-16 11:11:11"),
 * )
 *
 * @property int $id
 * @property string $details
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Geolocation extends Model
{
    protected $table = 'geolocation';

    /**
     * @var array
     */
    protected $fillable = [
        'details',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
