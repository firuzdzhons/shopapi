<?php

Route::get('test', function (){
    $adminId = \App\Models\User::create([
        'name' => 'Администратор',
        'email' => 'admin3@gmail.com',
        'password' => bcrypt('admin#2012')
    ])->id;
    $admin = \App\Models\User::find($adminId);

    $adminRole =  \HttpOz\Roles\Models\Role::where('slug','admin')->first();

    $admin->attachRole($adminRole);

    return $adminRole;
});