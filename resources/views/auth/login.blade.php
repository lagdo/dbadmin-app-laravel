@extends('auth.layout')

@section('pageTitle', __('Login'))

@section('pageContent')
                  <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf

                    <div class="form-floating mb-3">
                      <input class="form-control @error('email')is-invalid @enderror" id="inputEmail" type="email" name="email" placeholder="name@example.com" required autofocus />
                      <label for="inputEmail">{{ __('Email') }}</label>
                      <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    </div>

                    <div class="form-floating mb-3">
                      <input class="form-control @error('password')is-invalid @enderror" id="inputPassword" type="password" name="password" placeholder="Password" />
                      <label for="inputPassword">{{ __('Password') }}</label>
                      <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    </div>

                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" checked />
                      <label class="form-check-label" for="inputRememberPassword">{{ __('Remember Me') }}</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <span>&nbsp;</span>
                      {{-- <a class="small" href="password.html">{{ __('Forgot Your Password?') }}</a> --}}
                      <button type="submit" class="btn btn-primary" tabindex="4">{{ __('Login') }}</button>
                    </div>
                  </form>
@endsection
