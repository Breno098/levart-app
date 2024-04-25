<?php

namespace App\Filament\Resources\PessengerResource\RelationManagers;

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
                TextColumn::make('flight.departureAirport.location.city')
                    ->label("Origem")
                    ->description(fn (Ticket $ticket): string => $ticket?->flight?->departureAirport?->location?->country),
                TextColumn::make('flight.destinationAirport.location.city')
                    ->label("Destino")
                    ->description(fn (Ticket $ticket): string => $ticket?->flight?->departureAirport?->location?->country),
                TextColumn::make('ticket_status')
                    ->label("Código"),
                TextColumn::make('ticket_status')
                    ->label("Status")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'issued' => 'gray',
                        'used' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'issued' => 'Emitida',
                        'used' => 'Utilizada',
                        'cancelled' => 'Cancelado',
                    }),
            ])
            ->filters([
            ])
            ->actions([
                Action::make('cancel')
                    ->label("Cancelar")
                    ->requiresConfirmation()
                    ->hidden(fn (Ticket $ticket) => $ticket->ticket_status !== 'issued')
                    ->action(fn (Ticket $ticket) => $ticket->update([
                        'ticket_status' => 'cancelled'
                    ]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
