<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class CuratorDailyPOIReport extends Mailable
{
    use Queueable, SerializesModels;

    public $csvOutput;
    public $csvOutput2;

    /**
     * Create a new message instance.
     */
    public function __construct($csvOutput, $csvOutput2)
    {
        $this->csvOutput = $csvOutput;
        $this->csvOutput2 = $csvOutput2;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Curator Daily POI Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.curator-daily-poi-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->csvOutput, 'curator_daily_poi_report.csv')
                ->withMime('text/csv'),
            Attachment::fromData(fn () => $this->csvOutput2, 'poi_data.csv')
                ->withMime('text/csv'),
        ];
    }
}
