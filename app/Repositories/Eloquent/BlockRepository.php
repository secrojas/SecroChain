<?php

namespace App\Repositories\Eloquent;

use App\Models\Block;
use App\Repositories\Contracts\BlockRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BlockRepository implements BlockRepositoryInterface
{
    /**
     * @var Block
     */
    protected Block $model;

    /**
     * BlockRepository constructor.
     *
     * @param Block $model
     */
    public function __construct(Block $model)
    {
        $this->model = $model;
    }

    /**
     * Get all blocks.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->orderBy('index')->get();
    }

    /**
     * Find block by ID.
     *
     * @param int $id
     * @return Block|null
     */
    public function findById(int $id): ?Block
    {
        return $this->model->with('transaction.account')->find($id);
    }

    /**
     * Find block by hash.
     *
     * @param string $hash
     * @return Block|null
     */
    public function findByHash(string $hash): ?Block
    {
        return $this->model->where('hash', $hash)->first();
    }

    /**
     * Find block by transaction ID.
     *
     * @param int $transactionId
     * @return Block|null
     */
    public function findByTransactionId(int $transactionId): ?Block
    {
        return $this->model
            ->with('transaction.account')
            ->where('transaction_id', $transactionId)
            ->first();
    }

    /**
     * Get latest block.
     *
     * @return Block|null
     */
    public function getLatest(): ?Block
    {
        return $this->model->orderBy('index', 'desc')->first();
    }

    /**
     * Get recent blocks.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return $this->model
            ->with('transaction.account')
            ->orderBy('index', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get blocks ordered by index.
     *
     * @return Collection
     */
    public function getAllOrdered(): Collection
    {
        return $this->model
            ->with('transaction.account')
            ->orderBy('index')
            ->get();
    }

    /**
     * Create a new block.
     *
     * @param array $data
     * @return Block
     */
    public function create(array $data): Block
    {
        return $this->model->create($data);
    }

    /**
     * Count total blocks.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Get blocks with transaction data.
     *
     * @param int $limit
     * @return Collection
     */
    public function getWithTransactions(int $limit = 10): Collection
    {
        return $this->model
            ->with('transaction.account.user')
            ->orderBy('index', 'desc')
            ->limit($limit)
            ->get();
    }
}
