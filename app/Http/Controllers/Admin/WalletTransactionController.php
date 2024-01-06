<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletTransactionCollection;
use App\Http\Resources\WalletTransactionResource;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    use ApiResponse;
    private const PerPage = 20;
    public function index()
    {
        $walletTransaction = WalletTransaction::with(['wallet', 'user'])->latest('id')->paginate(20);
        return $this->success(\Illuminate\Http\Response::HTTP_OK, 'success', WalletTransactionResource::collection($walletTransaction), true);
    }

    public function show($id)
    {
        $transaction = WalletTransaction::whereUuid($id)->first();
        if (!empty($transaction)){
            return $this->success(\Illuminate\Http\Response::HTTP_OK, 'success', (new WalletTransactionResource($transaction)));
        }
        return $this->error(\Illuminate\Http\Response::HTTP_BAD_REQUEST, 'failed', 'unable to retrieve');
    }

    /**
     * transaction by user
     * @param $id
     */
    public function user($id): \Illuminate\Http\JsonResponse
    {
        $transaction = WalletTransaction::with('user')->whereHas('user', function($q) use ($id) {
            $q->where('uuid', $id);
        })->paginate(self::PerPage);
        return $this->success(\Illuminate\Http\Response::HTTP_OK, 'success', $transaction, "user transaction retrieved" );
    }
}
