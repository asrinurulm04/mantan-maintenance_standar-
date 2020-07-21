@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row mt-5">
    <div class="col-md-4"></div>
    <div class="col-md-4 bg-light shadow-2 rounded">
      <div class="card-body p-3 pb-0">
        <h1 class="card-title text-center"> <img src="/assets/img/logo.png" height="50" width="50" class="img-circle" alt=""><br><h2><center><font color='#028738'><b>MANTAN</b></font></h2></h1>
        <hr><form class="form-horizontal" role="form" method="POST" action="/signup/store">
        {{ csrf_field() }}
        {{ method_field('post') }}
        <div class="form-group">
          <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Nama" required autofocus>
          @if ($errors->has('nama'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('nama') }}</strong>
          </span>
					@endif
        </div>
        <div class="form-group">
          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
          @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
					@endif
        </div>
        <div class="form-group">
          <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
          @if ($errors->has('username'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
          </span>
					@endif
        </div>
        <div class="form-group">
          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
          @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>          
        <div class="form-group">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
        </div>
        <div class="form-group">
          <select name="work_center" id="work_center" class="form-control{{ $errors->has('work_center') ? ' is-invalid' : '' }}" onchange='ganti()' id="workc" placeholder="Work Center" required>
            <option value="">~ Work Center ~</option>
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
        <div class="form-group">          
          <select name="bagian" id="bagian" class="form-control{{ $errors->has('bagian') ? ' is-invalid' : '' }}" id="bagian" placeholder="Bagian" required>
            <option value="">~ Bagian ~</option>
            @foreach($tb_bagian as $tb)
            <option value="{{$tb->id_bagian}}">{{$tb->bagian}}</option>
            @endforeach   
          </select>
        </div>   
        @if ($errors->has('bagian'))
        <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('bagian') }}</strong>
        </span>
        @endif
        <div class="form-group">
          <select name="plant" id="plant" class="form-control{{ $errors->has('plant') ? ' is-invalid' : '' }}" id="plant" placeholder="Plant" required>
            <option value="">~ Plant ~</option>
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
        <div class="form-group">
          <button type="submit" class="btn btn-primary w-100 mb-2">
            Sign Up
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection