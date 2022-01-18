@extends('layouts.design')

@section('title', 'Forget Password')

@section('content')
<main class="login-form">
  <div class="cotainer">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Reset Password</div>
          <div class="card-body">

            <form action="{{ route('forget.password.post') }}" method="POST">
              @csrf
              <div class="form-group row mb-3">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">
                  E-Mail Address
                </label>
                <div class="col-md-6">
                  <input type="text" id="email_address" class="form-control @error('email') is-invalid @enderror" 
                    name="email" autofocus value="{{ old('email') }}">
                  @if ($errors->has('email'))
                  <span class="text-danger">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Send Password Reset Link
                </button>
                <a href="#" id="back" class="btn btn-danger">Back to Log in</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection