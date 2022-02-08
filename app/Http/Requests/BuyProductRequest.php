<?php

namespace App\Http\Requests;

use App\Constants\ProductTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BuyProductRequest extends FormRequest
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
            'product_id' => 'bail|required|string|max:50',
        ];
    }
}
