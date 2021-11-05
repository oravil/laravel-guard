<?php

namespace Oravil\LaravelGuard\Commands;

use Illuminate\Console\Command;
use Oravil\LaravelGuard\Facades\LaravelGuard;

class LaravelGuardCommand extends Command
{
    public $signature = 'guard:flush';

    public $description = 'Flush Laravel Guard Locations Data';

    public function handle()
    {
        LaravelGuard::flushCache();
        $this->info('Laravel Guard Locations Data Cache Flushed Successfully!');
    }
}
