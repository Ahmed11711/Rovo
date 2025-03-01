<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DemoSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        $queryCount = 0;

        $this->info('----------------------------------------');
        $this->info('Starting migration and seeding...');

        DB::enableQueryLog();

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        $executionTime = round(microtime(true) - $startTime, 2);
        $memoryUsed = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2);
        $queryCount = count(DB::getQueryLog());

        $this->line("<fg=green>✓</> <fg=blue>Completed in</> <fg=yellow>{$executionTime}s</> <fg=white>|</> <fg=yellow>{$memoryUsed}MB</> <fg=white>|</> <fg=yellow>{$queryCount}</> <fg=blue>queries</>");
    }
}
