@extends('layouts.layout')
@section('content')
  
  <div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="ml-2">
          <h4>Profile</h4>
        </div>
      </div>
    </div><!-- /.container-fluid -->
    </section>

    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-body">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle elevation-1" src="{{url('/assets/dist/img/logo.png')}}" alt="User profile picture">
              </div>
              @foreach($users as $user)
              <strong> Nama</strong>
              <p class="text-muted">{{$user->nama}}</p>
              <hr>
              <strong> Email </strong>
              <p class="text-muted">{{$user->email}}</p>
              <hr>
              <strong> Username</strong>
              <p class="text-muted">{{$user->username}}</p>
              <hr>
              <strong> Level </strong>
              <p class="text-muted">{{$user->work_center}}</p>
              <hr>
              <strong> Plant</strong>
              <p class="text-muted">{{$user->plant}}</p>
              <hr>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center p-2">
              <h5>EDIT YOUR PROFILE</h5>
              @if( Session::get('alert') !="")
              <div class="col-sm-12">
                <div class="col-sm-12">
                  <div class="alert bg-success alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('alert')}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
              @endif
            </div><!-- /.card-header -->
            <div class="card-body">  
              <div class="col-sm-12 offset-1">
                <div class="col-md-10">
                  <form action="/admin/update/profile" onSubmit="cek()" method="POST">
                  {{csrf_field()}}
                  {{ method_field('post') }}
                  <p><input type="hidden" name="id" value="{{{Auth::user()->id}}}" class="form-control">
                  <input type="text" name="nama" value="{{{$user->nama}}}" data-tooltip="I’m the tooltip text." class="form-control"></p><br>
                </div>
                <div class="col-md-10">
                  <input type="text" name="email" value="{{{$user->email}}}" title="Email" class="form-control"><br>
                </div>
                <div class="col-md-10">
                  <input type="text" name="username" value="{{{$user->username}}}" placeholder="Username" title="Username" class="form-control"><br>
                </div>
                <div class="col-md-10">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                  @endif
                </div><br>
                <div class="col-md-10">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required><br>
                  <button class="btn btn-primary" id="simpan">Simpan Perubahan</button>
                  </form><br>    
                  @endforeach
                </div><!-- /.card-body -->
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>
    </div>
    </section>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection

