<?php

use App\Tag;
use App\Task;
use App\User;
if (!function_exists('create_primary_user')) {
    function create_primary_user() {
        $user = User::where('email', 'sergiturbadenas@gmail.com')->first();
        if (!$user) {
            User::firstOrCreate([
                'name' => 'Benjamin Zaragoza Pla',
                'email' => 'benjaminzaragoza@iesebre.com',
                'password' => bcrypt(env('PRIMARY_USER_PASSWORD','123456'))
            ]);
        }
    }
}

if (!function_exists('create_example_tasks')) {
    function create_example_tasks() {
        Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);
        Task::create([
            'name' => 'comprar llet',
            'completed' => false
        ]);
        Task::create([
            'name' => 'Estudiar PHP',
            'completed' => true
        ]);
    }
}
if (!function_exists('create_example_tags')) {
    function create_example_tags() {
        Tag::create([
            'name' => 'comprar pa',
            'description'=>'hola que tal',
            'color'=>'blau'
        ]);
        Tag::create([
            'name' => 'comprar llet',
            'description'=>'hola que mal',
            'color'=>'verd'
        ]);
        Tag::create([
            'name' => 'Estudiar PHP',
            'description'=>'hola que fatal',
            'color'=>'roig'
        ]);
    }
}