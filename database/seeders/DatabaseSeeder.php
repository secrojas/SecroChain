<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('==============================================');
        $this->command->info('  SecroChain Database Seeding');
        $this->command->info('==============================================');
        $this->command->newLine();

        // Seed in order: Users -> Accounts -> Transactions (with blockchain)
        $this->call([
            UserSeeder::class,
            AccountSeeder::class,
            TransactionSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('==============================================');
        $this->command->info('  Database seeding completed successfully!');
        $this->command->info('==============================================');
    }
}
