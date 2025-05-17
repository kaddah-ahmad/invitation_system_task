<?php

namespace App\Livewire;

use App\Enums\InvitationGroupType;
use App\Mail\SendInvitationMail;
use App\Models\Invitation;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\On;

class SendInvitationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?string $email = '';
    public ?string $groupType = null; // This will be passed to the component
    public bool $showModal = false;

    // This form schema is for the Livewire component's own modal
    // If using Filament Action Modal, this component might not need its own form definition.
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('Email Address'))
                ->email()
                ->required()
                ->unique( // Ensure unique per group type if not already handled by DB constraint
                    table: Invitation::class,
                    column: 'email',
                    ignoreRecord: true // This is for edit, for create we'd have to build query
                )->rule(function () {
                    return Rule::unique('invitations', 'email')
                        ->where('group_type', $this->groupType);
                }),
        ];
    }

    public function mount(?string $initialGroupType = null): void
    {
        if ($initialGroupType) {
            $this->groupType = $initialGroupType;
        }
        // $this->form->fill(); // Initialize form if using Filament Forms trait directly
    }

    #[On('openSendInvitationModal')]
    public function openModal(string $groupType, ?string $prefillEmail = null): void
    {
        $this->groupType = $groupType;
        $this->email = $prefillEmail ?? ''; // Use form state if using Filament form
        // $this->form->fill(['email' => $prefillEmail ?? '']);
        $this->showModal = true;
    }

    public function sendInvitation(): void
    {
        if (!$this->groupType) {
            Notification::make()->title(__('Error: Group type is missing.'))->danger()->send();
            return;
        }

        // If using Filament form, use $this->form->getState()
        // $data = $this->form->getState();
        // For simplicity with public property:
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('invitations', 'email')->where(function ($query) {
                    return $query->where('group_type', $this->groupType);
                }),
            ],
        ]);

        try {
            $invitation = Invitation::create([
                'email' => $this->email,
                'group_type' => InvitationGroupType::from($this->groupType),
                'invited_by' => Auth::id(),
            ]);

            $locale = session('locale', config('app.locale'));
            Mail::to($invitation->email)
                ->locale($locale)
                ->send(new SendInvitationMail($invitation));

            Notification::make()
                ->title(__('messages.invitation_sent_success', ['email' => $invitation->email]))
                ->success()
                ->send();

            $this->closeModal();
            $this->dispatch('invitationSentRefreshTable'); // Dispatch event to refresh table

        } catch (\Exception $e) {
            Log::error('Failed to send invitation: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            Notification::make()
                ->title(__('Error sending invitation. Please try again or check logs.'))
                ->danger()
                ->send();
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('email'); // Reset only email, keep groupType if modal is reused
        // $this->form->fill(); // Reset form state
    }

    public function render()
    {
        // This Livewire component's view will define the modal structure.
        // The Filament Action will trigger this component's 'openModal' event.
        return view('livewire.send-invitation-form');
    }
}
