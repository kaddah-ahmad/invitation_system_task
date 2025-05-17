<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Invitation $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.invitation_email_subject'),
        );
    }

    public function content(): Content
    {
        // Replace with your actual survey link generation logic
        // $surveyLink = route('survey.show', ['token' => $this->invitation->token]);
        $surveyLink = url('/invitation/accept/' . $this->invitation->token); // Example placeholder

        // Determine view based on locale if Mail::locale() isn't sufficient or for very different structures
        $viewName = 'emails.invitations.send';
        // if (app()->getLocale() === 'ar' && view()->exists('ar.' . $viewName)) {
        //     $viewName = 'ar.' . $viewName;
        // }
        // Note: Mail::locale($locale) should handle view path resolution to resources/views/{locale}/...

        return new Content(
            markdown: $viewName,
            with: [
                'surveyLink' => $surveyLink,
                'invitation' => $this->invitation,
                'recipientName' => $this->invitation->email, // Or a name if you collect it
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
