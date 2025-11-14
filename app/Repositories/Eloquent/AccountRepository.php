<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{
    /**
     * @var Account
     */
    protected Account $model;

    /**
     * AccountRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    /**
     * Get all accounts.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->with('user')->get();
    }

    /**
     * Find account by ID.
     *
     * @param int $id
     * @return Account|null
     */
    public function findById(int $id): ?Account
    {
        return $this->model->with('user')->find($id);
    }

    /**
     * Find account by code.
     *
     * @param string $code
     * @return Account|null
     */
    public function findByCode(string $code): ?Account
    {
        return $this->model->with('user')->where('code', $code)->first();
    }

    /**
     * Get accounts by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function findByUserId(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Get active accounts by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function findActiveByUserId(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('active', true)
            ->get();
    }

    /**
     * Create a new account.
     *
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        // Generate unique code if not provided
        if (!isset($data['code'])) {
            $data['code'] = $this->generateUniqueCode();
        }

        // Set initial_balance same as balance if not provided
        if (isset($data['balance']) && !isset($data['initial_balance'])) {
            $data['initial_balance'] = $data['balance'];
        }

        return $this->model->create($data);
    }

    /**
     * Update account.
     *
     * @param int $id
     * @param array $data
     * @return Account
     */
    public function update(int $id, array $data): Account
    {
        $account = $this->findById($id);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        $account->update($data);

        return $account->fresh();
    }

    /**
     * Delete account.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $account = $this->findById($id);

        if (!$account) {
            throw new \Exception("Account not found");
        }

        return $account->delete();
    }

    /**
     * Activate account.
     *
     * @param int $id
     * @return Account
     */
    public function activate(int $id): Account
    {
        return $this->update($id, ['active' => true]);
    }

    /**
     * Deactivate account.
     *
     * @param int $id
     * @return Account
     */
    public function deactivate(int $id): Account
    {
        return $this->update($id, ['active' => false]);
    }

    /**
     * Get total balance for user.
     *
     * @param int $userId
     * @return float
     */
    public function getTotalBalanceByUserId(int $userId): float
    {
        return $this->model
            ->where('user_id', $userId)
            ->sum('balance');
    }

    /**
     * Generate unique account code.
     *
     * @return string
     */
    public function generateUniqueCode(): string
    {
        $latestAccount = $this->model->latest('id')->first();
        $number = $latestAccount ? $latestAccount->id + 1 : 1;

        return 'ACC-' . str_pad($number, 8, '0', STR_PAD_LEFT);
    }
}
