<?php

namespace App\Filament\Export;

use App\Models\Invitation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class InvitationExporter extends Exporter
{
    protected static ?string $model = Invitation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('email')->label(__('Email')),
            ExportColumn::make('group_type')
                ->label(__('Group Type'))
                ->formatStateUsing(fn ($state) => $state instanceof \App\Enums\InvitationGroupType ? $state->getLabel() : $state),
            ExportColumn::make('status')
                ->label(__('Status'))
                ->formatStateUsing(fn ($state) => $state instanceof \App\Enums\InvitationStatus ? $state->getLabel() : $state),
            ExportColumn::make('token')->label('Token'),
            ExportColumn::make('inviter.name')->label(__('Invited By')),
            ExportColumn::make('acceptedUser.name')->label(__('Accepted User Name')),
            ExportColumn::make('created_at')->label(__('Sent At')),
            ExportColumn::make('accepted_at')->label(__('Accepted At')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = __('Your invitation export is complete and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.');

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
