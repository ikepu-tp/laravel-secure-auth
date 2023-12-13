<?php

namespace ikepu_tp\SecureAuth\app\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use ikepu_tp\SecureAuth\app\Http\Requests\WebRequest;
use ikepu_tp\SecureAuth\app\Models\TFA;
use Illuminate\Http\Request;

class WebController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view("SecureAuth::auth");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebRequest $webRequest)
    {
        dd($webRequest->session()->get("__tfa"));
        return back()->with("errors", $webRequest->validated());
    }

    public function resend()
    {
        $tfa = new TFA();
        $tfa->generateTFA();
        $tfa->setTFA($tfa->toArray());
        return back()->with("status", "登録メールアドレスに認証コードを送信しました。");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebRequest $webRequest, string $user_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}