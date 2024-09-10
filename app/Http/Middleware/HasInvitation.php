<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\invitations;
class HasInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->isMethod('GET'))
        if (!$request->has('invitation_token')) {
            return redirect(route('login'));
        }
        $invitation_token  = $request->get('invitation_token');
        $org_id = $request->get('org_id');
        $invitation = Invitations::where('invitation_token', $invitation_token)->firstOrFail();
            if (!$invitation || $invitation->org_id !== (int)$org_id) {
                return redirect(route('login')); 
            };
        return $next($request);
    }
}
