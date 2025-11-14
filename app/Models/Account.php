<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\BlockchainService;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'balance',
        'initial_balance',
        'user_id',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'initial_balance' => 'decimal:2',
        'active' => 'boolean',
    ];

    /**
     * Get the user that owns the account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the account.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Deposit money into the account.
     *
     * @param float $amount
     * @param string|null $description
     * @return Transaction
     * @throws \Exception
     */
    public function deposit(float $amount, ?string $description = null): Transaction
    {
        if ($amount <= 0) {
            throw new \Exception("Amount must be greater than zero");
        }

        if (!$this->active) {
            throw new \Exception("Account is not active");
        }

        $balanceBefore = $this->balance;

        // Update balance
        $this->balance += $amount;
        $this->save();

        // Create transaction record
        $transaction = $this->transactions()->create([
            'type' => 'deposit',
            'amount' => $amount,
            'description' => $description,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
        ]);

        // Add to blockchain
        app(BlockchainService::class)->addBlock($transaction);

        return $transaction;
    }

    /**
     * Withdraw money from the account.
     *
     * @param float $amount
     * @param string|null $description
     * @return Transaction
     * @throws \Exception
     */
    public function withdraw(float $amount, ?string $description = null): Transaction
    {
        if ($amount <= 0) {
            throw new \Exception("Amount must be greater than zero");
        }

        if (!$this->active) {
            throw new \Exception("Account is not active");
        }

        if ($this->balance < $amount) {
            throw new \Exception("Insufficient balance");
        }

        $balanceBefore = $this->balance;

        // Update balance
        $this->balance -= $amount;
        $this->save();

        // Create transaction record
        $transaction = $this->transactions()->create([
            'type' => 'withdrawal',
            'amount' => $amount,
            'description' => $description,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
        ]);

        // Add to blockchain
        app(BlockchainService::class)->addBlock($transaction);

        return $transaction;
    }

    /**
     * Get account status as string.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->active ? 'Active' : 'Inactive';
    }

    /**
     * Get total deposits.
     *
     * @return float
     */
    public function getTotalDeposits(): float
    {
        return $this->transactions()
            ->where('type', 'deposit')
            ->sum('amount');
    }

    /**
     * Get total withdrawals.
     *
     * @return float
     */
    public function getTotalWithdrawals(): float
    {
        return $this->transactions()
            ->where('type', 'withdrawal')
            ->sum('amount');
    }

    /**
     * Get recent transactions.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentTransactions(int $limit = 10)
    {
        return $this->transactions()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
