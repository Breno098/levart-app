<?php

namespace App\Filament\Resources\TripResource\Pages;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\TicketStatusEnum;
use App\Filament\Resources\PassengerResource;
use App\Filament\Resources\TripResource;
use App\Models\Passenger;
use App\Models\Ticket;
use App\Models\Trip;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ManageTickets extends ManageRelatedRecords
{
    use InteractsWithRecord;

    protected static string $resource = TripResource::class;

    protected static string $relationship = 'tickets';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return 'Passagens';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        if ($this->record instanceof Trip) {
            return "Passagens de {$this->record->from_city}, {$this->record->from_country} para {$this->record->to_city}, {$this->record->to_country}";
        }

        return 'Passagens';
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                            ->required()
                            ->columnSpan('full'),

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
                    ->addActionLabel('Adicionar passageiro')
                    ->columnSpan('full'),

                /** Dados de pagamento */
                Select::make('payment_method')
                    ->label("Forma de pagamento")
                    ->options(PaymentMethodEnum::toValuesWithLabels())
                    ->required()
                    ->columnSpan('full'),
                Radio::make('currency')
                    ->label("Moeda")
                    ->inline()
                    ->default(CurrencyEnum::EUR)
                    ->options(CurrencyEnum::toValuesWithLabels())
                    ->required()
                    ->live()
                    ->columnSpan('full'),
                TextInput::make('amount')
                    ->label("Valor")
                    ->prefix(function (Get $get): string|null {
                        $currency = $get('currency');

                        if ($currency instanceof CurrencyEnum) {
                            return $get('currency')?->signal();
                        }

                        return null;
                    })
                    ->mask(RawJs::make('$money($input)'))
                    ->numeric()
                    ->required()
                    ->columnSpan('full')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
                Tables\Actions\CreateAction::make()->label("Emitir passagem"),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('cancel')
                    ->label("Cancelar")
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn (Ticket $ticket) => $ticket->can_cancel)
                    ->action(fn (Ticket $ticket) => $ticket->cancel())
            ])
            ->bulkActions([
            ]);
    }
}
