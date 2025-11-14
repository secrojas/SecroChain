<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    /**
     * Get all accounts.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find account by ID.
     *
     * @param int $id
     * @return Account|null
     */
    public function findById(int $id): ?Account;

    /**
     * Find account by code.
     *
     * @param string $code
     * @return Account|null
     */
    public function findByCode(string $code): ?Account;

    /**
     * Get accounts by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function findByUserId(int $userId): Collection;

    /**
     * Get active accounts by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function findActiveByUserId(int $userId): Collection;

    /**
     * Create a new account.
     *
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account;

    /**
     * Update account.
     *
     * @param int $id
     * @param array $data
     * @return Account
     */
    public function update(int $id, array $data): Account;

    /**
     * Delete account.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Activate account.
     *
     * @param int $id
     * @return Account
     */
    public function activate(int $id): Account;

    /**
     * Deactivate account.
     *
     * @param int $id
     * @return Account
     */
    public function deactivate(int $id): Account;

    /**
     * Get total balance for user.
     *
     * @param int $userId
     * @return float
     */
    public function getTotalBalanceByUserId(int $userId): float;

    /**
     * Generate unique account code.
     *
     * @return string
     */
    public function generateUniqueCode(): string;
}
