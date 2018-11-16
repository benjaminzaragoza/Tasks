<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        create_primary_user();
        create_example_tasks();
        create_example_tags();
        initialize_roles();

        //Crear usuaris de proves
        sample_users();
        //todo -> com fer-ho en el registre
    }
}
