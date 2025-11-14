<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\AccountService;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountService = app(AccountService::class);

        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Create accounts for each user
        foreach ($users as $user) {
            // Create 1-3 accounts per user with different initial balances
            $accountsCount = rand(1, 3);

            for ($i = 0; $i < $accountsCount; $i++) {
                $initialBalance = rand(1000, 50000) / 10; // Random balance between 100 and 5000

                $account = $accountService->createAccount($user->id, $initialBalance);

                $this->command->info("Created account {$account->code} for {$user->getFullName()} with balance: \${$initialBalance}");
            }
        }

        $this->command->info('Account seeding completed!');
    }
}
