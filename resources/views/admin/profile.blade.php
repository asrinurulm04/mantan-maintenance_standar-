@extends('layouts.layout')

@section('content')

  
<style>
body {
  font-family: sans-serif;
}

h1 {
  text-align: center;
}

label {
  display: inline-block;
  width: 5em;
}
/* Add this attribute to the element that needs a tooltip */
[data-tooltip] {
  position: relative;
  z-index: 2;
}

/* Hide the tooltip content by default */
[data-tooltip]:before,
[data-tooltip]:after {
  visibility: hidden;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity: 0;
  pointer-events: none;
}

/* Position tooltip above the element */
[data-tooltip]:before {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-bottom: 5px;
  margin-left: -80px;
  padding: 7px;
  width: 160px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background-color: #000;
  background-color: hsla(0, 0%, 20%, 0.9);
  color: #fff;
  content: attr(data-tooltip);
  text-align: center;
  font-size: 14px;
  line-height: 1.2;
}

/* Triangle hack to make tooltip look like a speech bubble */
[data-tooltip]:after {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-left: -5px;
  width: 0;
  border-top: 5px solid #000;
  border-top: 5px solid hsla(0, 0%, 20%, 0.9);
  border-right: 5px solid transparent;
  border-left: 5px solid transparent;
  content: " ";
  font-size: 0;
  line-height: 0;
}

/* Show tooltip content on hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
  opacity: 1;
}
</style>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="ml-2">
            <h4>Profile</h4>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

         

            <!-- About Me Box -->
            <div class="card card-primary">
             
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


                <strong> Level </strong>

                <p class="text-muted">{{$user->work_center}}</p>

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
            <div class="card">
           
              <div class="card-header text-center p-2">
                <h5>EDIT YOUR PROFILE</h5>
                @if( Session::get('alert') !="")
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="alert bg-secondary notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
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
                    <input type="text" name="nama" value="{{{$user->nama}}}" data-tooltip="I’m the tooltip text." class="form-control"></p>
                    <br>
                    </div>
                    <div class="col-md-10">
                    <input type="text" name="email" value="{{{$user->email}}}" title="Email" class="form-control">
                    <br>
                    </div>
                    <div class="col-md-10">
                    <input type="text" name="username" value="{{{$user->username}}}" placeholder="Username" title="Username" class="form-control">
                    <br>
                    </div>
                    <div class="col-md-10">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="col-md-10">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        <br>
                    <button class="btn btn-primary" id="simpan">Simpan Perubahan</button>
                    </form>
                    
                    <br>    
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
//   function cek()
//   {
//     var password = document.getElementById('password').value;
//     var cpassword = document.getElementById('cpassword').value;

//     if(password != cpassword){
//       return false;
//     }else if(stok < terpakai){
//       return alert('Stok tidak cukup');
//       return false;
//     }
//   }
//   $('#password, #cpassword,#simpan').on('keyup', function () {

//     if ($('#password').val() == $('#cpassword').val()) {
//     $('#message').html('Matching').css('color', 'green');
//     $('#simpan').prop('disabled',false);
//   } 
//   else if
//     ($('#cpassword').val() =="" ){
//         $('#message').html('');
//   } else 
//     $('#message').html('Not Matching').css('color', 'red'),
//     $('#simpan').prop('disabled',true);
  
    
// });



  </script>

<script type="text/javascript">
    $(document).ready(function() {

$(document).tooltip();

});
</script>

@endsection

