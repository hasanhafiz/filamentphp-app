<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $laravelCategories = [
            'Core Concepts',
            'Database & Eloquent',
            'Authentication & Authorization',
            'Blade & Frontend',
            'API Development',
            'Testing & Debugging',
            'Performance & Optimization',
            'Deployment & DevOps',
        ];

        // 1: loop
        foreach ($laravelCategories as $cat) {
            Category::create(['name' => $cat]);
        }
        // 2: 


        // Way 1
        // User::factory(10)->create();
        // Task::factory(10)->create();

        // Toal 7 ways

        // Way 2:
        // User::factory()
        // ->count(10)
        // ->create()
        // ->each(  function (User $user) {
        //     Task::factory()
        //     ->count(  3  )
        //     ->create([
        //         'title' => 'Task Title for User: ' . $user->id,
        //         'user_id' => $user->id
        //     ]);
        // });

        // Way 3 
        // User::factory()
        // ->count(10)
        // ->has( Task::factory()->count(3) )
        // ->create();  


        // Way 4 
        // User::factory()
        // ->count(10)
        // ->hasTasks(5, [
        //     'status' => 'pending'
        // ])
        // ->create();

        // Way 5 
        User::factory()
            ->count(10)
            ->hasTasks(3, function (array $attributes, User $user) {
                return [
                    'title' => 'Task title ' . $user->id,
                    'created_at' => now()->subDays(2),
                ];
            })
            ->state(new Sequence(
                ['is_admin' => 1],
                ['is_admin' => 0],
            ))
            ->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
