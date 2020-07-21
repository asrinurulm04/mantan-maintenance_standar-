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
              <h5>Histori Stok</h5>
            </div>
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
      <table class="table table-bordered text-center" id="users-table">
        <thead class="bg-secondary">
          <tr>
            <th>Nama Item</th>
            <th>Kode Oracle</th>
            <th>Lokasi</th>
            <th>Jenis Item</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>  
</div>

@push('scripts')
<script>
  $(function() {
    $('#users-table').DataTable({
      serverSide: true,
      ajax: '/history/pakai/json',
      columns: [
           
        { data: 'nama_item', name: 'nama_item' },
        { data: 'kode_oracle', name: 'kode_oracle' },
        { data: 'lokasi', name: 'lokasi' },
        { data: 'jenis_item', name: 'jenis_item' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>

@endpush
@endsection


