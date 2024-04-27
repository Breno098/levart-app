<?php

namespace App\Filament\Resources;

use App\Enums\TripStatusEnum;
use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Viagem';

    protected static ?string $pluralModelLabel = 'Viagens';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('airline')
                    ->relationship('airline', 'name')
                    ->label("Companhia aérea")
                    ->options(Airline::get()->pluck('name', 'id'))
                    ->live()
                    ->columnSpan('full'),
                
                Select::make('departure_airport_id')
                    ->relationship('departureAirport')
                    ->label("Origem")
                    ->columnSpan('full')
                    ->options(function (Get $get): Collection  {
                        return Airport::query()
                            ->whereHas('airlines', function (Builder $query) use ($get) {
                                $query->where('airlines.id', $get('airline'));
                            })
                            ->get()
                            ->mapWithKeys(fn(Airport $airport) => [
                                $airport->id => "{$airport->iata_code} ({$airport->city}, {$airport->country})"
                            ]);
                    })
                    ->live(),
                DateTimePicker::make('estimated_departure_time')
                    ->label("Data estimada de partida")
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y, H:i'),
                DateTimePicker::make('departure_time')
                    ->label("Data confirmada de partida")
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y, H:i')
                    ->disabled(),
                    Select::make('destination_airport_id')
                    ->relationship('destinationAirport')
                    ->label("Destino")
                    ->columnSpan('full')
                    ->options(function (Get $get): Collection  {
                        return Airport::query()
                            ->whereHas('airlines', function (Builder $query) use ($get) {
                                $query->where('airlines.id', $get('airline'))->whereNot('airports.id', $get('departure_airport_id'));
                            })
                            ->get()
                            ->mapWithKeys(fn(Airport $airport) => [
                                $airport->id => "{$airport->iata_code} ({$airport->city}, {$airport->country})"
                            ]);
                    }),
                DateTimePicker::make('estimated_arrival_time')
                    ->label("Data estimada de chegada")
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y, H:i'),
                DateTimePicker::make('arrival_time')
                    ->label("Data confirmada de chegada")
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y, H:i')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from_city')
                    ->label("Origem")
                    ->description(fn (Trip $trip): string => $trip?->from_country)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('estimated_departure_time')
                    ->label("Partida em")
                    ->formatStateUsing(fn (Carbon|null $state): string => "Estimado: {$state?->format('d/m/Y, H\hi')}")
                    ->description(fn (Trip $trip): ?string => $trip->departure_time ? "Confirmado: {$trip->departure_time?->format('d/m/Y, H\hi')}" : null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('to_city')
                    ->label("Destino")
                    ->description(fn (Trip $trip): string => $trip?->to_country)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('estimated_arrival_time')
                    ->label("Chegada em")
                    ->formatStateUsing(fn (Carbon|null $state): string => "Estimado: {$state?->format('d/m/Y, H\hi')}")
                    ->description(fn (Trip $trip): ?string => $trip->arrival_time ? "Confirmado: {$trip->arrival_time?->format('d/m/Y, H\hi')}" : null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label("Status")
                    ->badge()
                    ->color(fn (TripStatusEnum $state): string => $state->color())
                    ->formatStateUsing(fn (TripStatusEnum $state): string => $state->label())
                    ->icon(fn (TripStatusEnum $state): string => $state->icon())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
