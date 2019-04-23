<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\Notifications\PushSubscriptionDelete;
use App\Http\Requests\Notifications\PushSubscriptionUpdate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PushSubscriptionController extends Controller
{
    use ValidatesRequests;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Update user's subscription.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(PushSubscriptionUpdate $request)
    {
        $this->validate($request, ['endpoint' => 'required']);
        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->key,
            $request->token
        );
    }
    /**
     * Delete the specified subscription.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushSubscriptionDelete $request)
    {
        $this->validate($request, ['endpoint' => 'required']);
        $request->user()->deletePushSubscription($request->endpoint);
        return response()->json(null, 204);
    }
}
