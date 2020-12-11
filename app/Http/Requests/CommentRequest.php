<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'commenter' => 'required|max:50',
            'comment' => 'required|max:255',
        ];
    }

    /**
     * バリデーションメッセージ
     */
    public function messages()
    {
        return [
            'commenter.required' => '名前を入力して下さい。',
            'comment.required' => 'コメントを入力して下さい。',
            'commenter.max' =>"名前は50文字以内で入力してください。",
            'comment.max' =>"コメントは255文字以内で入力してください。",
        ];
    }
}
