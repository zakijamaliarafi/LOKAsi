<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContributorMonthlyPOIReport extends Mailable
{
    use Queueable, SerializesModels;

    public $csvOutput;
    public $csvOutput2;
    public $dateObj;

    /**
     * Create a new message instance.
     */
    public function __construct($csvOutput, $csvOutput2, $dateObj)
    {
        $this->csvOutput = $csvOutput;
        $this->csvOutput2 = $csvOutput2;
        $this->dateObj = $dateObj->format('M Y');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contributor Monthly POI Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contributor-monthly-poi-report',
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
            Attachment::fromData(fn () => $this->csvOutput, 'Contributor POI Report ' . $this->dateObj . '.csv')
                ->withMime('text/csv'),
            Attachment::fromData(fn () => $this->csvOutput2, 'POI Data Inputted on ' . $this->dateObj . '.csv')
                ->withMime('text/csv'),
        ];
    }
}
