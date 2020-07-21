@extends('layouts.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
      </div>
    </div><!-- /.container-fluid -->
  </section>
    
<!-- Content Header (Page header) -->
  <section class="content">
    <div class="card">
    @if( Session::get('hapus') !="")
    <div class="card-header text-center p-2">
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert bg-success notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('hapus')}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
      </div>
    @endif
      <div class="card-body">
      <table class="table table-bordered text-center data-table" id="users-table">

      <thead class="bg-secondary">
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Username</th>
          <th>Work Center</th>
          <th>Bagian</th>
          <th>Action</th>
        </tr>

        
      </thead>

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
                            
                              <form method="POST" action="/ubah/users/profile" id="btnSubmit">
                             @foreach($users as $u)
                              <input type="hidden" name="id_user" value="{{Auth::user()->id}}" class="form-control">
                                   
                              <label for="nama"> Nama </label>
                              <input type="text" id="nama" name="nama" value="{{$u->nama}}" class="form-control" required>

                              <label for="email"> Email </label> 
                              <input type="password" id="email" name="email" class="form-control" required>

                              <label for="username"> Username </label>
                              <input type="password" id="username" name="username" class="form-control" required>
                              
                              <label for="work_center"> Work Center </label>
                              <input type="password" id="work_center" name="work_center" class="form-control" required>

                              <label for="plant"> Plant </label>
                              <input type="password" id="plant" name="plant" class="form-control" required>
                              
                              <button class=" mt-2 btn btn-primary xs" onclick="myFunction()">Change Password</button>
                              @endforeach
                               </form>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                              </div>
                          </div>
                      </div>           
    </table>
      </div>
    </div>  
  </div>


</div>

 
@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
       serverSide: true,
       ajax: '/user/json',
       columns: [
           
           { data: 'nama', name: 'nama' },
           { data: 'email', name: 'email' },
           { data: 'username', name: 'username' },
           { data: 'work_center', name: 'bagian'},
           { data: 'bagian', name: 'bagian' },
           {data: 'action', name: 'action', orderable: false, searchable: false}
       ]
    });
});
</script>
@endpush

@endsection


