@extends('layouts.app')

@section('content')


<body>
    
<div class="container">
        <div class="row mt-5">
            <div class="col-md-4"></div>
            <div class="col-md-4 bg-light shadow-2 rounded">
                <div class="card-body p-3 pb-0">
                <h1 class="card-title text-center"> <img src="/assets/img/logo.png" height="90" width="90" class="img-circle" alt=""><br><h2><center><font color='#028738'><b>MANTAN</b></font></h2></h1>
                <p class="text-center" style="font-style: Helvetica">Maintain Standar</p> </center>
                    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox mt-1 pointer">
                                <input type="checkbox" class="custom-control-input" name="remember">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Remember Me</span>
                            </label>
                        </div>  
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-success w-100 mb-2" href="/signup">{{ __('Register') }}</a>
                       <div class='alert alert-success'><center><b>Pendaftaraan berhasil, silahkan menunggu akun Anda dikonfirmasi.</b></center></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>

@endsection
