<?php

use App\Models\Channel;
use App\Notifications\SimpleNotification;
use App\Tag;
use Carbon\Carbon;
use App\Log;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('chat_permissions')) {
    function chat_permissions()
    {
        return [
            'chat.index',
        ];
    }
}
if (! function_exists('get_admin_user')) {
    function get_admin_user() {
        return User::where('email',config('tasks.admin_user_email_on_tenant'))->first();
    }
}
if (! function_exists('add_random_timestamps')) {
    function add_random_timestamps($array)
    {
        return array_merge($array,get_random_timestamps());
    }
}
if (! function_exists('get_random_timestamps')) {
    function get_random_timestamps($backwardDays = null)
    {

        if ( is_null($backwardDays) )
        {
            $backwardDays = -800;
        }

        $backwardCreatedDays = rand($backwardDays, 0);
        $backwardUpdatedDays = rand($backwardCreatedDays + 1, 0);

        return [
            'created_at' => \Carbon\Carbon::now()->addDays($backwardCreatedDays)->addMinutes(rand(0,
                60 * 23))->addSeconds(rand(0, 60)),
            'updated_at' => \Carbon\Carbon::now()->addDays($backwardUpdatedDays)->addMinutes(rand(0,
                60 * 23))->addSeconds(rand(0, 60))
        ];
    }
}
if (! function_exists('create_admin_user')) {
    /**
     *
     */
    function create_admin_user()
    {
        if (! App\User::where('email',config('tasks.admin_user_email'))->first()) {
            App\User::forceCreate([
                'name' => config('tasks.admin_user_name'),
                'email' => config('tasks.admin_user_email'),
                'password' => bcrypt(config('tasks.admin_user_password')),
                'admin' => true
            ]);
        }
    }
}
if (! function_exists('tenant_connect')) {
    /**
     * Establish a tenant database connection.
     *
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     */
    function tenant_connect($hostname, $username, $password, $database)
    {
        // Erase the tenant connection, thus making Laravel get the default values all over again.
        DB::purge('tenant');

        // Make sure to use the database name we want to establish a connection.
        Config::set('database.connections.tenant.host', $hostname);
        Config::set('database.connections.tenant.database', $database);
        Config::set('database.connections.tenant.username', $username);
        Config::set('database.connections.tenant.password', $password);

        // Rearrange the connection data
        DB::reconnect('tenant');

        // Ping the database. This will throw an exception in case the database does not exists.
        Schema::connection('tenant')->getConnection()->reconnect();
    }
}
if (! function_exists('create_admin_user')) {
    /**
     * @param $user
     * @param $tenant
     */
    function create_admin_user_on_tenant($user, $tenant, $password = null)
    {
        tenant_connect(
            $tenant->hostname,
            $tenant->username,
            $tenant->password,
            $tenant->database
        );

        if(!$password) $password = Str::random();

        $existingUser = App\User::where('email',$user->email)->first();
        if (!$existingUser) {
            User::forceCreate([
                'name' => $user->name,
                'email' => $user->email,
                'password' => sha1($password),
                'admin' => true
            ]);
        }
        DB::purge('tenant');
    }
}
if (! function_exists('initialize_sample_chat_channels')) {
    function initialize_sample_chat_channels($user = null)	{
        create_admin_user();
        if(!$user) $user = get_admin_user();
        Channel::create(add_random_timestamps([
            'name' => 'Pepe Pardo Jeans',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Bla bla bla'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Pepa Parda Jeans',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Carles Puigdemont',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Sant Esteve de les Roures',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 1',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 2',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 3',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 4',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 5',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 6',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 7',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 8',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 9',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 10',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 11',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 12',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 13',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 14',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 15',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 16',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 17',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 18',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 19',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
        Channel::create(add_random_timestamps([
            'name' => 'Channel 20',
            'image' => 'http://i.pravatar.cc/300',
            'last_message' => 'Hey que tal...'
        ]))->addUser($user);
    }
}
if (!function_exists('create_primary_user')) {
    function create_primary_user() {
        $user = User::where('email', 'benjaminzaragoza@iesebre.com')->first();
        if (!$user) {
           $user= User::firstOrCreate([
                'name' => 'Benjamin Zaragoza Pla',
                'email' => 'benjaminzaragoza@iesebre.com',
                'password' => bcrypt(env('PRIMARY_USER_PASSWORD','123456'))
            ]);
            $user->admin=true;
           $user->save();
        }
        Task::create([
            'name' => 'Tasca Benja',
            'completed' => true,
            'description' => 'Benja tasca',
            'user_id' => $user->id
        ]);
    }
}

if (!function_exists('create_example_tasks')) {
    function create_example_tasks() {
        $user1=factory(User::class)->create();
        Task::create([
            'name' => 'comprar pa',
            'completed' => false,
            'description'=>'hola paco',
            'user_id' => $user1->id
        ]);
        Task::create([
            'name' => 'comprar llet',
            'completed' => false,
            'description'=>'hola feo',
            'user_id' => $user1->id
        ]);
        Task::create([
            'name' => 'Estudiar PHP',
            'completed' => true,
            'description'=>'hola guapo',
            'user_id' => $user1->id
        ]);
    }
}
if (! function_exists('create_sample_task')) {
    function create_sample_task($user)
    {
        $task = Task::create([
            'name' => 'Comprar pa',
            'description' => 'Bla bla bla',
            'completed' => false,
        ]);
        $task->assignUser($user);
        $tag1 = Tag::create([
            'name' => 'Tag1',
            'color' => 'blue',
            'description' => 'bla bla bla'
        ]);
        $tag2 = Tag::create([
            'name' => 'Tag2',
            'color' => 'red',
            'description' => 'Jorl Jorl'
        ]);
        $task->addTag($tag1);
        $task->addTag($tag2);
        return $task;
    }
}
if (! function_exists('ellipsis')) {
    function ellipsis($text,$max=50)
    {
        $ellipted = strlen($text) > $max ? substr($text,0,$max)."..." : $text;
        return $ellipted;
    }
}
if (! function_exists('sample_logs')) {
    function sample_logs()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $task = Task::create([
            'name' => 'Comprar pa',
        ]);
        $task->assignUser($user1);
        $log1 = Log::create([
            'text' => 'Ha creat la tasca TODO_LINK_TASCA',
            'time' => Carbon::now(),
            'action_type' => 'store',
            'module_type' => 'Tasks',
            'loggable_id' => $task->id,
            'loggable_type' => Task::class,
            'user_id' => $user1->id,
            'icon' => 'home',
            'color' => 'teal'
        ]);
        $log2 = Log::create([
            'text' => 'Ha modificat la tasca TODO_LINK_TASCA',
            'time' => Carbon::now(),
            'action_type' => 'update',
            'module_type' => 'Tasks',
            'loggable_id' => 1,
            'loggable_type' => Task::class,
            'user_id' => $user2->id,
            'icon' => 'home',
            'color' => 'teal'
        ]);
        $log3 = Log::create([
            'text' => 'Ha modificat la tasca TODO_LINK_TASCA',
            'time' => Carbon::now(),
            'action_type' => 'update',
            'module_type' => 'Tasks',
            'loggable_id' => 1,
            'loggable_type' => Task::class,
            'user_id' => $user2->id,
            'icon' => 'home',
            'color' => 'teal'
        ]);
        $log4 = Log::create([
            'text' => 'BLA BLA BLA',
            'time' => Carbon::now(),
            'action_type' => 'update',
            'module_type' => 'OtherModule',
            'loggable_id' => 1,
            'loggable_type' => User::class,
            'user_id' => $user2->id,
            'icon' => 'home',
            'color' => 'teal'
        ]);
        return [$log1,$log2,$log3,$log4];
    }
}
if (!function_exists('create_example_tasks_with_tags')) {
    function create_example_tasks_with_tags() {
        $user1= factory(User::class)->create();
        Task::create([
            'name' => 'comprar pa',
            'completed' => false,
            'description' => 'Bla bla bla',
            'user_id' => $user1->id
        ]);
        Task::create([
            'name' => 'comprar llet',
            'completed' => false,
            'description' => 'Bla bla bla',
            'user_id' => $user1->id
        ]);
        Task::create([
            'name' => 'Estudiar PHP',
            'completed' => true,
            'description' => 'JORL JORL JORL',
            'user_id' => $user1->id
        ]);
        $user1= factory(User::class)->create();
        $comprarpa = Task::create([
            'name' => 'comprar pa',
            'completed' => false,
            'description' => 'Bla bla bla',
            'user_id' => $user1->id
        ]);
        $comprarllet = Task::create([
            'name' => 'comprar llet',
            'completed' => false,
            'description' => 'Bla bla bla',
            'user_id' => $user1->id
        ]);
        $estudiarPHP = Task::create([
            'name' => 'Estudiar PHP',
            'completed' => true,
            'description' => 'JORL JORL JORL',
            'user_id' => $user1->id
        ]);
        $tag1 = Tag::create([
            'name' => 'Tag1',
            'color' => 'blue',
            'description' => 'bla bla bla'
        ]);
        $tag2 = Tag::create([
            'name' => 'Tag2',
            'color' => 'red',
            'description' => 'Jorl Jorl'
        ]);
        $estudiarPHP->addTag($tag1);
        $estudiarPHP->addTag($tag2);
        $comprarllet->addTag($tag1);
        $comprarllet->addTag($tag2);
        $comprarpa->addTag($tag1);
    }
}
if (!function_exists('create_example_tags')) {
    function create_example_tags() {
        Tag::create([
            'name' => 'comprar pa',
            'description'=>'hola que tal',
            'color'=>'#17afe4',

        ]);
        Tag::create([
            'name' => 'comprar llet',
            'description'=>'hola que mal',
            'color'=>'#e41717',
        ]);
        Tag::create([
            'name' => 'Estudiar PHP',
            'description'=>'hola que fatal',
            'color'=>'#17e421',
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
if (!function_exists('create_database')) {
    function create_database()
    {
        create_mysql_database(env('DB_DATABASE'));
        create_mysql_user(env('DB_USERNAME'), env('DB_PASSWORD'));
        grant_mysql_privileges(env('DB_USERNAME'), env('DB_DATABASE'));
    }
}
if (!function_exists('create_role')) {
    function create_role($role)
    {
        try {
            return Role::create([
                'name' => $role
            ]);
        } catch(Exception $e) {
            return Role::findByName($role);
        }
    }
}
if (!function_exists('create_permission')) {
    function create_permission($permission)
    {
        try {
            return Permission::create([
                'name' => $permission
            ]);
        } catch(Exception $e) {
            return Permission::findByName($permission);
        }
    }
}
if (!function_exists('initialize_gates')) {
    function initialize_gates()
    {
        Gate::define('tasks.manage',function($user) {
            return $user->isSuperAdmin() || $user->hasRole('TaskManager');
        });
        Gate::define('tags.manage',function($user) {
            return $user->isSuperAdmin() || $user->hasRole('TagsManager');
        });
        Gate::define('changelog.list', function ($user) {
            return $user->hasRole('ChangelogManager');
        });
    }
}
if (!function_exists('initialize_roles')) {
    function initialize_roles() {
        $roles = [
            'TaskManager',
            'Tasks',
            'TagsManager',
            'NotificationsManager',
            'Tags'
        ];

        foreach ($roles as $role) {
            create_role($role);
        }

        $taskManagerPermissions = [
            'tasks.index',
            'tasks.show',
            'tasks.store',
            'tasks.update',
            'tasks.complete',
            'tasks.uncomplete',
            'tasks.destroy'
        ];

        $tagsManagerPermissions = [
            'tags.index',
            'tags.show',
            'tags.store',
            'tags.update',
            'tags.complete',
            'tags.uncomplete',
            'tags.destroy'
        ];

        $notificationsManagerPermissions = [
            'notifications.index',
            'notifications.destroy',
            'notifications.destroyMultiple',
            'notifications.simple.store'
        ];

        // user.tasks Who:
        // Logged->user === Task->user_id &&
        // També ha de tenir Rol Tasks
        $userTaskPermissions = [
            'user.tasks.index',
            'user.tasks.show',
            'user.tasks.store',
            'user.tasks.update',
            'user.tasks.complete',
            'user.tasks.uncomplete',
            'user.tasks.destroy'
        ];

        $userTagsPermissions = [
            'user.tags.index',
            'user.tags.show',
            'user.tags.store',
            'user.tags.update',
            'user.tags.complete',
            'user.tags.uncomplete',
            'user.tags.destroy'
        ];

        $permissions = array_merge(
            $taskManagerPermissions,
            $userTaskPermissions,
            $tagsManagerPermissions,
            $userTagsPermissions,
            $notificationsManagerPermissions
        );

        foreach ($permissions as $permission) {
            create_permission($permission);
        }

        $rolePermissions = [
            'TaskManager' => $taskManagerPermissions,
            'Tasks' => $userTaskPermissions,
            'TagsManager' => $tagsManagerPermissions,
            'Tags' => $userTagsPermissions,
            'NotificationsManager' => $notificationsManagerPermissions,
        ];

        foreach ($rolePermissions as $role => $rolePermission) {
            $role = Role::findByName($role);
            foreach ($rolePermission as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
if (!function_exists('sample_users')) {
    function sample_users()
    {
        //superadmin no cal -> jo mateix
        try {
            $pepepringao = factory(User::class)->create([
                'name' => 'Pepe Pringao',
                'email' => 'pepepringao@hotmail.com'
            ]);
        } catch (exception $e) {
        }
        Task::create([
            'name' => 'Tasca Pepe',
            'completed' => false,
            'description' => 'Descripció de prova',
            'user_id' => $pepepringao->id
        ]);
        try {
            $bartsimpson = factory(User::class)->create([
                'name' => 'Bart Simpson',
                'email' => 'bartsimpson@hotmail.com'
            ]);
        } catch (exception $e) {
        }
        try {
            $bartsimpson->assignRole('Tasks');
            $bartsimpson->assignRole('Tags');

        } catch (exception $e) {
        }
        Task::create([
            'name' => 'Tasca Bart',
            'completed' => false,
            'description' => 'Descripció Bart',
            'user_id' => $bartsimpson->id
        ]);
        try {
            $homersimpson = factory(User::class)->create([
                'name' => 'Homer Simpson',
                'email' => 'homersimpson@hotmail.com'
            ]);
        } catch (exception $e) {
        }
        try {
            $homersimpson->assignRole('TaskManager');
            $homersimpson->assignRole('TagsManager');
        } catch (exception $e) {
        }try {
            $homersimpson->assignRole('Tasks');
            $homersimpson->assignRole('Tags');
    } catch (exception $e) {
        }
        Task::create([
            'name' => 'Tasca Homer',
            'completed' => true,
            'description' => 'Descripció Homer',
            'user_id' => $homersimpson->id
        ]);
        try {
            $sergitur = factory(User::class)->create([
                'name' => 'Sergi Tur',
                'email' => 'sergiturbadenas@gmail.com',
                'password' => bcrypt(env('PRIMARY_USER_PASSWORD', 'secret'))
            ]);
            $sergitur->admin = true;
            $sergitur->save();
        } catch (Exception $e) {
        }
        Task::create([
            'name' => 'Tasca Sergi',
            'completed' => false,
            'description' => 'Sergi tasca',
            'user_id' => $sergitur->id
        ]);
    }
};
if (!function_exists('map_collection')) {
    function map_collection($collection)
    {
        return $collection->map(function ($item) {
            return $item->map();
        });
    }
}
if (! function_exists('set_sample_notifications_to_user')) {
    function set_sample_notifications_to_user($user) {
        $user->notify(new SimpleNotification('Notification 1'));
        $user->notify(new SimpleNotification('Notification 2'));
        $user->notify(new SimpleNotification('Notification 3'));
    }
}
if (! function_exists('sample_notifications')) {
    function sample_notifications()
    {
        $user1 = factory(User::class)->create([
            'name' => 'Homer Simpson',
            'email' => 'homer@lossimpsons.com'
        ]);
        $user2 = factory(User::class)->create([
            'name' => 'Bart Simpson',
            'email' => 'bart@lossimpsons.com'
        ]);
        $user1->notify(new SimpleNotification('Sample Notification 1'));
        $user2->notify(new SimpleNotification('Sample Notification 2'));
    }
}
if (! function_exists('map_simple_collection')) {
    function map_simple_collection($collection)
    {
        return $collection->map(function($item) {
            return $item->mapSimple();
        });
    }
}

if (! function_exists('is_valid_uuid')) {
    /**
     * Check if a given string is a valid UUID
     *
     * @param   string  $uuid   The string to check
     * @return  boolean
     */
    function is_valid_uuid( $uuid )
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }
}
if (!function_exists('logged_user')) {
    function logged_user()
    {
        return json_encode(optional(Auth::user())->map());
    }
}
if (! function_exists('git')) {
    function git() {
        return Cache::remember('git_info', 5, function () {
            Carbon::setLocale(config('app.locale'));
            return collect([
                'branch' => git_current_branch(),
                'commit' => git_current_commit(),
                'commit_short' => git_current_commit(true),
                'full_info' => git_current_commit_full_info(),
                'author_name' => git_current_commit_author_name(),
                'author_email' => git_current_commit_author_email(),
                'message' => git_current_commit_message(),
                'timestamp' => $timestamp = git_current_commit_timestamp(),
                'date' => $carbonDate = Carbon::createFromTimestamp($timestamp),
                'date_human_original' => git_current_commit_date_human(),
                'date_human' => $carbonDate->diffForHumans(Carbon::now()),
                'date_formatted' => $carbonDate->format('h:i:sA d-m-Y'),
                'origin' => git_remote_origin_url()
            ]);
        });
    }
}
if (! function_exists('git_current_branch')) {
    function git_current_branch() {
        exec('git name-rev --name-only HEAD', $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit')) {
    function git_current_commit($short = false) {
        $short ? exec('git rev-parse --short HEAD', $output) : exec('git rev-parse HEAD', $output) ;
        return $output[0];
    }
}
if (! function_exists('git_current_commit_full_info')) {
    function git_current_commit_full_info() {
        exec('git log -1', $output);
        return $output;
    }
}
if (! function_exists('git_current_commit_author_name')) {
    function git_current_commit_author_name() {
        exec("git log -1 --pretty=format:'%an'", $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit_author_email')) {
    function git_current_commit_author_email() {
        exec("git log -1 --pretty=format:'%ae'", $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit_message')) {
    function git_current_commit_message()
    {
        exec("git log -1 --pretty=format:'%s'", $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit_timestamp')) {
    function git_current_commit_timestamp()
    {
        exec("git log -1 --pretty=format:'%at'", $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit_date')) {
    function git_current_commit_date()
    {
        exec("git log -1 --pretty=format:'%ad'", $output);
        return $output[0];
    }
}
if (! function_exists('git_current_commit_date_human')) {
    function git_current_commit_date_human()
    {
        exec("git log -1 --pretty=format:'%ar'", $output);
        return $output[0];
    }
}
if (! function_exists('git_remote_origin_url')) {
    function git_remote_origin_url()
    {
        exec("git config --get remote.origin.url", $output);
        return $output[0];
    }
}
//todo: crear multiples usuaris en diferents rols
//todo:com gestionar el superadmin
