<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                $rules = [
                    'category_id'   => 'required|exists:categories,id',
                    'name'          => 'required|min:3|max:10|unique:products',
                    'description'   => 'max:1000',
                    'image'         => 'image'
                ];
                break;
            case 'PUT':
                $rules = [
                    'category_id'   => 'required|exists:categories,id',
                    'name'          => "required|min:3|max:10|unique:products,name,{$this->segment(3)},id",
                    'description'   => 'max:1000',
                    'image'         => 'image'
                ];
                break;
            default:
                $rules = [];
        }

        return $rules;
    }
}
