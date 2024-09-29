<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'slug' => 'required|unique:catalogs,slug'
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'Title should be unique'
        ];
    }

    protected function prepareForValidation()
    {
        $slug = generateSlug($this->input('title'));
        $this->merge([
            'slug' => $slug
        ]);
    }
}
