<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AssignReservationTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-reservation-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for next 1 hour reservation tables and change the status of the table accordingly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        $this->info('----------------------------------------');
        $this->info('Starting table reservation status update...');

        DB::enableQueryLog();

        try {
            // Get restaurant timezone and calculate time range
            $timezone = Restaurant::value('timezone');
            $now = now($timezone);
            $start = $now->toDateTimeString();
            $end = $now->addHour()->toDateTimeString();

            // Process in chunks to handle large datasets efficiently
            $chunkSize = 1000;
            $processedTables = 0;

            // Get table IDs that need updating
            $tableIds = DB::table('reservations')
                ->select('table_id')
                ->whereNotNull('table_id')
                ->whereBetween('reservation_date_time', [$start, $end])
                ->distinct()
                ->pluck('table_id');

            // Update tables in chunks
            foreach ($tableIds->chunk($chunkSize) as $chunk) {
                $updated = Table::whereIn('id', $chunk)
                    ->update(['available_status' => 'reserved']);

                $processedTables += $updated;

                $this->info("Processed {$updated} tables in current chunk");
            }

            $this->info("Total tables processed: {$processedTables}");
        } catch (\Exception $e) {
            $this->error('Error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $executionTime = round(microtime(true) - $startTime, 2);
        $memoryUsed = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2);
        $queryCount = count(DB::getQueryLog());

        $this->line("<fg=green>✓</> <fg=blue>Completed in</> <fg=yellow>{$executionTime}s</> <fg=white>|</> <fg=yellow>{$memoryUsed}MB</> <fg=white>|</> <fg=yellow>{$queryCount}</> <fg=blue>queries</>");

        return Command::SUCCESS;
    }
}
