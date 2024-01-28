<?php

namespace ikepu_tp\SecureAuth\app\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Providers\RouteServiceProvider;
use ikepu_tp\SecureAuth\app\Http\Requests\WebRequest;
use ikepu_tp\SecureAuth\app\Http\Services\TfaService;
use Illuminate\Http\RedirectResponse;
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
    public function store(WebRequest $webRequest): RedirectResponse
    {
        if (!TfaService::attempt($webRequest->input("tfa_token"))) return back()->with("error", "認証コードが一致しません。");
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function resend()
    {
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