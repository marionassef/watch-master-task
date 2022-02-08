<?php

namespace App\Http\Requests;

use App\Constants\ProductStatus;
use App\Constants\ProductTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'watch_id' => 'bail|required|string|max:50',
            'brand' => 'bail|required|string|max:500',
            'series' => 'bail|required|string|max:500',
            'model' => 'bail|required|string|max:500',
            'bracelet_material' => 'bail|required|string|max:50',
            'case_size' => 'bail|required|numeric',
            'dial_color' => 'bail|required|string|max:500',
            'status' => 'bail|required|numeric|'. Rule::in([ProductStatus::AVAILABLE, ProductStatus::SOLD]),
            ];
    }
}
