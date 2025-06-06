<?php

namespace App\Filament\Widgets;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TaskOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';
    // Never refresh widgets
    // protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Task', Task::count())
                ->description('Total number of Task'),
            Stat::make('Completed Task Count', Task::completed()->count())
                ->description(TaskStatusEnum::COMPLETED->getDescription()),
            Stat::make('Pending  Count', Task::pending()->count()),
            Stat::make('Canceled  Count', Task::canceled()->count())
                ->description(TaskStatusEnum::CANCELED->getDescription()),
        ];
    }
}
