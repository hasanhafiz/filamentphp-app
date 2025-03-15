<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $records = User::withSum('tasks', 'amount')
        ->get();

    return $records;

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
