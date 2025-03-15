<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTasks extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::latest("id")->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make("title"),
                Tables\Columns\TextColumn::make("status"),
                Tables\Columns\TextColumn::make("user.name"),
                Tables\Columns\TextColumn::make("user.email"),
            ])->paginated(false);
    }
}
