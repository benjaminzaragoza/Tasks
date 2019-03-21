<?php

namespace App\Http\Controllers\Tenant\Web;


use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatIndex;

/**
 * Class ChatController.
 *
 * @package App\Http\Controllers\Tenant\Web
 */
class ChatController extends Controller
{
    /**
     * Index.
     *
     * @param ChatIndex $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ChatIndex $request)
    {
        $channels = $request->user()->channels;
        return view('tenants.chat.index', compact('channels'));
    }
}
