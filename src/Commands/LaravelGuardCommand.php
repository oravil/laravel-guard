<?php

namespace Oravil\LaravelGuard\Commands;

use Illuminate\Console\Command;

class LaravelGuardCommand extends Command
{
    public $signature = 'guard';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
