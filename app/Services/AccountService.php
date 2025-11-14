<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    /**
     * @var AccountRepositoryInterface
     */
    protected AccountRepositoryInterface $accountRepository;

    /**
     * @var TransactionRepositoryInterface
     */
    protected TransactionRepositoryInterface $transactionRepository;

    /**
     * @var BlockchainService
     */
    protected BlockchainService $blockchainService;

    /**
     * AccountService constructor.
     *
     * @param AccountRepositoryInterface $accountRepository
     * @param TransactionRepositoryInterface $transactionRepository
     * @param BlockchainService $blockchainService
     */
    public function __construct(
        AccountRepositoryInterface $accountRepository,
        TransactionRepositoryInterface $transactionRepository,
        BlockchainService $blockchainService
    ) {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->blockchainService = $blockchainService;
    }

    /**
     * Create a new account for a user.
     *
     * @param int $userId
     * @param float $initialBalance
     * @return Account
     */
    public function createAccount(int $userId, float $initialBalance = 0): Account
    {
        $data = [
            'user_id' => $userId,
            'code' => $this->accountRepository->generateUniqueCode(),
            'balance' => $initialBalance,
            'initial_balance' => $initialBalance,
            'active' => true,
        ];

        return $this->accountRepository->create($data);
    }

    /**
     * Get all accounts for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserAccounts(int $userId): Collection
    {
        return $this->accountRepository->findByUserId($userId);
    }

    /**
     * Get only active accounts for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserActiveAccounts(int $userId): Collection
    {
        return $this->accountRepository->findActiveByUserId($userId);
    }

    /**
     * Get account by code.
     *
     * @param string $code
     * @return Account|null
     */
    public function getAccountByCode(string $code): ?Account
    {
        return $this->accountRepository->findByCode($code);
    }

    /**
     * Deposit money into an account.
     *
     * @param int $accountId
     * @param float $amount
     * @param string|null $description
     * @return Transaction
     * @throws \Exception
     */
    public function deposit(int $accountId, float $amount, ?string $description = null): Transaction
    {
        $account = $this->accountRepository->findById($accountId);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        return $account->deposit($amount, $description);
    }

    /**
     * Withdraw money from an account.
     *
     * @param int $accountId
     * @param float $amount
     * @param string|null $description
     * @return Transaction
     * @throws \Exception
     */
    public function withdraw(int $accountId, float $amount, ?string $description = null): Transaction
    {
        $account = $this->accountRepository->findById($accountId);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        return $account->withdraw($amount, $description);
    }

    /**
     * Transfer money between accounts.
     *
     * @param int $fromAccountId
     * @param int $toAccountId
     * @param float $amount
     * @param string|null $description
     * @return array
     * @throws \Exception
     */
    public function transfer(int $fromAccountId, int $toAccountId, float $amount, ?string $description = null): array
    {
        $fromAccount = $this->accountRepository->findById($fromAccountId);
        $toAccount = $this->accountRepository->findById($toAccountId);

        if (!$fromAccount) {
            throw new \Exception("Source account not found");
        }

        if (!$toAccount) {
            throw new \Exception("Destination account not found");
        }

        if ($fromAccountId === $toAccountId) {
            throw new \Exception("Cannot transfer to the same account");
        }

        // Withdraw from source account
        $withdrawalDescription = "Transfer to {$toAccount->code}" . ($description ? ": {$description}" : "");
        $withdrawal = $fromAccount->withdraw($amount, $withdrawalDescription);

        // Deposit to destination account
        $depositDescription = "Transfer from {$fromAccount->code}" . ($description ? ": {$description}" : "");
        $deposit = $toAccount->deposit($amount, $depositDescription);

        return [
            'withdrawal' => $withdrawal,
            'deposit' => $deposit,
            'from_account' => $fromAccount->fresh(),
            'to_account' => $toAccount->fresh(),
        ];
    }

    /**
     * Get account balance.
     *
     * @param int $accountId
     * @return float
     * @throws \Exception
     */
    public function getBalance(int $accountId): float
    {
        $account = $this->accountRepository->findById($accountId);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        return $account->balance;
    }

    /**
     * Get total balance for a user across all accounts.
     *
     * @param int $userId
     * @return float
     */
    public function getTotalUserBalance(int $userId): float
    {
        return $this->accountRepository->getTotalBalanceByUserId($userId);
    }

    /**
     * Activate an account.
     *
     * @param int $accountId
     * @return Account
     */
    public function activateAccount(int $accountId): Account
    {
        return $this->accountRepository->activate($accountId);
    }

    /**
     * Deactivate an account.
     *
     * @param int $accountId
     * @return Account
     */
    public function deactivateAccount(int $accountId): Account
    {
        return $this->accountRepository->deactivate($accountId);
    }

    /**
     * Get account transaction history.
     *
     * @param int $accountId
     * @param int $limit
     * @return Collection
     */
    public function getAccountTransactions(int $accountId, int $limit = 50): Collection
    {
        return $this->transactionRepository->findByAccountId($accountId, $limit);
    }

    /**
     * Get account statistics.
     *
     * @param int $accountId
     * @return array
     * @throws \Exception
     */
    public function getAccountStats(int $accountId): array
    {
        $account = $this->accountRepository->findById($accountId);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        $totalDeposits = $this->transactionRepository->getTotalDepositsByAccountId($accountId);
        $totalWithdrawals = $this->transactionRepository->getTotalWithdrawalsByAccountId($accountId);

        return [
            'account_code' => $account->code,
            'current_balance' => $account->balance,
            'initial_balance' => $account->initial_balance,
            'total_deposits' => $totalDeposits,
            'total_withdrawals' => $totalWithdrawals,
            'net_change' => $account->balance - $account->initial_balance,
            'is_active' => $account->active,
        ];
    }
}
