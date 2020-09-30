<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\User $admin */
        $admin = \App\User::firstOrCreate([
            'name' => 'ADMIN',
            'email' => 'admin@test.com',
            'password' => bcrypt('123@123a')
        ]);

        $admin->assignRole('superadmin');
    }
}
