<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\GlobalUtilProvider::class,
    App\Providers\LogViewerProvider::class,
    App\Providers\RateLimitProvider::class,
    App\Providers\RepositoryProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    \Vinkla\Hashids\HashidsServiceProvider::class,
    Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
];
