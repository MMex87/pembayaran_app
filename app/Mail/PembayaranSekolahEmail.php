<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class PembayaranSekolahEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfAttachmentPath;
    public $receiverName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pdfAttachmentPath, $receiverName)
    {
        $this->data = $data;
        $this->pdfAttachmentPath = $pdfAttachmentPath;
        $this->receiverName = $receiverName;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromPath($this->pdfAttachmentPath)
                ->as($this->data['namaSiswa'].'.pdf')
                ->withMime('application/pdf'),
        ];
    }

    public function build()
    {
        return $this->subject('Pembayaran Sekolah - ' . $this->data['namaSiswa'])
                    ->view('emails.pembayaran_sekolah');
    }

}