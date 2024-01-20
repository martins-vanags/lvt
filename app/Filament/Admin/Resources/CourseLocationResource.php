<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CourseLocationResource\Pages;
use App\Filament\Admin\Resources\CourseLocationResource\RelationManagers;
use App\Models\CourseLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseLocationResource extends Resource
{
    protected static ?string $model = CourseLocation::class;

    protected static ?string $navigationGroup = 'Course planning';

    protected static ?string $navigationLabel = 'Locations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->maxLength(250)
                    ->string()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Room name')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListCourseLocations::route('/'),
            'create' => Pages\CreateCourseLocation::route('/create'),
            'edit' => Pages\EditCourseLocation::route('/{record}/edit'),
        ];
    }
}
