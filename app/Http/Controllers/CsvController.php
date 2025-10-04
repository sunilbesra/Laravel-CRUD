<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessCsvRow;
use App\Models\CsvJob;

class CsvController extends Controller
{
    /**
     * Show CSV upload form.
     */
    public function showForm()
    {
        return view('upload_csv');
    }

    /**
     * Handle CSV upload and dispatch jobs to Beanstalkd.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $fileName = $file->getClientOriginalName();

        if (($handle = fopen($file->getRealPath(), 'r')) === false) {
            return back()->with('error', 'Could not open CSV file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'CSV file is empty or invalid.');
        }

        $batchSize = 500;  // Number of rows per batch
        $batch = [];
        $rowCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            try {
                // Save CSV row to MongoDB collection
                $jobRecord = CsvJob::create([
                    'file_name' => $fileName,
                    'row_identifier' => $data['id'] ?? $rowCount + 1, // fallback if no 'id'
                    'data' => $data,
                    'status' => 'queued',
                ]);

                $batch[] = $jobRecord->_id;
                $rowCount++;

                // Dispatch batch if reached batch size
                if (count($batch) >= $batchSize) {
                    $this->dispatchBatch($batch);
                    $batch = [];
                }
            } catch (\Exception $e) {
                Log::error("Failed to save CSV row: " . $e->getMessage(), ['row' => $data]);
            }
        }

        // Dispatch remaining rows
        if (!empty($batch)) {
            $this->dispatchBatch($batch);
        }

        fclose($handle);

        return back()->with('success', "CSV uploaded ($rowCount rows) and jobs dispatched!");
    }

    /**
     * Dispatch CSV row jobs to Beanstalkd queue.
     */
    private function dispatchBatch(array $jobIds)
    {
        foreach ($jobIds as $jobId) {
            try {
                ProcessCsvRow::dispatch($jobId)
                    ->onQueue('csv_jobs')
                    ->delay(now()->addSeconds(1));
            } catch (\Exception $e) {
                Log::error("Failed to dispatch job for CSV row ID $jobId: " . $e->getMessage());
            }
        }
    }
}
