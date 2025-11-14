<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    /**
     * @var AccountService
     */
    protected AccountService $accountService;

    /**
     * AccountController constructor.
     *
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Get all accounts for authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $accounts = $this->accountService->getUserAccounts($request->user()->id);

            return response()->json([
                'success' => true,
                'data' => $accounts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve accounts',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new account for authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'initial_balance' => 'nullable|numeric|min:0',
            ]);

            $account = $this->accountService->createAccount(
                $request->user()->id,
                $request->initial_balance ?? 0
            );

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully',
                'data' => $account,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create account',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get specific account by code.
     *
     * @param string $code
     * @return JsonResponse
     */
    public function show(string $code): JsonResponse
    {
        try {
            $account = $this->accountService->getAccountByCode($code);

            if (!$account) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $account,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve account',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Deposit money into account.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function deposit(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
                'description' => 'nullable|string|max:255',
            ]);

            $transaction = $this->accountService->deposit(
                $id,
                $request->amount,
                $request->description
            );

            return response()->json([
                'success' => true,
                'message' => 'Deposit successful',
                'data' => [
                    'transaction' => $transaction,
                    'account' => $transaction->account,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deposit failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Withdraw money from account.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function withdraw(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
                'description' => 'nullable|string|max:255',
            ]);

            $transaction = $this->accountService->withdraw(
                $id,
                $request->amount,
                $request->description
            );

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal successful',
                'data' => [
                    'transaction' => $transaction,
                    'account' => $transaction->account,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Transfer money between accounts.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function transfer(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'from_account_id' => 'required|exists:accounts,id',
                'to_account_id' => 'required|exists:accounts,id|different:from_account_id',
                'amount' => 'required|numeric|min:0.01',
                'description' => 'nullable|string|max:255',
            ]);

            $result = $this->accountService->transfer(
                $request->from_account_id,
                $request->to_account_id,
                $request->amount,
                $request->description
            );

            return response()->json([
                'success' => true,
                'message' => 'Transfer successful',
                'data' => $result,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transfer failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get account statistics.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function stats(int $id): JsonResponse
    {
        try {
            $stats = $this->accountService->getAccountStats($id);

            return response()->json([
                'success' => true,
                'data' => $stats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve account statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get account transactions.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function transactions(Request $request, int $id): JsonResponse
    {
        try {
            $limit = $request->query('limit', 50);
            $transactions = $this->accountService->getAccountTransactions($id, $limit);

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
     * Activate account.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function activate(int $id): JsonResponse
    {
        try {
            $account = $this->accountService->activateAccount($id);

            return response()->json([
                'success' => true,
                'message' => 'Account activated successfully',
                'data' => $account,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate account',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Deactivate account.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deactivate(int $id): JsonResponse
    {
        try {
            $account = $this->accountService->deactivateAccount($id);

            return response()->json([
                'success' => true,
                'message' => 'Account deactivated successfully',
                'data' => $account,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate account',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
