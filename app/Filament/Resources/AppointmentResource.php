<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\AppointmentStatus;


class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([

                    Forms\Components\Select::make('pet_id')
                        ->relationship('pet', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('description'),

                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->native(false),
                        
                    Forms\Components\TimePicker::make('start')
                        ->required()
                        ->seconds(false)
                        ->displayFormat('h:i A')
                        ->minutesStep(10),
                        

                    Forms\Components\TimePicker::make('end')
                        ->required()
                        ->seconds(false)
                        ->displayFormat('h:i A')
                        ->minutesStep(10),


                        

                    
                ])
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start')
                    ->time('h:i A')
                    ->label('From')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end')
                    ->time('h:i A')
                    ->label('To')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Confirm')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Confirmed;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status == AppointmentStatus::Pending)
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Canceled;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status != AppointmentStatus::Canceled)
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }    
}
