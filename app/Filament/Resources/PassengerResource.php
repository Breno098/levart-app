<?php

namespace App\Filament\Resources;

use App\Enums\CountryEnum;
use App\Filament\Resources\PassengerResource\Pages;
use App\Filament\Resources\PassengerResource\RelationManagers;
use App\Filament\Resources\PassengerResource\RelationManagers\TicketsRelationManager;
use App\Helpers\DataHelper;
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

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Passageiro';

    protected static ?string $pluralModelLabel = 'Passageiros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...self::getForm()
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
                TextColumn::make('identity_document')
                    ->label('Documento')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('identity_document', 'like', "{$search}%");
                    })
                    ->limit(6, '***'),
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
                    ->label('Contatos')
                    ->description(fn (Passenger $record): string => $record->phone)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('phone', 'like', "{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    }),
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
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            TicketsRelationManager::class
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

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('Nome')
                ->required(),
            TextInput::make('phone')
                ->label('Telefone')
                ->tel()
                ->required(),
            DateTimePicker::make('date_of_birth')
                ->label('Data de Nascimento')
                ->displayFormat('d/m/Y')
                ->native(false)
                ->time(false)
                ->minDate(now()->subYears(150))
                ->maxDate(now())
                ->closeOnDateSelection()
                ->required(),
            Select::make('gender')
                ->label('Gênero')
                ->options([
                    'male' => 'Masculino',
                    'female' => 'Feminino',
                    'other' => 'Outro'
                ])
                ->required(),
            TextInput::make('identity_document')
                ->label('Documento de Identificação')
                ->required()
                ->disabledOn('edit'),
            TextInput::make('email')
                ->label('E-mail')
                ->required()
                ->email(),
            Select::make('nationality')
                ->label('Nacionalidade')
                ->options(CountryEnum::toValuesWithLabels())
                ->required(),
        ];
    }
}
