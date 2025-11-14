<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var Transaction
     */
    protected Transaction $model;

    /**
     * TransactionRepository constructor.
     *
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * Get all transactions.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->with('account.user')->latest()->get();
    }

    /**
     * Find transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function findById(int $id): ?Transaction
    {
        return $this->model->with('account.user')->find($id);
    }

    /**
     * Get transactions by account ID.
     *
     * @param int $accountId
     * @param int $limit
     * @return Collection
     */
    public function findByAccountId(int $accountId, int $limit = 50): Collection
    {
        return $this->model
            ->where('account_id', $accountId)
            ->with('account')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get transactions by user ID.
     *
     * @param int $userId
     * @param int $limit
     * @return Collection
     */
    public function findByUserId(int $userId, int $limit = 50): Collection
    {
        return $this->model
            ->whereHas('account', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('account')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get transactions by type.
     *
     * @param string $type
     * @param int $limit
     * @return Collection
     */
    public function findByType(string $type, int $limit = 50): Collection
    {
        return $this->model
            ->where('type', $type)
            ->with('account.user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        return $this->model->create($data);
    }

    /**
     * Get paginated transactions.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('account.user')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get recent transactions.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->with('account.user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get transactions within date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $accountId
     * @return Collection
     */
    public function findByDateRange(string $startDate, string $endDate, ?int $accountId = null): Collection
    {
        $query = $this->model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('account.user');

        if ($accountId) {
            $query->where('account_id', $accountId);
        }

        return $query->latest()->get();
    }

    /**
     * Get total deposited amount by account.
     *
     * @param int $accountId
     * @return float
     */
    public function getTotalDepositsByAccountId(int $accountId): float
    {
        return $this->model
            ->where('account_id', $accountId)
            ->where('type', 'deposit')
            ->sum('amount');
    }

    /**
     * Get total withdrawn amount by account.
     *
     * @param int $accountId
     * @return float
     */
    public function getTotalWithdrawalsByAccountId(int $accountId): float
    {
        return $this->model
            ->where('account_id', $accountId)
            ->where('type', 'withdrawal')
            ->sum('amount');
    }
}
