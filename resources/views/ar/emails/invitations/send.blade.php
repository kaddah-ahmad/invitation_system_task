@component('mail::message')
    # {{ __('messages.greeting_email_dear_name', ['name' => $recipientName]) }}

    {{ __('messages.invitation_intro') }}

    @component('mail::button', ['url' => $surveyLink, 'color' => 'primary'])
        {{ __('messages.survey_link_button_text') }}
    @endcomponent

    {{ __('messages.survey_link_text_alternative') }} <br>
    [{{ $surveyLink }}]({{ $surveyLink }})

    {{ __('messages.invitation_note_help', ['support_email' => config('mail.from.address', 'support@example.com')]) }}

    {{ __('messages.regards') }},<br>
    {{ __('messages.it_team') }}
@endcomponent
