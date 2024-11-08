<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $pathToFile;
    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $date = date('Y.m.d');
        return new Envelope(
            subject: 'Kone jelentés_'.'_'.$date,
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $date = date('Y_m_d');
        return $this->view('emails.report')
            ->subject('Kone jelentés_' . $date)
            ->attach($this->pathToFile, [
                'as' => 'Pandant_hibabejelentés_Új_' . $date . '.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
