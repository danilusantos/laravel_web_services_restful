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
            case "POST":
                return [
                    'category_id'   => 'required|exists:categories,id',
                    'name'          => "required|min:3|max:10|unique:products,name",
                    'description'   => 'max:1000',
                    'image'         => 'image'
                ];
            case "PUT":
                return [
                    'category_id'   => 'required|exists:categories,id',
                    'name'          => "required|min:3|max:10|unique:products,name,{$this->segment(3)},id",
                    'description'   => 'max:1000',
                    'image'         => 'image'
                ];

        }
    }
}
