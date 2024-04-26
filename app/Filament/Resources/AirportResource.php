<?php

namespace App\Filament\Resources;

use App\Enums\CountryEnum;
use App\Filament\Resources\AirportResource\Pages;
use App\Filament\Resources\AirportResource\RelationManagers;
use App\Models\Airline;
use App\Models\Airport;
use Filament\Forms;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AirportResource extends Resource
{
    protected static ?string $model = Airport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Aeroporto';

    protected static ?string $pluralModelLabel = 'Aeroportos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->maxLength(100)
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('iata_code')
                    ->label('Código IATA')
                    ->required()
                    ->mask('aaa')
                    ->length(3),
                TextInput::make('icao_code')
                    ->label('Código ICAO')
                    ->required()
                    ->mask('aaaa')
                    ->length(4),
                Select::make('airlines')
                    ->relationship('airlines')
                    ->label("Companhias aeréas atendidas")
                    ->multiple()
                    ->getSearchResultsUsing(fn (string $search): array => Airline::where('name', 'like', "%{$search}%")->pluck('name', 'id')->toArray())
                    ->getOptionLabelsUsing(fn (array $values): array => Airline::whereIn('id', $values)->pluck('name', 'id')->toArray())
                    ->columnSpan('full'),
                Section::make('Localização')
                    ->schema([
                        Select::make('country')
                            ->label("País")
                            ->options(CountryEnum::toValuesWithLabels())
                            ->native(false)
                            ->searchable(),
                        TextInput::make('city')
                            ->label('Cidade')
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('postal_code')
                            ->label('Código Postal')
                            ->maxLength(10)
                            ->required(),
                    ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label("Nome")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('iata_code')
                    ->label("Código IATA")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('icao_code')
                    ->label("Código ICAO")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->label("Cidade")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country')
                    ->label("País")
                    ->searchable()
                    ->sortable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->tooltip('Ações')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
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
            'index' => Pages\ListAirports::route('/'),
            'create' => Pages\CreateAirport::route('/create'),
            'edit' => Pages\EditAirport::route('/{record}/edit'),
        ];
    }
}
