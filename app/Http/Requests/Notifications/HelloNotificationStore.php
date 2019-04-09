<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 9/04/19
 * Time: 19:13
 */

namespace App\Http\Requests\Notifications;
use Illuminate\Foundation\Http\FormRequest;


class HelloNotificationStore extends FormRequest {
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
        return [];
    }
}
