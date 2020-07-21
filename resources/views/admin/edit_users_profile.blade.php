@extends('layouts.layout')

@section('content')
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- About Me Box -->
            <div class="card card-dark">
            <div class="card-header text-center p-2"><h5>Profil Pengguna</h5></div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="text-center">
              <img class="profile-user-img img-fluid img-circle elevation-1"
                  src="{{url('/assets/dist/img/logo.png')}}" 
                       alt="User profile picture">
              </div>
              @foreach($users as $user)
                <strong> Nama</strong>

                <p class="text-muted">
                {{$user->nama}}
                </p>

                <hr>

                
                <strong> Email </strong>

                <p class="text-muted">{{$user->email}}</p>

                <hr>

                
                <strong> Username</strong>

                <p class="text-muted">{{$user->username}}</p>

                <hr>


                <strong> Work Center </strong>

                <p class="text-muted">{{$user->work_center}}</p>

                <hr>

                
                <strong> Bagian </strong>

                <p class="text-muted">{{$user->bagian}}</p>

                <hr>


                <strong> Plant</strong>

                <p class="text-muted">{{$user->plant}}</p>

                <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8">
          
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

            <div class="card">
              <div class="card-header bg-dark text-center p-2">
                <h5>Ubah Profil Pengguna</h5><!-- /.card-header -->
              </div><!-- /.card-header -->
              <div class="card-body">  
                  <div class="col-sm-12 offset-1">
                  <div class="col-md-10">
                      <form action="/update/users/profile" method="POST">
                      {{csrf_field()}}
                    <p><input type="hidden" name="id" value="{{$user->id}}" class="form-control">
                    <input type="text" name="nama" value="{{$user->nama}}" placeholder="Nama" title="Nama" class="form-control"></p>
                    <br>
                    </div>
                    <div class="col-md-10">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="text" name="email" value="{{$user->email}}" placeholder="Email" title="Email" class="form-control">
                    </div>
                    <br>
         
                    </div>
                    <div class="col-md-10">
                    <input type="text" name="username" value="{{$user->username}}" placeholder="Username" title="Username" class="form-control">
                    <br>
                    </div>
                    <div class="col-md-10">
                    <select name="work_center" class="form-control" title="Work Center" required>
                        <option value="">~ Work Center ~</option>
                        @if($user->work_center == "ADMIN")
                        <option value="ADMIN" selected>ADMIN</option>
                        @else
                        <option value="ADMIN">ADMIN</option>
                        @endif
                        @if($user->work_center == "QC")
                        <option value="QC" selected>QC</option>
                        @else
                        <option value="QC">QC</option>
                        @endif
                        @if($user->work_center == "RND")
                        <option value="RND" selected>RND</option>
                        @else
                        <option value="RND">RND</option>
                        @endif
                    </select>                        
                    <br>

                    <select class="form-control" name="bagian" title="Bagian" required>
                    <option value="">~ Bagian ~</option>
                    @foreach($users as $u)
                        @foreach($bagian as $ba)
                            @if($ba->id_bagian == $u->bagian_id)
                            <option value="{{$ba->id_bagian}} " selected="selected">{{$ba->bagian}}</option>
                            @else
                            <option value="{{$ba->id_bagian}} ">{{$ba->bagian}}</option>
                            @endif
                    	@endforeach
                    @endforeach
					</select>
                    <br>
                    
                    <select name="plant" class="form-control" title="Work Center" required>
                        <option value="">~ Plant ~</option>
                        @if($user->plant == "ciawi")
                        <option value="ciawi" selected>Ciawi</option>
                        @else
                        <option value="ciawi">Ciawi</option>
                        @endif
                        @if($user->plant == "cibitung")
                        <option value="cibitung" selected>Cibitung</option>
                        @else
                        <option value="cibitung">Cibitung</option>
                        @endif
                        @if($user->plant == "sentul")
                        <option value="sentul" selected>Sentul</option>
                        @else
                        <option value="sentul">Sentul</option>
                        @endif
                    </select>               
                    <br>
                   
                    <button class="btn btn-primary">Simpan</button>
                    </form>

                    @endforeach

              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
    function Validate()
    {
      var password = document.getElementById('password').value;
      var cpassword = document.getElementById('password_confirm').value;
      if(password != cpassword)
      {
        $(password).html('data tidak sama');
      }
      return false;
    }
  </script>

<script type="text/javascript">
function myFunction()
{
  var password = $("#txtPassword").val();
                var confirmPassword = $("#txtConfirmPassword").val();
                if (password != confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }
                return true;
}
     
    </script>

@endsection

