<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class SendErrorReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-error-reports';

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
        $date = date('Y_m_d');
        Mail::to('smitpeter777@gmail.com')
            ->send(new TestEmail(storage_path('app/errors_'.$date.'.xlsx')));

        $this->info('Error report email sent successfully.');
    }
}
