<?php

namespace App\Queue;

use Closure;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;

class SpaceOutEmails
{
    public function handle(object $job, Closure $next): void
    {
        try {
            $wait = Cache::lock('email-spacing', 10)->block(5, function () {
                $now = now()->timestamp;
                $allowedAt = (int) Cache::get('email-next-allowed-at', 0);

                if ($now < $allowedAt) {
                    return $allowedAt - $now;
                }

                Cache::forever('email-next-allowed-at', $now + random_int(30, 120));

                return 0;
            });
        } catch (LockTimeoutException $e) {
            $wait = 10;
        }

        if ($wait > 0) {
            $job->release($wait);
            return;
        }

        $next($job);
    }
}
