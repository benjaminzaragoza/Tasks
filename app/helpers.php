<?php

use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\DB;

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
if(!function_exists('create_mysql_database')){
    function create_mysql_database($name){
        //PDO
        //MYSQL: create database if not exists $name
        $statement="CREATE DATABASE IF NOT EXISTS $name";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
    }
}
if(!function_exists('drop_mysql_database')){
    function drop_mysql_database($name){
        //PDO
        //MYSQL: create database if not exists $name
        $statement="DROP DATABASE IF NOT EXISTS $name";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
    }
}
if(!function_exists('create_mysql_user')){
    function create_mysql_user($name,$password=null,$host='localhost'){
        if(!$password)$password=str_random();
        $statement="CREATE USER IF NOT EXISTS {$name}@{$host}";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
        $statement="ALTER USER '{$name}'@'{$host}' IDENTIFIED BY '{$password}'";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
        return $password;
    }
}
if (!function_exists('grant_mysql_privileges')) {
    function grant_mysql_privileges($user,$database,$host = 'localhost')
    {
        $statement = "GRANT ALL PRIVILEGES ON {$database}.* TO '{$user}'@'{$host}' WITH GRANT OPTION";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
        $statement = "FLUSH PRIVILEGES";
        DB::connection('mysqlroot')->getPdo()->exec($statement);
    }
}
if(!function_exists('create_database')){
    function create_database()
    {
        create_mysql_database(env('DB_DATABASE'));
        create_mysql_user(env('DB_USERNAME'),env('DB_PASSWORD'));
        create_mysql_privileges(env('DB_USERNAME'),env('DB_DATABASE'));
    }
}