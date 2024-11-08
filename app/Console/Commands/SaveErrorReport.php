<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\ErrorExport;
use Maatwebsite\Excel\Facades\Excel;

class SaveErrorReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:save-errors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save errors to Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $export = new ErrorExport();
        $fileName = 'errors_' . now()->format('Y_m_d') . '.xlsx';
        Excel::store($export, $fileName);
        $this->info('Error report saved successfully.');
    }
}
