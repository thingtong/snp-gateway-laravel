<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GlobalUtilProvider extends ServiceProvider
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
        $rdi = new RecursiveDirectoryIterator(app_path('Utils'.DIRECTORY_SEPARATOR.'Global'));
        $it = new RecursiveIteratorIterator($rdi);

        while ($it->valid()) {
            if (
                ! $it->isDot() &&
                $it->isFile() &&
                $it->isReadable() &&
                $it->current()->getExtension() === 'php' &&
                strpos($it->current()->getFilename(), 'Util')
            ) {
                require $it->key();
            }

            $it->next();
        }
    }
}
