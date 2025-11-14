<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'index',
        'data',
        'previous_hash',
        'hash',
        'nonce',
        'transaction_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'index' => 'integer',
        'nonce' => 'integer',
    ];

    /**
     * Get the transaction that owns the block.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Calculate the hash of the block.
     *
     * @return string
     */
    public function calculateHash(): string
    {
        $timestamp = $this->created_at ? $this->created_at->timestamp : now()->timestamp;

        $blockData = $this->index .
                     $timestamp .
                     json_encode($this->data) .
                     $this->previous_hash .
                     $this->nonce;

        return hash('sha256', $blockData);
    }

    /**
     * Mine the block using Proof of Work algorithm.
     *
     * @param int $difficulty Number of leading zeros required in hash
     * @return void
     */
    public function mineBlock(int $difficulty = 2): void
    {
        $target = str_repeat('0', $difficulty);

        // Keep trying until we find a hash that starts with the target
        while (substr($this->calculateHash(), 0, $difficulty) !== $target) {
            $this->nonce++;
        }

        $this->hash = $this->calculateHash();
    }

    /**
     * Verify if this block is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->hash === $this->calculateHash();
    }

    /**
     * Get short version of hash for display.
     *
     * @param int $length
     * @return string
     */
    public function getShortHash(int $length = 8): string
    {
        return substr($this->hash, 0, $length) . '...';
    }

    /**
     * Get block info as array.
     *
     * @return array
     */
    public function getBlockInfo(): array
    {
        return [
            'index' => $this->index,
            'hash' => $this->hash,
            'previous_hash' => $this->previous_hash,
            'nonce' => $this->nonce,
            'data' => $this->data,
            'timestamp' => $this->created_at->format('Y-m-d H:i:s'),
            'is_valid' => $this->isValid(),
        ];
    }

    /**
     * Create genesis block (first block in chain).
     *
     * @return self
     */
    public static function createGenesisBlock(): self
    {
        $block = new self([
            'index' => 0,
            'data' => [
                'message' => 'Genesis Block - SecroChain',
                'timestamp' => now()->timestamp,
            ],
            'previous_hash' => '0',
            'nonce' => 0,
        ]);

        $block->hash = $block->calculateHash();
        $block->save();

        return $block;
    }
}
