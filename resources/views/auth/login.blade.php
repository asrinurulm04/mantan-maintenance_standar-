@extends('layouts.app')

@section('content')


<body>
<div class="container">
        <div class="row mt-5">
            <div class="col-md-4"></div>
            <div class="col-md-4 bg-light shadow-2 rounded">
                <div class="card-body p-3 pb-0">
                @if( Session::get('alert') !="")
                                <div class='alert alert-success'><center><b>{{Session::get('alert')}}</b></center></div>
                                
                                @endif
                                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                        <center><b>{{ session('status') }}</b></center>
                        </div>
                    @endif
<h1 class="card-title text-center"> <img src="/assets/img/logo.png" height="90" width="90" class="img-circle" alt=""><br><h2><center><font color='#028738'><b>MANTAN</b></font></h2></h1>
<p class="text-center" style="font-style: Helvetica">Maintenance Standar</p> </center>    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" autofocus type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="myInput">Password</label>
                           
                            
                            <div class="input-group input-group-xs">
                            <input id="myInput" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required data-toggle="password">
                              
                              <div class="input-group-append">
                                  <i onclick="myFunction()" class="fa fa-eye btn btn-primary" id="mata"></i>
                              </div>
                            </div>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                      
                       
<!--   

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                       
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                                    {{ __('Login') }}
                                </button>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <a href="/signup" class="btn btn-link">Create Account</a>
                                        </div>
                                        <div class="col-sm-6">
                                        <a data-toggle="modal" data-target="#exampleModal" href="{{ route('password.request') }}" class="btn btn-link">Forgot Password ?</a> 
                                        </div>
                                    </div>
                                </div>
                      
                    </form>
                </div>
            </div>
        </div>
    </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Reset Password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
               
                <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                <input id="email" type="email" placeholder="Email Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">

</script>

<script  src="/path/to/bootstrap-show-password.js"></script>

<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})


$("#password").password('toggle');

function myFunction() {
  var x = document.getElementById("myInput");
  var z = document.getElementById("mata");
  if (x.type=== "password") {
    x.type = "text";
    $("#mata").toggleClass("fa-eye-slash");
  } else if (x.type === "text") {
    x.type = "password";
    $("#mata").removeClass("fa-eye-slash");
  }
  
}



</script>
@endsection
