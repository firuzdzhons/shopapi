<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = \App\Models\User::create([
            'name' => 'Администратор',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin#2012')
        ])->id;
        $admin = \App\Models\User::find($adminId);

        $adminRole =  \HttpOz\Roles\Models\Role::where('slug','admin')->first();

        $admin->attachRole($adminRole);


        $userId = \App\Models\User::create([
            'name' => 'Клиент',
            'email' => 'client@gmail.com',
            'password' => bcrypt('admin#2012')
        ])->id;
        $client = \App\Models\User::find($userId);

        $clientRole =  \HttpOz\Roles\Models\Role::where('slug','user')->first();

        $client->attachRole($clientRole);
    }
}
