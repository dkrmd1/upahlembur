@extends('auth.layouts.main')
@section('container')
<input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="/assets/img/jb/5.JPG" alt="">
        <div class="text">
          <span class="text-1">Compliance & Internal Audit</span>
          <span class="text-2">PT BJB SEKURITAS JAWA BARAT</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form action="{{ route('login.auth') }}" method="POST">
            @csrf
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Sumbit">
              </div>
            </div>
        </form>
      </div>
    </div>
    </div>
@endsection
