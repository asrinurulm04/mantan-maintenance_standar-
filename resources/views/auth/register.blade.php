@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Nama" required autofocus>

                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <select name="work_center" id="work_center" class="form-control{{ $errors->has('work_center') ? ' is-invalid' : '' }}" onchange='ganti()' id="workc" placeholder="Work Center" required>
                                <option value="ADMIN">Admin</option>
                                <option value="QC">QC</option>
                                <option value="RND">RND</option>
                            </select>
                                @if ($errors->has('work_center'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('work_center') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                            <select name="bagian" id="bagian" class="form-control{{ $errors->has('bagian') ? ' is-invalid' : '' }}" id="bagian" placeholder="Bagian" required>
                                <option value="1">Baku A</option>
                                <option value="2">Baku B</option>
                                <option value="3">Baku E</option>
                                <option value="4">Baku F</option>
                                <option value="5">Powder Dairy</option>
                                <option value="6">Powder non-Dairy</option>
                                <option value="7">Powder E</option>
                                <option value="8">Powder F</option>
                                <option value="9">Baku Sentul</option>
                                <option value="10">None</option>
                            </select>
                                @if ($errors->has('bagian'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bagian') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    
                       

                        <div class="form-group row">
                            

                            <div class="col-md-6 offset-3">
                                <select name="plant" id="plant" class="form-control{{ $errors->has('plant') ? ' is-invalid' : '' }}" id="plant" placeholder="Plant" required>
                                <option value="ciawi">Ciawi</option>
                                <option value="sentul">Sentul</option>
                                <option value="cibitung">Cibitung</option>
                            </select>
                                @if ($errors->has('plant'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('plant') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                      

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function ganti() {
            var x = document.getElementById("workc").value;
            if(x=="QC"){
                document.getElementById("bagian").style.display="block";
                document.getElementById("plant").style.display="block";
            }
            else {
                document.getElementById("bagian").style.display="none";
                document.getElementById("plant").style.display="none";
            }
        }

</script>