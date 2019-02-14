<?php
namespace App\Http\Middleware;
use App\User;
use Carbon\Carbon;
use Closure;
use Auth;
use Illuminate\Support\Facades\Cache;
class LogLastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put(User::USERS_CACHE_KEY . '-user-is-online-' . Auth::user()->id, true, $expiresAt);

        }
        return $next($request);
    }
}