<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;

Route::get('/', function () {

    $records = Task::select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    return $records;

    // $records = User::withSum('tasks', 'amount')
    //     ->get();



    // return $records;

    // $records = User::withCount([
    //     'tasks',
    //     'tasks as completed_tasks_count' => function (Builder $query) {
    //         $query->where('status', 'completed');
    //     },
    //     'tasks as pending_tasks_count' => function (Builder $query) {
    //         $query->where('status', 'pending');
    //     }
    // ])->get();
    // return $records;
    // return view('welcome');
});
