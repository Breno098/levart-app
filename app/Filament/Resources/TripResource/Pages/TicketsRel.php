<?php

namespace App\Filament\Resources\TripResource\Pages;

use App\Enums\TripStatusEnum;
use App\Filament\Resources\TripResource;
use App\Models\Trip;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class TicketsRel extends ManageRelatedRecords
{
    use InteractsWithRecord;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected static string $resource = TripResource::class;

    protected static string $relationship = 'tickets';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Passagens';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tickets')
            ->columns([
                // TextColumn::make('from_city')
                //     ->label("Origem")
                //     ->description(fn (Trip $trip): string => $trip?->from_country)
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('estimated_departure_time')
                //     ->label("Partida em")
                //     ->formatStateUsing(fn (Carbon|null $state): string => "Estimado: {$state?->format('d/m/Y, H\hi')}")
                //     ->description(fn (Trip $trip): ?string => $trip->departure_time ? "Confirmado: {$trip->departure_time?->format('d/m/Y, H\hi')}" : null)
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('to_city')
                //     ->label("Destino")
                //     ->description(fn (Trip $trip): string => $trip?->to_country)
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('estimated_arrival_time')
                //     ->label("Chegada em")
                //     ->formatStateUsing(fn (Carbon|null $state): string => "Estimado: {$state?->format('d/m/Y, H\hi')}")
                //     ->description(fn (Trip $trip): ?string => $trip->arrival_time ? "Confirmado: {$trip->arrival_time?->format('d/m/Y, H\hi')}" : null)
                //     ->searchable()
                //     ->sortable(),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
