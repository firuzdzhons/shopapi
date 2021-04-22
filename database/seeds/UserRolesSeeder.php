<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \HttpOz\Roles\Models\Role::create([
            'name' => 'Администратор',
            'slug' => 'admin',
        ]);

        \HttpOz\Roles\Models\Role::create([
            'name' => 'Пользователь',
            'slug' => 'user',
        ]);
    }
}
