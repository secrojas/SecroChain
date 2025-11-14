<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * TransactionController constructor.
     *
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Get all transactions for authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 50);
            $transactions = $this->transactionService->getUserTransactions($request->user()->id, $limit);

            return response()->json([
                'success' => true,
                'data' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get specific transaction.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $transaction = $this->transactionService->getTransactionById($id);

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recent transactions.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function recent(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            $transactions = $this->transactionService->getRecentTransactions($limit);

            return response()->json([
                'success' => true,
                'data' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recent transactions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get transactions by type (deposit/withdrawal).
     *
     * @param Request $request
     * @param string $type
     * @return JsonResponse
     */
    public function byType(Request $request, string $type): JsonResponse
    {
        try {
            if (!in_array($type, ['deposit', 'withdrawal'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid transaction type. Must be "deposit" or "withdrawal"',
                ], 400);
            }

            $limit = $request->query('limit', 50);
            $transactions = $this->transactionService->getTransactionsByType($type, $limit);

            return response()->json([
                'success' => true,
                'data' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get transactions within date range.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function dateRange(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'account_id' => 'nullable|exists:accounts,id',
            ]);

            $transactions = $this->transactionService->getTransactionsByDateRange(
                $request->start_date,
                $request->end_date,
                $request->account_id
            );

            return response()->json([
                'success' => true,
                'data' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get transaction with blockchain verification.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function withBlock(int $id): JsonResponse
    {
        try {
            $data = $this->transactionService->getTransactionWithBlock($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
