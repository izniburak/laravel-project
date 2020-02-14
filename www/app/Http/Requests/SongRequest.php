<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
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
            'category_id' => 'required|string|max:36|min:36',
            'name' => 'required|max:50',
            'album' => 'required|max:100',
            'artist' => 'required|max:50',
            'source' => 'required|max:255',
            'image' => 'nullable|string|max:255',
            'status' => 'nullable|integer|max:1',
        ];
    }
}
