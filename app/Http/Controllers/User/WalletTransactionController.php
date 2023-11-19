<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletTransactionResource;
use App\Models\WalletTransaction;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletTransactionController extends Controller
{
    use ApiResponse;

    private const PAGE = 20;

    public function details($id)
    {
        $transaction = WalletTransaction::whereUuid($id)->first();
        if (!empty($transaction)) {
            return $this->success(Response::HTTP_OK, 'success', (new WalletTransactionResource($transaction)), 'retrieved transactions');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved user transaction');
        }
    }

    public function transactions($id)
    {
        $transactions = WalletTransaction::whereHas('user', function ($q) use ($id) {
            $q->where('uuid', $id);
        })->paginate(self::PAGE);

        if (!empty($transactions)) {
            return $this->success(Response::HTTP_OK, 'success', (WalletTransactionResource::collection($transactions)), 'retrieved transactions', true);
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved user wallet detail');
        }
    }


}
