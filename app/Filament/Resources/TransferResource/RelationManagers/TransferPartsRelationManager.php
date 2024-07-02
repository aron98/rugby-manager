<?php

namespace App\Filament\Resources\TransferResource\RelationManagers;

use App\Models\Place;
use App\Models\Team;
use App\Models\TransferPart;
use App\Models\TransferPartTeam;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TransferPartsRelationManager extends RelationManager
{
    protected static string $relationship = 'transferParts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make("from")
                    ->label('From')
                    ->options(Place::all()->pluck('name', 'id'))
                    ->preload()->required(),
                Forms\Components\Select::make("to")
                    ->label('To')
                    ->options(Place::all()->pluck('name', 'id'))
                    ->preload()->required(),
                Forms\Components\DateTimePicker::make("begin")
                    ->label('Pickup time')->required(),
                Forms\Components\DateTimePicker::make("end")
                    ->label('Drop off time')->required(),
                Repeater::make('transferPartTeams')
                    ->label('Teams')
                    ->relationship()
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\Select::make("team_id")
                                ->label("Team")
                                ->options(Team::all()->pluck('name', 'id'))
                                ->preload()
                                ->required()
                                ->columnSpan(1),
                            Forms\Components\TextInput::make("number_of_people")
                                ->label("Number of people")
                                ->integer()
                                ->required()
                                ->columnSpan(1)
                        ])
                    ])->columnSpan("full")
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Transfer Part')
            ->columns([
                Tables\Columns\TextColumn::make("from")->label("From")
                    ->getStateUsing(function (TransferPart $model){
                        return $model->from()->first()?->name;
                    }),
                Tables\Columns\TextColumn::make("to")->label("To")
                    ->getStateUsing(function (TransferPart $model){
                        return $model->to()->first()?->name;
                    }),
                Tables\Columns\TextColumn::make("begin")->label("Pickup Time")->dateTime(),
                Tables\Columns\TextColumn::make("end")->label("Drop off time")->dateTime(),
                Tables\Columns\TextColumn::make("teams")->label("Teams")
                    ->getStateUsing(function (TransferPart $model) {
                        return $model->transferPartTeams()->get()->map(function(TransferPartTeam $tpt){
                            return $tpt->team()->first()->name." (".$tpt->number_of_people.")";
                        })->join(', ');
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
