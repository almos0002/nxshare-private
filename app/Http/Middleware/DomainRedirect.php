<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Settings;

class DomainRedirect
{
    public function handle($request, Closure $next)
    {
        $settings = Settings::first();
        
        if ($settings && $settings->redirect_enabled && $settings->active_domain) {
            $currentUrl = $request->fullUrl();
            $targetDomain = rtrim($settings->active_domain, '/');
            
            // Only redirect if not already on target domain
            if (!str_contains($currentUrl, $targetDomain)) {
                $newUrl = $targetDomain.'/'.$request->path();
                return redirect()->away($newUrl, 302);
            }
        }

        return $next($request);
    }
}
