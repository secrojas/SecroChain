<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BlockchainService;
use App\Repositories\Contracts\BlockRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlockchainController extends Controller
{
    /**
     * @var BlockchainService
     */
    protected BlockchainService $blockchainService;

    /**
     * @var BlockRepositoryInterface
     */
    protected BlockRepositoryInterface $blockRepository;

    /**
     * BlockchainController constructor.
     *
     * @param BlockchainService $blockchainService
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        BlockchainService $blockchainService,
        BlockRepositoryInterface $blockRepository
    ) {
        $this->blockchainService = $blockchainService;
        $this->blockRepository = $blockRepository;
    }

    /**
     * Get blockchain statistics.
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = $this->blockchainService->getBlockchainStats();

            return response()->json([
                'success' => true,
                'data' => $stats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve blockchain statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all blocks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $blocks = $this->blockRepository->getAllOrdered();

            return response()->json([
                'success' => true,
                'data' => $blocks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve blocks',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recent blocks.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function recent(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            $blocks = $this->blockchainService->getRecentBlocks($limit);

            return response()->json([
                'success' => true,
                'data' => $blocks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recent blocks',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get specific block.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $block = $this->blockRepository->findById($id);

            if (!$block) {
                return response()->json([
                    'success' => false,
                    'message' => 'Block not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'block' => $block,
                    'block_info' => $block->getBlockInfo(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve block',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get block by hash.
     *
     * @param string $hash
     * @return JsonResponse
     */
    public function findByHash(string $hash): JsonResponse
    {
        try {
            $block = $this->blockRepository->findByHash($hash);

            if (!$block) {
                return response()->json([
                    'success' => false,
                    'message' => 'Block not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'block' => $block,
                    'block_info' => $block->getBlockInfo(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve block',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify blockchain integrity.
     *
     * @return JsonResponse
     */
    public function verify(): JsonResponse
    {
        try {
            $isValid = $this->blockchainService->isChainValid();

            return response()->json([
                'success' => true,
                'data' => [
                    'chain_valid' => $isValid,
                    'message' => $isValid
                        ? 'Blockchain integrity verified successfully'
                        : 'Blockchain integrity compromised - chain is invalid',
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify blockchain',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get latest block.
     *
     * @return JsonResponse
     */
    public function latest(): JsonResponse
    {
        try {
            $block = $this->blockchainService->getLatestBlock();

            if (!$block) {
                return response()->json([
                    'success' => false,
                    'message' => 'No blocks found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'block' => $block,
                    'block_info' => $block->getBlockInfo(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve latest block',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get block by transaction ID.
     *
     * @param int $transactionId
     * @return JsonResponse
     */
    public function findByTransaction(int $transactionId): JsonResponse
    {
        try {
            $block = $this->blockchainService->findBlockByTransaction($transactionId);

            if (!$block) {
                return response()->json([
                    'success' => false,
                    'message' => 'Block not found for this transaction',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'block' => $block,
                    'block_info' => $block->getBlockInfo(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve block',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
