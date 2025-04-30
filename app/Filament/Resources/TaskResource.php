<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Task;
use App\Models\User;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use App\Enums\TaskStatusEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TaskResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TaskResource\RelationManagers;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->label('Select User')
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->native(false)
                    ->required()
                    ->label('Select Category')
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                    ]),
                // ->options(Category::pluck('name', 'id')),
                Forms\Components\TextInput::make('description'),
                Forms\Components\Select::make('status')
                    ->options(TaskStatusEnum::class)

            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'DESC')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('SL#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('completion_date')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User Email')
            ])
            ->filters([
                Tables\Filters\Filter::make('title')
                    ->form([
                        Forms\Components\TextInput::make('title')
                    ])
                    ->query(function (Builder $query, array $data) {
                        // dd($data);
                        // dd($query);
                        return $query->where('title', 'LIKE', '%' . $data['title'] . '%');
                    }),
                Tables\Filters\SelectFilter::make('status')
                    ->options(TaskStatusEnum::class)
                    ->label('Task Status')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('user_id')
                    ->options(User::orderBy('name', 'ASC')->pluck('name', 'id'))
                    // ->relationship('user', 'name')
                    ->label('User'),
                Tables\Filters\Filter::make('completed_from')
                    ->form([
                        Forms\Components\DatePicker::make('completed_from'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query
                            ->when(
                                $data['completed_from'],
                                function (Builder $query, $date) {
                                    return $query->whereDate('completion_date', '>=', $date);
                                }
                            );
                        //return $query->where('title', 'LIKE', '%' . $data['title'] . '%');
                    }),
                Tables\Filters\Filter::make('completed_until')
                    ->form([
                        Forms\Components\DatePicker::make('completed_until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query
                            ->when(
                                $data['completed_until'],
                                function (Builder $query, $date) {
                                    return $query->whereDate('completion_date', '<=', $date);
                                }
                            );
                        //return $query->where('title', 'LIKE', '%' . $data['title'] . '%');
                    }),
            ], FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
