<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class LogViewerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        LogViewer::auth(function ($request) {
            if ($this->app->isLocal()) {
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            }
            // check env local return true
            if (app()->environment('local')) {
                return true;
            }

            // api ของ side bar
            if (strpos($request->url(), '/log-viewer/api/') !== false) {
                // check same site return true
                $referer = $request->headers->get('referer');
                $refererHost = parse_url($referer, PHP_URL_HOST);
                $requestHost = $request->getHost();
                if ($refererHost === $requestHost) {
                    return true;
                }

                return false;
            }

            // ถ้าจะเปลี่ยนรหัส ใช้ \Hash::make แล้วเอามาใส่ใหม่
            $sessionKey = 'can-access-log-viewer';
            $pwd = $request->input('pwd');
            // $encryptPwd = '$2y$10$kYelKmIGQL368QUfj6125e0itv5BRgJR7Nst9IJQunGsEqdq5qNlW';
            // $passes = \Hash::check($pwd, $encryptPwd);
            $passes = $pwd === env('LOG_VIEWER_PASSWORD');
            $clear = $request->input('clear');

            if ($clear) {
                session()->forget($sessionKey);

                return false;
            }

            if (session($sessionKey)) {
                return true;
            }

            if ($passes) {
                session([$sessionKey => true]);

                return true;
            } else {
                session()->forget($sessionKey);

                return false;
            }
        });
    }
}
