<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Find user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user by DNI.
     *
     * @param string $dni
     * @return User|null
     */
    public function findByDni(string $dni): ?User;

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update user.
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): User;

    /**
     * Delete user.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get users with their accounts.
     *
     * @return Collection
     */
    public function getAllWithAccounts(): Collection;

    /**
     * Search users by name or email.
     *
     * @param string $query
     * @return Collection
     */
    public function search(string $query): Collection;
}
