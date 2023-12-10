<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Exception;

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
        $maxAttempts = 5;
        $attempts = 0;
        $success = false;
        $date = date('Y_m_d');

        while (!$success && $attempts < $maxAttempts) {
            try {
                Mail::to(['Nikolett.Beniczky@KONE.com', 'krisztian.eszenszky@kone.com', 'csaba.hegedus@kone.com', 'csilla.perenyi@kone.com', 'richard.kovacshegedus@kone.com', 'csaba.szereto@kone.com'])
                    ->bcc(['feher.peter@pandant.hu', 'smitpeter777@gmail.com'])
                    ->send(new TestEmail(storage_path('app/errors_'.$date.'.xlsx')));

                $success = true;
                $this->info('Error report email sent successfully.');
            } catch (Exception $e) {
                $attempts++;
                sleep(5); // Várakozás a következő próbálkozás előtt
            }
        }

        if (!$success) {
            $this->error('Failed to send error report email after ' . $maxAttempts . ' attempts.');
        }
    }
}
