<?php

namespace App\Repositories\Contracts;

use App\Models\Block;
use Illuminate\Database\Eloquent\Collection;

interface BlockRepositoryInterface
{
    /**
     * Get all blocks.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find block by ID.
     *
     * @param int $id
     * @return Block|null
     */
    public function findById(int $id): ?Block;

    /**
     * Find block by hash.
     *
     * @param string $hash
     * @return Block|null
     */
    public function findByHash(string $hash): ?Block;

    /**
     * Find block by transaction ID.
     *
     * @param int $transactionId
     * @return Block|null
     */
    public function findByTransactionId(int $transactionId): ?Block;

    /**
     * Get latest block.
     *
     * @return Block|null
     */
    public function getLatest(): ?Block;

    /**
     * Get recent blocks.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection;

    /**
     * Get blocks ordered by index.
     *
     * @return Collection
     */
    public function getAllOrdered(): Collection;

    /**
     * Create a new block.
     *
     * @param array $data
     * @return Block
     */
    public function create(array $data): Block;

    /**
     * Count total blocks.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get blocks with transaction data.
     *
     * @param int $limit
     * @return Collection
     */
    public function getWithTransactions(int $limit = 10): Collection;
}
