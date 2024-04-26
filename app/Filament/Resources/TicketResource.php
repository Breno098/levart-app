<?php

namespace App\Filament\Resources;

use App\Enums\TicketStatusEnum;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Passagem';

    protected static ?string $pluralModelLabel = 'Passagens';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                ->label("Código"),
                TextColumn::make('purchase_date')
                    ->label("Data de compra")
                    ->date('d/m/Y H:i'),
                TextColumn::make('issue_date')
                    ->label("Emissão")
                    ->date('d/m/Y H:i'),
                TextColumn::make('from_city')
                    ->label("Origem")
                    ->description(fn (Ticket $ticket): string => $ticket?->from_country),
                TextColumn::make('to_city')
                    ->label("Destino")
                    ->description(fn (Ticket $ticket): string => $ticket?->to_country),
                TextColumn::make('ticket_status')
                    ->label("Código"),
                TextColumn::make('ticket_status')
                    ->label("Status")
                    ->badge()
                    ->color(fn (TicketStatusEnum $state): string => $state->color())
                    ->formatStateUsing(fn (TicketStatusEnum $state): string => $state->label())
                    ->icon(fn (TicketStatusEnum $state): string => $state->icon())
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('cancel')
                        ->label("Cancelar")
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->hidden(fn (Ticket $ticket) => $ticket->can_cancel)
                        ->action(fn (Ticket $ticket) => $ticket->cancel()),
                ])->tooltip('Ações')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
