@extends('SecureAuth::layout')
@section('contents')
  <div class="row justify-content-center">
    <div class="col-auto bg-white rounded p-3 my-4">
      <p>
        登録メールアドレスに送信された2段階認証コードを入力してください。
      </p>
      <form action="{{ route('__tfa.store') }}" method="post">
        @csrf
        <div>
          <label class="form-label">
            認証コード
            <input type="text" name="tfa_token" class="form-control mt-2" placeholder="認証コードの入力" maxlength="6" autofocus
              required>
          </label>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">
            送信
          </button>
        </div>
      </form>
      <form action="{{ route('__tfa.resend') }}" method="post">
        @csrf
        <p>
          認証コードを再送しますか？
        </p>
        <button type="submit" class="btn btn-secondary">認証コードの再送</button>
      </form>
    </div>
  </div>
@endsection
