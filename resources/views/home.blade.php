@extends('layouts.layout')
@section('content')
  
<div class="content-wrapper"><br>
  <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">     
        <div class="card card-dark">
          <div class="card-header text-center p-2"><h5>My Profile</h5></div>
          <div class="card-body">
            <div class="text-center">  
              <img class="profile-user-img img-fluid img-circle elevation-1" src="{{url('/assets/dist/img/logo.png')}}" alt="User profile picture">
            </div>

            @foreach($users as $user)
            <strong> Nama</strong>
            <p class="text-muted">{{$user->nama}}</p><hr>
            <strong> Email </strong>
            <p class="text-muted">{{$user->email}}</p><hr>
            <strong> Username</strong>
            <p class="text-muted">{{$user->username}}</p><hr>
            <strong> Work Center </strong>
            <p class="text-muted">{{$user->work_center}}</p><hr>
            <strong> Bagian </strong>
            <p class="text-muted">{{$user->bagian}}</p><hr>
            <strong> Plant</strong>
            <p class="text-muted">{{$user->plant}}</p><hr>
           </div>
        </div>
      </div>
      <div class="col-md-8">
        @if( Session::get('ubahPassword') !="")
        <div class="alert bg-secondary notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
          <strong class="text-white">{{Session::get('ubahPassword')}} </strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if( Session::get('alert') !="")
        <div class="alert bg-secondary notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
          <strong class="text-white">{{Session::get('alert')}} </strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <div class="card">
          <div class="card-header bg-dark text-center p-2">
            <h5>Edit Your Profile</h5>
          </div><!-- /.card-header -->
          <div class="card-body">  
            <div class="col-sm-12 offset-1">
              <div class="col-md-10">
                <form action="/update/profile" onSubmit="cek()" method="POST">
                {{csrf_field()}}
                <p><input type="hidden" name="id" value="{{Auth::user()->id}}" class="form-control">
                <!-- <input type="text" readonly name="nama" value="{{$user->nama}}" placeholder="Nama" title="Nama" class="form-control"></p><br>
                <div class="col-md-10">
                  <input type="text" name="email" value="{{$user->email}}" title="Email" placeholder="Email" class="form-control"><br>
                </div> -->
                <div class="col-md-10">
                  <input type="text" name="username" value="{{$user->username}}" placeholder="Username" title="Username" class="form-control"><br>
                </div>
                <div class="col-md-10">
                  <input type="password" value="" title="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                  @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div><br>
                <div class="col-md-10">
                  <input type="password" title="Konfirmasi Password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required><br>
                  <button class="btn btn-primary" id="simpan">Save</button>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  id="simpan">Change Password ?</button> 
                </div>
                </form>
              </div>
              @endforeach
       
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="/ubah/password" onsubmit="return cekStok()">
                      {{csrf_field()}}
                      <input type="hidden" name="id_user" value="{{Auth::user()->id}}" class="form-control">
                      <label for="password_lama"> Password </label>
                      <input type="password" id="password_lama" name="password_lama" class="form-control" required>
                      <label for="password"> New Password </label> 
                      <input type="password" id="password" name="password" class="form-control" required>
                      <label for="password_confirm"> Confirm Password </label>
                      <input type="password" id="password_confirm" name="password_confirmation" class="form-control" required>
                      <button class=" mt-2 btn btn-primary xs">Change Password</button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div><br>    
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        @if(Auth::user()->work_center == 'ADMIN')
        <div class="card">
          <div class="card-header bg-dark  p-2">
          <h5>
            <li class="fa fa-comments-o"></li> Terdapat {{$app}} pengajuan akun user
            <a href="data/user/belum/aktif" class="btn btn-info"><li class="fa fa-folder-o"></li> Lihat Pengajuan</a></h5>
          </div><!-- /.card-header -->
          <!-- /.nav-tabs-custom -->
        </div>
        @endif
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  </section>
</div>

<script type="text/javascript">

  function cekStok(){
    var stok = document.getElementById('password').value;
    var terpakai = document.getElementById('password_confirm').value;
    if (stok != terpakai) {
      alert("Maaf konfirmasi password tidak cocok");    
      return false;
    }else{
      return true;
    }
  }

</script>

@endsection