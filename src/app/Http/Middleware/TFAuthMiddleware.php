<?php

namespace ikepu_tp\SecureAuth\app\Http\Middleware;

use Closure;
use ikepu_tp\SecureAuth\app\Models\TFA;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class TFAuthMiddleware
{
    /** @var TFA */
    public $tfa;

    function __construct()
    {
        $this->tfa = new TFA();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user(config("secure-auth.guard"))) throw new UnauthorizedException();

        if (empty($request->session()->get("__tfa"))) {
            return $this->setTFA($request);
        } else {
            if (!$this->tfa->auth) return $this->redirectToAuth();
        }
        return $next($request);
    }

    private function setTFA(Request $request): Response
    {
        $this->tfa->generateTFA();
        $this->tfa->setTFA();
        return $this->redirectToAuth();
    }

    private function redirectToAuth(): Response
    {
        return response()->redirectTo("");
    }
}