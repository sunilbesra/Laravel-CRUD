<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessCsvRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvController extends Controller
{
    public function showForm()
    {
        return view('upload_csv');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        $batchSize = 1000;
        $batch = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            $batch[] = $data;

            if (count($batch) === $batchSize) {
                $this->dispatchBatch($batch);
                $batch = [];
            }
        }

        // Dispatch remaining rows
        if (!empty($batch)) {
            $this->dispatchBatch($batch);
        }

        fclose($handle);

        return back()->with('success', 'CSV uploaded and jobs dispatched!');
    }

    private function dispatchBatch(array $rows)
    {
        foreach ($rows as $row) {
            ProcessCsvRow::dispatch($row)
                ->onQueue('csv_jobs')
                ->delay(now()->addSeconds(1)); // small delay to prevent spikes
        }
    }
}
