<?php
declare(strict_types=1);

namespace App\Http\Requests\Geolocation;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ReadRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'geolocation_id' => [
                'required',
                Rule::exists('geolocation', 'id'),
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        /** @var \Illuminate\Routing\Route $route */
        $route = $this->route();

        $this->merge([
            'geolocation_id' => $route->parameter('geolocationId'),
        ]);
    }
}
