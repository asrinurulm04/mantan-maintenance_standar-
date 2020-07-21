@extends('layouts.layout')
@section('content')

<style>
  .judul{
    background: #6892d6;
  }
  .notif{
    background-color: #286303 !important;
    color: white;
    font-weight: bold;
  }
</style>

<div class="content-wrapper">   
  <section class="content-header">
  <div class="container-fluid">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-3 text-center ">
          <div class="card">
            <div class="card-header judul text-white text-bold">
              <h5 style="color:#fff">Sub Kategori</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
      </div>
    </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-8 offset-2">
          @if( Session::get('alert') !="")
          <div class="col-sm-12">
            <div class="col-sm-12">
              <div class="alert bg-success alert-dismissible fade show" role="alert">
                <strong class="text-white">{{Session::get('alert')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
          </div>
          @endif
          @if( Session::get('gagal') !="")
          <div class="col-sm-12">
            <div class="col-sm-12">
              <div class="alert bg-danger alert-dismissible fade show" role="alert">
                <strong class="text-white">{{Session::get('gagal')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
          </div>
          @endif
          <div class="card">
            @if( Session::get('hapus') !="")
            <div class="card-header text-center p-2">
              <div class="col-sm-12">
                <div class="col-sm-12">
                  <div class="alert bg-secondary notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
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
              <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="simpan">Tambah Sub Kategori</button>
              <table class="table table-bordered text-center" id="users-table"><br><br>
                <thead class="bg-secondary">
                  <tr>
                    <th>Nama Sub Kategori</th>
                    <th>Status</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="/rnd/tambah/kategori" method="POST" >
                    {{csrf_field()}}
                    <input type="hidden" name="id_user" value="{{Auth::user()->id}}" class="form-control">
                    <label for="nama_kategori"> Nama Sub Kategori </label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" required>
                    <button class=" mt-2 btn btn-primary xs">Tambah</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>     
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

@push('scripts')
<script>
  $(function() {
    $('#users-table').DataTable({
      serverSide: true,
      ajax: '/rnd/kategori/json',
      columns: [
        { data: 'nama_kategori', name: 'nama_kategori' },
        { data: 'status', name: 'status' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endpush
@endsection