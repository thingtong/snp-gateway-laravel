<?php

namespace App\Console\Commands;

use App\Enums\StaticToken;
use App\Models\MetaData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Str;

class RegenerateApiToken extends Command
{
    protected $signature = 'api:regen-token {--key= : Specify a key API token}';
    protected $description = 'Regenerate the static API token';

    public function handle()
    {
        $key = $this->option('key');
        $newToken = Str::random(32);

        MetaData::updateOrCreate(
            ['key' => $key],
            ['value' => $newToken]
        );

        Cache::forget(StaticToken::PrefixKey->value . $key);

        $this->info('API token has been regenerated and cache cleared: ' . $newToken);
    }
}
