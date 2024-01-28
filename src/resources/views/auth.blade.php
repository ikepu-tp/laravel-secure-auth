@extends('SecureAuth::layout')
@section('contents')
  <div class="row justify-content-center">
    <div class="col-auto bg-white rounded p-3 my-4">
      <p>
        登録メールアドレスに送信された2段階認証コードを入力してください。
      </p>
      @if (session('status'))
        <div class="alert alert-info">
          {{ session('status') }}
        </div>
      @endif
      @isset($status)
        <div class="alert alert-info">
          {{ $status }}
        </div>
      @endisset
      <form action="{{ route('__tfa.store') }}" method="post">
        @csrf
        <div>
          <label class="form-label">
            認証コード
            <input type="text" name="tfa_token" class="form-control mt-2 {{ session('error') ? 'is-invalid' : '' }}"
              placeholder="認証コードの入力" maxlength="6" autofocus required>
            <div class="invalid-feedback">
              @if (session('error'))
                {{ session('error') }}
              @endif
              <ul>
                @if ($errors->has('tfa_token'))
                  @foreach ($errors->get('tfa_token') as $error)
                    <li>
                      {{ $error }}
                    </li>
                  @endforeach
                @endif
              </ul>
            </div>
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
