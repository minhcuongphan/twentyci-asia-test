<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $post = null;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (request()->isMethod('put') || request()->isMethod('patch')) {
            $this->post = Post::find(request()->post_id);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->post ??= new Post();
        return [
            'title' => 'required',
            'thumbnail' => $this->post->exists ? ['image'] : ['required', 'image'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($this->post)],
            'excerpt' => 'required',
            'body' => 'required',
            'status' => ['nullable', 'numeric', 'in:' . implode(',', array_keys(config('helper.status')))],
        ];
    }
}
