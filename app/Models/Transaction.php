<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'amount',
        'description',
        'account_id',
        'balance_before',
        'balance_after',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    /**
     * Get the account that owns the transaction.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the block associated with this transaction.
     */
    public function block(): HasOne
    {
        return $this->hasOne(Block::class);
    }

    /**
     * Get formatted type (capitalized).
     *
     * @return string
     */
    public function getFormattedType(): string
    {
        return ucfirst($this->type);
    }

    /**
     * Get formatted amount with sign.
     *
     * @return string
     */
    public function getFormattedAmount(): string
    {
        $sign = $this->type === 'deposit' ? '+' : '-';
        return "{$sign} $ " . number_format($this->amount, 2);
    }

    /**
     * Get formatted date.
     *
     * @return string
     */
    public function getFormattedDate(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Check if transaction is a deposit.
     *
     * @return bool
     */
    public function isDeposit(): bool
    {
        return $this->type === 'deposit';
    }

    /**
     * Check if transaction is a withdrawal.
     *
     * @return bool
     */
    public function isWithdrawal(): bool
    {
        return $this->type === 'withdrawal';
    }

    /**
     * Get transaction data as array for blockchain.
     *
     * @return array
     */
    public function toBlockchainData(): array
    {
        return [
            'transaction_id' => $this->id,
            'type' => $this->type,
            'amount' => $this->amount,
            'account_code' => $this->account->code,
            'balance_before' => $this->balance_before,
            'balance_after' => $this->balance_after,
            'description' => $this->description,
            'timestamp' => $this->created_at->timestamp,
        ];
    }
}
