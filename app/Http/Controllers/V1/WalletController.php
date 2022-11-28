<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WalletController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token !== '') {
            $this->user = JWTAuth::parseToken()->authenticate();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreWalletRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWalletRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateWalletRequest $request
     * @param \App\Models\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wallet $wallet
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
