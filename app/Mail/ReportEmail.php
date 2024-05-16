<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $report;
    protected $events;
    protected $callCenterReport;
    public function __construct($report, $events, $callCenterReport)
    {
        $this->report = $report;
        $this->events = $events;
        $this->callCenterReport = $callCenterReport;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $date = date('Y.m.d');
        return new Envelope(
            subject: 'Fődiszpécser Napi üzemviteli jelentés '.$date,
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $date = date('Y_m_d');
        return $this->view('emails.daily-report')
            ->with([
                'report' => $this->report,
                'events' => $this->events,
                'callCenterReport' => $this->callCenterReport,
            ])
            ->subject('Fődiszpécser Napi üzemviteli jelentés ' . $date);

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
