<?php

namespace Spatie\GoogleTagManager;

use Closure;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Session\Store as Session;
use Symfony\Component\HttpFoundation\Response;

class GoogleTagManagerMiddleware
{
    protected string $sessionKey;

    public function __construct(
        protected GoogleTagManager $googleTagManager,
        protected Session $session,
        protected Config $config,
    ) {
        $this->sessionKey = $config->string('googletagmanager.sessionKey');
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $flashPushKey = $this->sessionKey.':push';

        if ($this->session->has($this->sessionKey)) {
            $this->googleTagManager->set($this->session->get($this->sessionKey));
        }
        
        if ($this->session->has($flashPushKey)) {
            foreach ($this->session->get($flashPushKey) as $pushData) {
                $this->googleTagManager->push($pushData);
            }
        }

        $response = $next($request);

        $this->session->flash($this->sessionKey, $this->googleTagManager->getFlashData());
        $this->session->flash(
            $flashPushKey,
            $this->googleTagManager->getFlashPushData()
                ->map(fn (DataLayer $dataLayer) => $dataLayer->toArray())
                ->toArray()
        );

        return $response;
    }
}
