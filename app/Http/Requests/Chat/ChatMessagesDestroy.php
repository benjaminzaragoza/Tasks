<?php
namespace App\Http\Requests\Chat;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
/**
 * Class ChatMessagesDestroy.
 *
 * @package App\Http\Requests
 */
class ChatMessagesDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('chat.destroy',$this->channel);
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
