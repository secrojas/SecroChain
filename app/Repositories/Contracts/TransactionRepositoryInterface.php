<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface
{
    /**
     * Get all transactions.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function findById(int $id): ?Transaction;

    /**
     * Get transactions by account ID.
     *
     * @param int $accountId
     * @param int $limit
     * @return Collection
     */
    public function findByAccountId(int $accountId, int $limit = 50): Collection;

    /**
     * Get transactions by user ID.
     *
     * @param int $userId
     * @param int $limit
     * @return Collection
     */
    public function findByUserId(int $userId, int $limit = 50): Collection;

    /**
     * Get transactions by type.
     *
     * @param string $type
     * @param int $limit
     * @return Collection
     */
    public function findByType(string $type, int $limit = 50): Collection;

    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction;

    /**
     * Get paginated transactions.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get recent transactions.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection;

    /**
     * Get transactions within date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $accountId
     * @return Collection
     */
    public function findByDateRange(string $startDate, string $endDate, ?int $accountId = null): Collection;

    /**
     * Get total deposited amount by account.
     *
     * @param int $accountId
     * @return float
     */
    public function getTotalDepositsByAccountId(int $accountId): float;

    /**
     * Get total withdrawn amount by account.
     *
     * @param int $accountId
     * @return float
     */
    public function getTotalWithdrawalsByAccountId(int $accountId): float;
}
