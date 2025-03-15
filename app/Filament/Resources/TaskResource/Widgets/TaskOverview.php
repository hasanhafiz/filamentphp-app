<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use App\Filament\Resources\TaskResource;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TaskOverview extends BaseWidget
{
    protected static ?string $pollingInterval = "10s";
    protected function getStats(): array
    {
        return [
            Stat::make('Total Task', Task::count()),
            Stat::make('Pending Task', Task::pending()->count()),
            Stat::make('Completed Task', Task::completed()->count()),
            Stat::make('Canceled Task', Task::canceled()->count()),
        ];
    }

    public static function getWidgets(): array
    {
        return [TaskResource\Widgets\TaskOverview::class];
    }
}
