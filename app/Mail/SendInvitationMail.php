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
        // $surveyLink = route('survey.show', ['token' => $this->invitation->token]);
        $surveyLink = url('/invitation/accept/' . $this->invitation->token);

        $viewName = 'emails.invitations.send';
         if (app()->getLocale() === 'ar' && view()->exists('ar.' . $viewName)) {
             $viewName = 'ar.' . $viewName;
         }

        return new Content(
            markdown: $viewName,
            with: [
                'surveyLink' => $surveyLink,
                'invitation' => $this->invitation,
                'recipientName' => $this->invitation->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
