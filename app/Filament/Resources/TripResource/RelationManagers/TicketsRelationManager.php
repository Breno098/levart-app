<?php

namespace App\Filament\Resources\TripResource\RelationManagers;

use App\Enums\CountryEnum;
use App\Enums\TicketStatusEnum;
use App\Filament\Resources\PassengerResource;
use App\Models\Passenger;
use App\Models\PaymentMethod;
use App\Models\Ticket;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;

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
        if ($ownerRecord instanceof Trip) {
            return "Passagens de {$ownerRecord->from_city}, {$ownerRecord->from_country} para {$ownerRecord->to_city}, {$ownerRecord->to_country}";
        }

        return 'Passagens';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('from_city')
            ->columns([
                TextColumn::make('ticket_number')
                    ->label("Código"),
                TextColumn::make('purchase_date')
                    ->label("Data de compra")
                    ->date('d/m/Y H:i'),
                TextColumn::make('issue_date')
                    ->label("Emissão")
                    ->date('d/m/Y H:i'),
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
            ->headerActions([
                CreateAction::make('emit_ticket')
                    ->label("Emitir nova passagem")
                    ->form([
                        Repeater::make('ticketPassagens')
                            ->relationship()
                            ->label("Passageiros")
                            ->schema([
                                Select::make('passenger_id')
                                    ->label("Passageiro")
                                    ->relationship('passenger', 'name')
                                    ->options(Passenger::orderBy('name')->get()->pluck('name', 'id'))
                                    ->searchable(['name', 'email', 'identity_document'])
                                    ->createOptionForm(PassengerResource::getForm())
                                    ->required(),

                                Select::make('seat_type')
                                    ->label("Tipo de assento")
                                    ->options([
                                        'economy' => 'Econômico', 
                                        'business' => 'Executivo',
                                        'first_class' => 'Primeira classe'
                                    ])
                                    ->required(),

                                Select::make('seat_number')
                                    ->label("Número de assento")
                                    ->options(range(1, 50))
                                    ->required(),
                            ])
                            ->addActionLabel('Adicionar passageiro'),

                        /** Dados de pagamento */
                        Select::make('payment_method_id')
                            ->label("Forma de pagamento")
                            ->options(PaymentMethod::get()->pluck('name', 'id'))
                            ->required(),
                        Radio::make('currency')
                            ->label("Moeda")
                            ->inline()
                            ->default('EUR')
                            ->options([
                                'EUR' => "Euro (€)",
                                'USD' => "Dólar ($)",
                                'BRL' => "Real (R$)",
                            ])
                            ->required()
                            ->live(),
                        TextInput::make('amount')
                            ->label("Valor")
                            ->prefix(fn (Get $get): string|null => match($get('currency')) {
                                'EUR' => "€",
                                'USD' => "$",
                                'BRL' => "R$",
                                default => null
                            })
                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->required()
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        return [
                            'purchase_date' => now(),
                            'issue_date' => now(),
                            'ticket_status' => TicketStatusEnum::ISSUED,
                            'ticket_number' => rand(1, 500),
                            'booking_code' => rand(1, 500),
                            'amount' => rand(1, 500),
                            'currency' => rand(1, 500),
                            ...$data
                        ];
                    })
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
