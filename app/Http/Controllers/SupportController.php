<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportResource;
use App\Models\Support;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $support = Support::first();
        return $this->success(Response::HTTP_OK, 'success', (new SupportResource($support)), 'retrieved support details');
    }

    public function update(Request $request)
    {
       $support = Support::first();
       if(empty($support)){
           Support::create($request->all());
       } else {
           $support->update($request->all());
       }
        return $this->success(Response::HTTP_OK, 'success', [], ' support details updated');
    }
}
