@extends('layouts.layout')
@section('content')

<style>
  #keyword2{
     margin-left: 160px !important;
  }
  #number {
    width: 5.9em;
  }
  #lokasi {
  width: 5.9em;
  }
  .pesan{
    background: #a5adba;
  }
  .judul{
    background: #6892d6;
  }
  .notif{
    background-color: #286303 !important;
    color: white;
    font-weight: bold;
  }
  table{
    font-size: 13px !important;
  }
</style>

<div class="content-wrapper bg-aktif">
  <section class="content-header">
  <div class="container-fluid">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-3 text-center ">
          <div class="card">
            <div class="card-header judul text-white text-bold">
              <h5>Bahan Baku</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
  </section>
  <section class="content">

  <div class="latar text-white mt-5">
    @if( Session::get('cekStok') !="")
    <div class="col-sm-12">
      <div class="col-sm-12">
        <div class="alert bg-success alert-dismissible fade show" role="alert">
          <strong class="text-white">{{Session::get('cekStok')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
    @endif
        
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

    @if( request('nama') == "" )
    @elseif( $standar->total()== 0 )
    <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
      Menampilkan data dengan pencarian <strong class="text-danger">{{request('nama')}}</strong> | <strong class="text-danger"> Hasil Tidak Ditemukan </strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @else
    <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
      Menampilkan data dengan pencarian <strong class="text-danger">{{request('nama')}}</strong> | <strong class="text-danger">{{ $standar->total() }}</strong> data ditemukan 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif        
          
    @if( request('keyword') == "" )
    @elseif( $standar->total()== 0 )
    <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
      Menampilkan data dengan status <strong class="text-danger">{{request('keyword')}} </strong>| <strong class="text-danger"> Hasil Tidak Ditemukan </strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @else
    <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
      Menampilkan data dengan status <strong class="yg">{{request('keyword')}}</strong> | <strong class="text-danger">{{ $standar->total() }}</strong> data ditemukan 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif   
  </div>
   
  <div class="card">
    <div class="card-body">
      @if(Auth::user()->work_center == 'ADMIN')
      <table id="ex" class="Table table-bordered text-center mb-5">        
        <thead class="text-dark text-bold">
          <tr>
            <th>Nama Item Standar</th>
            <th>Kode Oracle</th>
            <th>Stok</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Tanggal Kadaluarsa</th>
            <th>Tanggal Terima</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $standar as $s )
          <input type="hidden" name="alasan" value="{{$s->status_qc}}" >
          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">   
          <tr class="bg-aktif">
            @if($s->status_qc =='aktif')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              <span class="right badge badge-info">{{$s->status_qc}}</span>
            </td>        
            @elseif ($s->status_qc =='kadaluarsa')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-danger">{{$s->status_qc}}</span>
            </td>
            @elseif ($s->status_qc =='habis')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-danger">habis</span>
            </td>                
            @elseif ($s->status_qc =='HampirKosong')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-pink">hampir habis</span>
            </td>  
            @elseif ($s->status_qc =='hampirExpired')
            <td>
              @if($s->kondisi =='keranjang')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">List keranjang | {{$s->nama}} </span>
              @elseif($s->kondisi =='order')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">Standar Sudah di Order | {{$s->nama}} </span>
              @elseif($s->kondisi =='proses_kirim')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">Sedang di proses | {{$s->nama}} </span>
              @else
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}" > 
                <span class="right badge badge-warning">hampir kadaluarsa </span>
              @endif
            </td>
            @elseif ($s->status_qc =='hampirExpired')
            <td>
              @if($s->kondisi =='keranjang')
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              <span class="right badge badge-info">List keranjang | {{$s->nama}} </span>
              @elseif($s->kondisi =='proses_kirim')
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              <span class="right badge badge-info">Sedang di proses | {{$s->nama}} </span>
              @else
              {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              @endif    
            </td>
            @endif
            <form action="/qc/terpakai" method="post" onSubmit="cek()">       
            {{ csrf_field() }}         
            <td>{{$s->kode_oracle}}  <input type="hidden" name="nama_item" value="{{$s->kode_oracle}}"> </td>  
            <td> {{$s->stok_qc}} gram<input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>
            <td><?php echo (ceil($s->stok_qc / $s->serving_size))?> {{$s->satuan}} </td>
			      <input type="hidden" name="id_standar" value="{{ $s->id_standar }}">     
            <td>
              @if($s->status_qc == 'kadaluarsa')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'hampirExpired' )
              <input type="text" id="lokasi" class="disabled form-control" size="1" name="lokasi" disabled>     
              @elseif($s->status_qc == 'habis')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'HampirKosong')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'aktif')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @endif
            </td>
            </form>
            <td><input type="text" value="{{$s->tgl_kadaluarsa_qc}}" style="width:130px !important" disabled class="disabled form-control" size="1"></td>
            <td><input type="text" value="{{$s->tgl_terima}}" style="width:130px !important" disabled class="disabled form-control" size="1"></td>
          </tr>
          @endforeach
        </tbody> 
      </table>    
      {{ $standar->links() }}
      @else
      <table id="ex" class="Table table-bordered ">
        <thead class="text-dark text-bold">
          <tr>
            <th>Nama Item Standar</th>
            <th>Kode Oracle</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Tanggal Kadaluarsa</th>
            <th>Tanggal Terima</th>
            <th width="8%">Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $standar as $s )    
          <input type="hidden" name="alasan" value="{{$s->status_qc}}" >
          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">   
          <tr class="bg-aktif">
            @if($s->status_qc =='aktif')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              <span class="right badge badge-info">{{$s->status_qc}}</span>
            </td>          
            @elseif ($s->status_qc =='kadaluarsa')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-danger">{{$s->status_qc}}</span>
            </td>
            @elseif ($s->status_qc =='habis')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-danger">habis</span>
            </td>            
            @elseif ($s->status_qc =='HampirKosong')
            <td>
              {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
              <span class="right badge badge-info">hampir habis</span>
            </td>
            @elseif ($s->status_qc =='hampirExpired')
            <td>
              @if($s->kondisi =='keranjang')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">List keranjang | {{$s->nama}} </span>
              @elseif($s->kondisi =='order')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">Standar Sudah di Order | {{$s->nama}} </span>
              @elseif($s->kondisi =='proses_kirim')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">Sedang di proses | {{$s->nama}} </span>
              @else
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}" > 
                <span class="right badge badge-warning">hampir kadaluarsa </span>
              @endif
            </td>
            @elseif ($s->status_qc =='hampirExpired')
            <td>
              @if($s->kondisi =='keranjang')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">List keranjang | {{$s->nama}} </span>
              @elseif($s->kondisi =='proses_kirim')
                {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                <span class="right badge badge-info">Sedang di proses | {{$s->nama}} </span>
              @else
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
              @endif  
            </td>
            @endif
            <td>{{$s->kode_oracle}}  <input type="hidden" name="nama_item" value="{{$s->kode_oracle}}"> </td>
            <form action="/qc/terpakai" method="post" onSubmit="cek()">
            <td><?php echo (ceil($s->stok_qc / $s->serving_size))?> {{$s->satuan}} <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>
            <td>
              @if($s->status_qc == 'kadaluarsa')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'hampirExpired' )
              <input type="text" id="lokasi" class="disabled form-control" size="1" name="lokasi" disabled>     
              @elseif($s->status_qc == 'habis')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'HampirKosong')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @elseif($s->status_qc == 'aktif')
              <input type="text" id="lokasi" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @endif
            </td>
            <td><input type="text" value="{{$s->tgl_kadaluarsa_qc}}" style="width:130px !important" disabled class="disabled form-control" size="1"></td>
            <td><input type="text" value="{{$s->tgl_terima}}" style="width:130px !important" disabled class="disabled form-control" size="1"></td>
            <td>
              @if($s->status_qc == 'kadaluarsa')
              <button class=" disabled btn btn-primary btn-sm" id="pakai"><i class="fa fa-pencil"></i></button> 
              @elseif($s->status_qc == 'hampirExpired')
              <a href="/qc/pakai/stok/{{$s->id_standar}}" class="tooltips btn btn-primary btn-sm" required id="pakai"><i class="fa fa-pencil"></i><span>Gunakan Stok</span></a> 
              @elseif($s->status_qc == 'habis')
              <button class="disabled btn btn-primary btn-sm" id="pakai"><i class="fa fa-pencil"></i></button> 
              @elseif($s->status_qc == 'HampirKosong')
              <a href="/qc/pakai/stok/{{$s->id_standar}}" class="tooltips btn btn-primary btn-sm" required id="pakai"><i class="fa fa-pencil"></i><span>Gunakan Stok</span></a> 
              @elseif($s->status_qc == 'aktif')
              <a href="/qc/pakai/stok/{{$s->id_standar}}" class="tooltips btn btn-primary btn-sm" required id="pakai"><i class="fa fa-pencil"></i><span>Gunakan Stok</span></a> 
              @else
              @endif
              <a href='/qc/stok/baku/tambah/{{$s->id_standar}}' title="Edit" class="tooltips btn btn-sm btn-primary"><i class="fa fa-plus"></i><span> Tambah Stok </span></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>    
      @endif
    </div>
  </div>
</div>
@endsection
 
@push('scripts')
<script>
  function filterGlobal () {
     $('#ex').DataTable().search(
         $('#global_filter').val(),
     
     ).draw();
     }
     
     function filterColumn ( i ) {
         $('#ex').DataTable().column( i ).search(
             $('#col'+i+'_filter').val()
         ).draw();
     }
     
     $(document).ready(function() {
         $('#ex').DataTable();
         
         $('input.global_filter').on( 'keyup click', function () {
             filterGlobal();
         } );
     
         $('input.column_filter').on( 'keyup click', function () {
             filterColumn( $(this).parents('div').attr('data-column') );
         } );
     } );
 
         $('select.column_filter').on('change', function () {
             filterColumn( $(this).parents('div').attr('data-column') );
         } );
 </script>
@endpush