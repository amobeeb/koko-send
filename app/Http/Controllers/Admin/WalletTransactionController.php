<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return $this->success(\Illuminate\Http\Response::HTTP_OK, 'success', WalletTransaction::latest('id')->paginate(20), true);
    }

    public function show($id)
    {
        $transaction = WalletTransaction::whereId($id)->first();
        if ($transaction){
            return $this->success(\Illuminate\Http\Response::HTTP_OK, 'success', $transaction);
        }
        return $this->success(\Illuminate\Http\Response::HTTP_BAD_REQUEST, 'success', $transaction);
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
