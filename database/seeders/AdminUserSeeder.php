<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Enums\CustomerStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $customer = explode(" ", $user->name);
        Customer::create([
            'user_id' => $user->id,
            'first_name' => $customer[0],
            'last_name' => $customer[1] ?? '',
            'status' => CustomerStatus::Active->value,
        ]);
    }
}
