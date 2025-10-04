<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCsvRow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    // Retry 3 times if failed
    public $tries = 3;
    public $backoff = 10; // seconds before retry

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function handle()
    {
        // Example: store data into DB
        try {
            \DB::table('csv_data')->insert($this->row);

            Log::info('Row processed:', $this->row);
        } catch (\Exception $e) {
            Log::error('Error processing row: '.$e->getMessage(), $this->row);
            throw $e; // will trigger retry
        }
    }
}
