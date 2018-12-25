<?php

/* Create by Xenial ~ artisan */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'      => 'required|string|min:3|max:50',

            'short_text' => 'required|string|min:3|max:200',
            'full_text'  => 'min:3',

            # Категория указывается обязательно, т.к. у нас не может быть Статьи без Категории,
            # т.е. всегда должна быть выбрана хотя бы 1-на Категория
            'categories' => 'required|array'
        ];
    }
}
