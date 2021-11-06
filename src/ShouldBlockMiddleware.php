<?php

namespace Oravil\LaravelGuard;

use Closure;

class ShouldBlockMiddleware
{
    public function handle($request, Closure $next)
    {
        if (! config('guard.security.enabled', false)) {
            return $next($request);
        }

        $request->merge(['ipGuard' => $this->checkGuardFilters(getIp())]);

        if ($request->ipGuard->shouldBlock && config('guard.security.middleware.enabled')) {
            abort(config('guard.security.middleware.abort_code'), config('guard.security.middleware.block_message'));
        }

        return $next($request);
    }

    protected function checkGuardFilters($ip)
    {
        if (config('guard.security.filters.is_cloud') && $ip->isCloudProvider) {
            $ip->shouldBlock = true;
            $ip->blockType = 'cloud';
        }

        if (config('guard.security.filters.is_anonymous') && $ip->isAnonymous) {
            $ip->shouldBlock = true;
            $ip->blockType = 'anonymous';
        }

        if (config('guard.security.filters.is_bogon') && $ip->isBogon) {
            $ip->shouldBlock = true;
            $ip->blockType = 'bogon';
        }

        if (config('guard.security.filters.is_threat') && $ip->isThreat) {
            $ip->shouldBlock = true;
            $ip->blockType = 'threat';
        }

        return $ip;
    }
}
