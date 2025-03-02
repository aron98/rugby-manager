<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferResource\Pages;
use App\Filament\Resources\TransferResource\RelationManagers;
use App\Models\Team;
use App\Models\Transfer;
use App\Models\TransferPart;
use App\Models\TransferPartTeam;
use App\TransferType;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransferResource extends Resource
{
    protected static ?string $model = Transfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transfer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('driver')
                    ->maxLength(255),
                Forms\Components\TextInput::make('license_plate')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->maxLength(255),
                Forms\Components\Select::make('transfer_type')
                    ->required()
                    ->options(TransferType::class)
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('transfer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make("route")->label("Route")
                    ->getStateUsing(function (Transfer $model) {
                        return $model->transferParts()->get()->sortBy("begin")->map(function($transferPart){
                            return $transferPart->transferPartTeams()->get()->map(function($tpt){
                                    return $tpt->team()->first()->name;
                                })->join(", ").": ". $transferPart->from()->first()->name.
                                " -> ".$transferPart->to()->first()->name;
                        });
                    })->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('driver')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_type')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('teams')
                ->multiple()
                ->options(Team::all()->pluck('name', 'id'))
                ->query(function(array $data, Builder $query) {
                    $values = collect($data["values"]);
                    if (!$values->isEmpty()) {
                        $goodTransfers = $query->get()->filter(function(Transfer $transfer) use ($values) {
                            return !$values->filter(function ($value) use ($transfer) {
                                return $transfer->teams()->contains($value);
                            })->isEmpty();
                        })->map(function(Transfer $transfer) {
                            return $transfer->id;
                        });
                        $query->whereIn('id', $goodTransfers);
                    }
                })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\TransferPartsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransfers::route('/'),
            'create' => Pages\CreateTransfer::route('/create'),
            'view' => Pages\ViewTransfer::route('/{record}'),
            'edit' => Pages\EditTransfer::route('/{record}/edit'),
        ];
    }
}
