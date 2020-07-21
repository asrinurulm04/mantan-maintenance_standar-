@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
    </div>
  </div><!-- /.container-fluid -->
  </section>
    
  <section class="content">
  <div class="card-header flat bg-secondary text-center">
		<h5 class="">Standar Freeze</h5>
	</div>
  @if( Session::get('alert') !="")
  <div class="card-header flat text-center p-2"> 
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
  </div>
  @endif
  <div class="card">
    <div class="card-body">
      <table class="table text-center data-table" id="users-table">
        <thead class="bg-secondary">
          <tr class="flex">
            <th>Nama Item</th>
            <th>Alasan</th>
            <th>Kode Oracle</th>
            <th>Stok</th>
            <th>Tgl.Expired</th>
            <th>Jenis Item</th>
            <th>Opsi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>  
</div>

@push('scripts')
<script>
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#users-table').DataTable({
      serverSide: true,
      ajax: '/standar/freeze/json',
      columns: [
        { data: 'nama_item', name: 'nama_item' },
        { data: 'status_rnd', name: 'status_rnd' },
        { data: 'kode_oracle', name: 'kode_oracle' },
        { data: 'stok_rnd', name: 'stok_rnd' },
        { data: 'tgl_kadaluarsa_rnd', name: 'tgl_kadaluarsa_rnd' },
        { data: 'jenis_item', name: 'jenis_item' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endpush
@endsection