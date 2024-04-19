<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PassengerResource\Pages;
use App\Filament\Resources\PassengerResource\RelationManagers;
use App\Models\Passenger;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassengerResource extends Resource
{
    protected static ?string $model = Passenger::class;

    public static $icon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Passageiro';

    protected static ?string $pluralModelLabel = 'Passageiros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('phone')
                    ->label('Telefone')
                    ->required(),
                DateTimePicker::make('date_of_birth')
                    ->label('Data de Nascimento')
                    ->displayFormat('d/m/Y')
                    ->native(false)
                    ->required(),
                Select::make('gender')
                    ->label('Gênero')
                    ->options([
                        'male' => 'Masculino',
                        'female' => 'Feminino',
                        'other' => 'Outro'
                    ])
                    ->required(),
                TextInput::make('identification_document')
                    ->label('Documento de Identificação')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->required()
                    ->email(),
                TextInput::make('nationality')
                    ->label('Nacionalidade')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date_of_birth')
                    ->label('Data de Nascimento')
                    ->date('d/m/Y'),
                TextColumn::make('gender')
                    ->label('Gênero')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'male' => 'Masculino',
                        'female' => 'Feminino',
                        default => 'Outro'
                    }),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
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
            'index' => Pages\ListPassengers::route('/'),
            'create' => Pages\CreatePassenger::route('/create'),
            'edit' => Pages\EditPassenger::route('/{record}/edit'),
        ];
    }
}
