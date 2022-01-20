<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if (request()->isMethod('post')) {
            return $this->createRequest();
        }

        if (request()->isMethod('put') || request()->isMethod('patch')) {
            return $this->updateRequest();
        }

    }

    private function createRequest()
    {
        return [
            'name' => 'required|unique:categories,name',
            'status' => 'nullable|boolean',
        ];
    }

    private function updateRequest()
    {
        return [
            'name' => 'required|unique:categories,name,' . request()->route('category')->id,
            'status' => 'nullable|boolean',
        ];
    }
}
