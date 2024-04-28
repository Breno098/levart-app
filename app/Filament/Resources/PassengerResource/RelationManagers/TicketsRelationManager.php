<?php

namespace App\Filament\Resources\PassengerResource\RelationManagers;

use App\Enums\TicketStatusEnum;
use App\Models\Location;
use App\Models\Passenger;
use App\Models\Ticket;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    /**
     * @param Model $ownerRecord
     * @param string $pageClass
     * @return string
     */
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        if ($ownerRecord instanceof Passenger) {
            return "Passagens de {$ownerRecord->name}";
        }

        return 'Passagens';
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tickets_info')
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
            ])
            ->actions([
                Action::make('cancel')
                    ->label("Cancelar")
                    ->requiresConfirmation()
                    ->hidden(fn (Ticket $ticket) => $ticket->can_cancel)
                    ->action(fn (Ticket $ticket) => $ticket->cancel())
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
