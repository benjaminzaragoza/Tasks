<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLoggedUserTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return true;
        return Auth::user()->can('user.tasks.update');

//        return Auth::user()->isSuperAdmin() || Auth::user()->hasROle('TaskManager') ||
//            Auth::user()->id===$this->task->user_id || today_is_happy_day;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'description'=>'string'
        ];
    }
}
