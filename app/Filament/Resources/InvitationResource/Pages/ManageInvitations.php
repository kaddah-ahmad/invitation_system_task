<?php

namespace App\Filament\Resources\InvitationResource\Pages;

use App\Filament\Export\InvitationExporter;

use App\Filament\Resources\InvitationResource;
use App\Enums\InvitationGroupType;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class ManageInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    protected static ?string $title = 'Evaluation Invitations';

    protected static string $view = 'filament.resources.invitation-resource.pages.manage-invitations';


    protected function getHeaderActions(): array
    {
        $activeGroupType = InvitationGroupType::tryFrom($this->activeTab);

        return [
            Actions\Action::make('sendInvitationInTab')
                ->label(__('Send Invitation'))
                ->icon('heroicon-o-plus-circle')
                ->visible(fn() => $this->activeTab !== null && $activeGroupType !== null)
                ->action(function () {
                    $this->dispatch('openSendInvitationModal', groupType: $this->activeTab);
                }),
            Actions\ExportAction::make('export_current_tab')
                ->label(__('Export Current Group'))
                ->exporter(InvitationExporter::class)
                ->visible(fn() => $this->activeTab !== null && $activeGroupType !== null)
                ->fileName(fn() => strtolower($this->activeTab ?: 'invitations') . '-' . date('Y-m-d') . '.csv')
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];
        foreach (InvitationGroupType::cases() as $group) {
            $tabs[$group->value] = Tab::make($group->getLabel())
                ->icon($group->getIcon())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('group_type', $group->value))
                ->badge(Invitation::query()->where('group_type', $group->value)->count());
        }
        return $tabs;
    }

    #[On('invitationSentRefreshTable')]
    public function refreshTableData(): void
    {
        $this->dispatch('$refresh');
    }

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }
}
