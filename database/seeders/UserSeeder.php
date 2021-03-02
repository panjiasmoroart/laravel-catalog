<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin Role',
            'email' => 'admin@role.test',
            'password' => bcrypt('12345678')
        ]);

        $admin->assignRole('admin');

        $customer = User::create([
            'name' => 'Panji Asmoro',
            'email' => 'customer@role.test',
            'password' => bcrypt('12345678')
        ]);

        $customer->assignRole('customer');
    }
}
