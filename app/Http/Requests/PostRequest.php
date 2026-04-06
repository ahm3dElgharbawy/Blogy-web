<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $imageRule = $this->isMethod('post')
        ? 'required'
        : 'nullable';

        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'read_time' => 'required|integer|min:1',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'tags' => ['nullable', 'regex:/^([a-zA-Z0-9\s]+)(,\s*[a-zA-Z0-9\s]+)*$/'], // ex: "ai, technology, future"
            'status' => 'required|in:published,draft,review',
            'image' => "$imageRule|image|mimes:jpg,png|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'The category field is required.',
        ];
    }
}
