<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Models\Task;
use Filament\Actions;
use App\Enums\TaskStatusEnum;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected static string $view = 'filament.resources.tasks.pages.list-tasks';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                // ->label(self::tabLabel('All', 'all'))
                ->badge(Task::count())
            ,
            'pending' => Tab::make()
                // ->label(self::tabLabel('Pending', 'pending'))
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('status', TaskStatusEnum::PENDING);
                })
                ->badge(Task::pending()->count())
                ->badgeColor('warning'),
            'canceled' => Tab::make()
                // ->label(self::tabLabel('Canceled', 'canceled'))
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('status', TaskStatusEnum::CANCELED);
                })
                ->badge(Task::canceled()->count())
                ->badgeColor('danger'),
            'completed' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->where('status', TaskStatusEnum::COMPLETED);
                })
                ->badge(Task::completed()->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check')
                ->iconPosition(IconPosition::Before)
        ];

    }

    protected static function tabLabel(string $label, string $tab)
    {
        // This will not work, since first time it is okay. but in the next time, since ajax call happened
        // this function will not be execucated!
        $activeTab = request()->input('activeTab', 'all');

        dump(request()->input());

        if ($activeTab == $tab) {
            return '✅ ' . $label;
        }
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TaskResource\Widgets\TaskOverview::class,
        ];
    }
}
