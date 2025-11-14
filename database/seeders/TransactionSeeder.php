<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Services\AccountService;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountService = app(AccountService::class);

        // Get all active accounts
        $accounts = Account::where('active', true)->get();

        if ($accounts->isEmpty()) {
            $this->command->error('No accounts found. Please run AccountSeeder first.');
            return;
        }

        $this->command->info('Creating transactions and mining blocks...');
        $transactionCount = 0;
        $blockCount = 0;

        // Create random transactions for each account
        foreach ($accounts as $account) {
            $numTransactions = rand(3, 8);

            for ($i = 0; $i < $numTransactions; $i++) {
                $type = rand(0, 1) ? 'deposit' : 'withdrawal';
                $amount = rand(10, 1000);
                $descriptions = [
                    'deposit' => [
                        'Salary payment',
                        'Bonus',
                        'Investment return',
                        'Transfer received',
                        'Refund',
                    ],
                    'withdrawal' => [
                        'Payment for services',
                        'Purchase',
                        'Bill payment',
                        'Transfer sent',
                        'ATM withdrawal',
                    ],
                ];

                $description = $descriptions[$type][array_rand($descriptions[$type])];

                try {
                    if ($type === 'deposit') {
                        $transaction = $accountService->deposit($account->id, $amount, $description);
                        $this->command->info("  ✓ Deposit: \${$amount} to {$account->code} - {$description}");
                    } else {
                        // Only withdraw if sufficient balance
                        if ($account->fresh()->balance >= $amount) {
                            $transaction = $accountService->withdraw($account->id, $amount, $description);
                            $this->command->info("  ✓ Withdrawal: \${$amount} from {$account->code} - {$description}");
                        } else {
                            $this->command->warn("  ⚠ Skipped withdrawal (insufficient balance): {$account->code}");
                            continue;
                        }
                    }

                    $transactionCount++;
                    $blockCount++; // Each transaction creates a block

                } catch (\Exception $e) {
                    $this->command->error("  ✗ Transaction failed: {$e->getMessage()}");
                }

                // Add small delay to differentiate timestamps
                usleep(100000); // 0.1 seconds
            }
        }

        $this->command->newLine();
        $this->command->info("Transaction seeding completed!");
        $this->command->info("Total transactions created: {$transactionCount}");
        $this->command->info("Total blocks mined: {$blockCount}");
    }
}
