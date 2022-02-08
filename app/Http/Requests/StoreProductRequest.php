<?php

namespace App\Http\Requests;

use App\Constants\ProductTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'brand' => 'bail|required|string|max:50',
            'series' => 'bail|required|string|max:50',
            'model' => 'bail|required|string|max:50',
            'bracelet_material' => 'bail|required|string|max:50',
            'dial_color' => 'bail|required|string|max:50',
            'seller_full_name' => 'bail|required|string',
            'seller_id_number' => 'bail|required|string',
            'seller_phone_number' => 'bail|required|string',
            'seller_email' => 'bail|required|email',
            'type' => 'bail|required|string|'. Rule::in([ProductTypes::NEW, ProductTypes::USED]),
        ];
    }
}
