<?php

namespace App\Services;

use App\Models\Block;
use App\Models\Transaction;

class BlockchainService
{
    /**
     * Mining difficulty (number of leading zeros required in hash).
     *
     * @var int
     */
    protected int $difficulty = 2;

    /**
     * Initialize blockchain with genesis block if it doesn't exist.
     *
     * @return void
     */
    public function initializeBlockchain(): void
    {
        if (Block::count() === 0) {
            Block::createGenesisBlock();
        }
    }

    /**
     * Get the latest block in the chain.
     *
     * @return Block|null
     */
    public function getLatestBlock(): ?Block
    {
        return Block::orderBy('index', 'desc')->first();
    }

    /**
     * Add a new block to the blockchain for a transaction.
     *
     * @param Transaction $transaction
     * @return Block
     */
    public function addBlock(Transaction $transaction): Block
    {
        // Initialize blockchain if empty
        $this->initializeBlockchain();

        $latestBlock = $this->getLatestBlock();

        // Create new block
        $newBlock = new Block([
            'index' => $latestBlock ? $latestBlock->index + 1 : 0,
            'data' => $transaction->toBlockchainData(),
            'previous_hash' => $latestBlock ? $latestBlock->hash : '0',
            'nonce' => 0,
            'transaction_id' => $transaction->id,
        ]);

        // Mine the block (Proof of Work)
        $newBlock->mineBlock($this->difficulty);

        // Save to database
        $newBlock->save();

        return $newBlock;
    }

    /**
     * Verify the integrity of the entire blockchain.
     *
     * @return bool
     */
    public function isChainValid(): bool
    {
        $blocks = Block::orderBy('index')->get();

        if ($blocks->isEmpty()) {
            return true;
        }

        foreach ($blocks as $index => $block) {
            // Skip genesis block
            if ($index === 0) {
                continue;
            }

            // Check if current block hash is valid
            if (!$block->isValid()) {
                return false;
            }

            // Check if previous hash matches
            $previousBlock = $blocks[$index - 1];
            if ($block->previous_hash !== $previousBlock->hash) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get blockchain statistics.
     *
     * @return array
     */
    public function getBlockchainStats(): array
    {
        $totalBlocks = Block::count();
        $latestBlock = $this->getLatestBlock();

        return [
            'total_blocks' => $totalBlocks,
            'latest_block_index' => $latestBlock ? $latestBlock->index : null,
            'latest_block_hash' => $latestBlock ? $latestBlock->getShortHash() : null,
            'chain_valid' => $this->isChainValid(),
            'difficulty' => $this->difficulty,
        ];
    }

    /**
     * Get all blocks with their info.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentBlocks(int $limit = 10)
    {
        return Block::with('transaction.account')
            ->orderBy('index', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Find blocks by transaction ID.
     *
     * @param int $transactionId
     * @return Block|null
     */
    public function findBlockByTransaction(int $transactionId): ?Block
    {
        return Block::where('transaction_id', $transactionId)->first();
    }

    /**
     * Repair blockchain by recalculating all hashes.
     * WARNING: This should only be used in development!
     *
     * @return void
     */
    public function repairChain(): void
    {
        $blocks = Block::orderBy('index')->get();

        foreach ($blocks as $index => $block) {
            if ($index > 0) {
                $previousBlock = $blocks[$index - 1];
                $block->previous_hash = $previousBlock->hash;
            }

            $block->nonce = 0;
            $block->mineBlock($this->difficulty);
            $block->save();
        }
    }

    /**
     * Set mining difficulty.
     *
     * @param int $difficulty
     * @return void
     */
    public function setDifficulty(int $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    /**
     * Get mining difficulty.
     *
     * @return int
     */
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }
}
