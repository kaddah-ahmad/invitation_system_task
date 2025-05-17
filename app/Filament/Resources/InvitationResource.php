<?php

namespace App\Filament\Resources;

use App\Enums\InvitationStatus;
use App\Filament\Resources\InvitationResource\Pages;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationGroup = 'User Management'; // As per task image hint

    protected static ?string $slug = 'evaluation-invitations';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('group_type')
                    ->options(\App\Enums\InvitationGroupType::class)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(\App\Enums\InvitationStatus::class)
                    ->default(InvitationStatus::SENT)
                    ->required(),
                Forms\Components\TextInput::make('token')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Make sure token is unique
                Forms\Components\Select::make('invited_by')
                    ->relationship('inviter', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\DateTimePicker::make('accepted_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inviter.name')
                    ->label(__('Invited By'))
                    ->sortable()
                    ->placeholder(__('N/A')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Sent At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('accepted_at')
                    ->label(__('Accepted At'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__('Not Accepted Yet'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(InvitationStatus::class),
            ])
            ->actions([
                Tables\Actions\Action::make('resend')
                    ->label(__('Resend'))
                    ->icon('heroicon-m-paper-airplane')
                    ->requiresConfirmation()
                    ->action(function (Invitation $record) {
                        $locale = session('locale', config('app.locale'));
                        Mail::to($record->email)
                            ->locale($locale)
                            ->send(new \App\Mail\SendInvitationEmail($record));

                        \Filament\Notifications\Notification::make()
                            ->title(__('messages.invitation_resent_success', ['email' => $record->email]))
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading(__('There is no invitation yet.'))
            ->emptyStateDescription(__('Use the button to complete invitations for this group.'))
            ->emptyStateIcon('heroicon-o-envelope-open');
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInvitations::route('/'),
        ];
    }
}
