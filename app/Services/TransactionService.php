<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\BlockRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService
{
    /**
     * @var TransactionRepositoryInterface
     */
    protected TransactionRepositoryInterface $transactionRepository;

    /**
     * @var BlockRepositoryInterface
     */
    protected BlockRepositoryInterface $blockRepository;

    /**
     * TransactionService constructor.
     *
     * @param TransactionRepositoryInterface $transactionRepository
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        BlockRepositoryInterface $blockRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->blockRepository = $blockRepository;
    }

    /**
     * Get all transactions.
     *
     * @return Collection
     */
    public function getAllTransactions(): Collection
    {
        return $this->transactionRepository->all();
    }

    /**
     * Get transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function getTransactionById(int $id): ?Transaction
    {
        return $this->transactionRepository->findById($id);
    }

    /**
     * Get transactions for a specific account.
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
     * Get transactions for a specific user.
     *
     * @param int $userId
     * @param int $limit
     * @return Collection
     */
    public function getUserTransactions(int $userId, int $limit = 50): Collection
    {
        return $this->transactionRepository->findByUserId($userId, $limit);
    }

    /**
     * Get transactions by type (deposit/withdrawal).
     *
     * @param string $type
     * @param int $limit
     * @return Collection
     */
    public function getTransactionsByType(string $type, int $limit = 50): Collection
    {
        return $this->transactionRepository->findByType($type, $limit);
    }

    /**
     * Get recent transactions.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecentTransactions(int $limit = 10): Collection
    {
        return $this->transactionRepository->getRecent($limit);
    }

    /**
     * Get paginated transactions.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedTransactions(int $perPage = 15): LengthAwarePaginator
    {
        return $this->transactionRepository->paginate($perPage);
    }

    /**
     * Get transactions within date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $accountId
     * @return Collection
     */
    public function getTransactionsByDateRange(string $startDate, string $endDate, ?int $accountId = null): Collection
    {
        return $this->transactionRepository->findByDateRange($startDate, $endDate, $accountId);
    }

    /**
     * Get transaction with blockchain block info.
     *
     * @param int $transactionId
     * @return array|null
     */
    public function getTransactionWithBlock(int $transactionId): ?array
    {
        $transaction = $this->transactionRepository->findById($transactionId);

        if (!$transaction) {
            return null;
        }

        $block = $this->blockRepository->findByTransactionId($transactionId);

        return [
            'transaction' => $transaction,
            'block' => $block,
            'blockchain_verified' => $block ? $block->isValid() : false,
        ];
    }

    /**
     * Get transaction statistics for an account.
     *
     * @param int $accountId
     * @return array
     */
    public function getAccountTransactionStats(int $accountId): array
    {
        $totalDeposits = $this->transactionRepository->getTotalDepositsByAccountId($accountId);
        $totalWithdrawals = $this->transactionRepository->getTotalWithdrawalsByAccountId($accountId);
        $transactions = $this->transactionRepository->findByAccountId($accountId);

        return [
            'total_transactions' => $transactions->count(),
            'total_deposits' => $totalDeposits,
            'total_withdrawals' => $totalWithdrawals,
            'net_amount' => $totalDeposits - $totalWithdrawals,
            'deposit_count' => $transactions->where('type', 'deposit')->count(),
            'withdrawal_count' => $transactions->where('type', 'withdrawal')->count(),
        ];
    }
}
