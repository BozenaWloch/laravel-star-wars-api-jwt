<?php
declare(strict_types=1);

namespace App\Http\Requests\Geolocation;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ip' => [
                'required_without:url',
                'ip',
            ],
            'url' => [
                'required_without:ip',
//                'url',
            ],
        ];
    }
}
