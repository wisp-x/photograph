<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'name' => 'required|max:200',
            'intro' => 'max:1000',
            'photos' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '相册名称',
            'intro' => '相册简介',
            'photos' => '照片',
        ];
    }
}
