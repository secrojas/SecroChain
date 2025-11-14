<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRepository = app(UserRepositoryInterface::class);

        // Create test users
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'dni' => '12345678',
                'email' => 'john@example.com',
                'password' => 'password123',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'dni' => '87654321',
                'email' => 'jane@example.com',
                'password' => 'password123',
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Johnson',
                'dni' => '11223344',
                'email' => 'robert@example.com',
                'password' => 'password123',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'dni' => '44332211',
                'email' => 'maria@example.com',
                'password' => 'password123',
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'dni' => '99999999',
                'email' => 'admin@secrochain.com',
                'password' => 'admin123',
            ],
        ];

        foreach ($users as $userData) {
            $userRepository->create($userData);
            $this->command->info("Created user: {$userData['email']}");
        }

        $this->command->info('User seeding completed!');
    }
}
