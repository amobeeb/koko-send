<?php

namespace App\Http\Controllers\user;

use App\Actions\IncomingTransactionWebhookAction;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletTransactionCollection;
use App\Http\Resources\WalletTransactionResource;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    use ApiResponse;

    private const PAGE = 20;

    public function details($id)
    {
        $user = User::whereUuid($id)->first();
        if (!empty($user)) {
            return $this->success(Response::HTTP_OK, 'success', (new WalletResource($user->wallet)), 'retrieved user wallet details');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved user wallet detail');
        }
    }

    public function stats($id)
    {
        $totalCredit = AppHelper::totalWalletTransactionByType($id, 'credit');
        $totalDebit = AppHelper::totalWalletTransactionByType($id, 'debit');
        $stats = [
            'total_inflow' => number_format($totalCredit, 2),
            'total_outflow' => number_format($totalDebit, 2),
        ];

        return $this->success(Response::HTTP_OK, 'success', $stats, 'retrieved user wallet stats');

    }

    public function webhook(Request $request, IncomingTransactionWebhookAction $incomingTransaction)
    {
        if ($request->hasHeader('verif-hash')) {
            if ($request->header('verif-hash') == config('koko.FLW_WEBHOOK_SECRET')) {
                $incomingTransaction->execute($request->all());
            }
        }

    }

}
