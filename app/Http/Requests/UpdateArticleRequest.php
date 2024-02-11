<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 권한 확인
     */
    public function authorize(): bool
    {
//        return false;
        // dd($this->route('article'));
//        dd($this->user());
        return $this->user()->can('update', $this->route('article')); // 수정 가능한 유저만 수정가능
    }

    /**
     * Get the validation rules that apply to the request.
     * 유효성 검사
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}
