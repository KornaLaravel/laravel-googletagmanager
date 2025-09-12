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

        if (($data = $this->session->get($this->sessionKey))) {
            /** @var array<string, mixed> $data */
            $this->googleTagManager->set($data);
        }

        if (($flashPushData = $this->session->get($flashPushKey)) && is_array($flashPushData)) {
            foreach ($flashPushData as $pushData) {
                /** @var array<string, mixed> $pushData */
                $this->googleTagManager->push($pushData);
            }
        }

        $response = $next($request);

        $this->session->flash($this->sessionKey, $this->googleTagManager->getFlashData());
        $this->session->flash(
            $flashPushKey,
            $this->googleTagManager->getFlashPushData()->toArray()
        );

        return $response;
    }
}
