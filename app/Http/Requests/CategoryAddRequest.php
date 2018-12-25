<?php

/* Create by Xenial ~ artisan */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    # Этот Request выполняется для:
    public function authorize()
    {
        #return false;   # для всех пользователей
        return true;    # только для Авторизованных пользователей (более того, по логике Роутов - ещё и только Админом)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        # В случае не прохождения Валидации, мы не дойдём даже до Контроллера, и в Action соответственно также на попадём,
        # нас перенаправит (back) на ту страницу, с которой мы посылали Запрос на Обработчик, после чего Request опять будет проверять Запрос
        # при чём, обрати внимание, что сообщения о Ошибках не выведется, потому что нам нужно их ловить, обрабатыват, и выводить
        # но мы это реализуем: см. resources/views/inc/messages.blade.php

        return [
            'title'             => 'required|string|min:3|max:50|unique:categories',
            'description'       => 'max:100',
        ];
    }

#    /**
#     * @return array
#     */
#    public function messages()
#    {
#        # Обратие внимание, что Метода message() не было изначально, но мы его можем переопределить
#        # !!! На самом деле, вы можете переопределить сообщение, добавив Метод messages()
#        # т.е. какие-то сообщения, которые будут применены к указанным Rules (Правилам)
#        # А сам Метод messages() описан в Родительском Классе FormRequest (см. FormRequest)
#        # Иными словами, мы можем создать свои а не дефолтные Ошибки!
#        return parent::messages();
#    }

}
