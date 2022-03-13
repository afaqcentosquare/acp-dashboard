@extends('superadmin.auth.master', ['class' => 'bg-white'])

@section('content')
<div class="wrapper pt-5">
    <div class="card" style="border-radius: 20px;">
        <div class="row">
            <div class="col-md-5 ">
                <img src="{{asset('uploads/landscape.jpg')}}" alt="login" class="login-card-img" style="border-bottom-left-radius: 20px;object-fit: cover;border-top-left-radius: 20px;min-height:35vh">
            </div>
            <div class="col-md-7 px-md-5 mt-4">
                    <p class="login-card-description">
                        Sign in to your account
                    </p>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <form role="form" method="POST" action="{{route('superadmin.checklogin')}}">
                        @csrf
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}">
                            </div>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customCheckLogin">
                                <span class="text-muted">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">{{ __('Sign in') }}</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
    
@endsection
