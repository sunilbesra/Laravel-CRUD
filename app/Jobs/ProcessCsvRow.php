<?php

namespace App\Jobs;

use App\Models\CsvJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCsvRow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function handle()
    {
        $jobRecord = CsvJob::find($this->jobId);

        if (!$jobRecord) return;

        // Mark as processing
        $jobRecord->status = 'processing';
        $jobRecord->save();

        try {
            $row = $jobRecord->data;

            // Example processing: save to another collection
            \DB::connection('mongodb')->collection('processed_data')->insert($row);

            // Mark as completed
            $jobRecord->status = 'completed';
            $jobRecord->save();
        } catch (\Exception $e) {
            $jobRecord->status = 'failed';
            $jobRecord->error_message = $e->getMessage();
            $jobRecord->save();

            throw $e;
        }
    }
}
