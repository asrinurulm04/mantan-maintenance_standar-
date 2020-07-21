@extends('layouts.layout')
@section('content')
<style>
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
  button{
    cursor : pointer;
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
  <div class="container-fluid">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-3 text-center ">
          <div class="card">
            <div class="card-header flat judul text-white text-bold">
              <h5>Permintaan Order</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
  </section>

  <section class="content">
  <div class="card">
    <div class="card-body">
      <div class="latar text-white mt-5">
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
      </div>
<a href="{{route('download_order')}}" class="btn btn-info">Cetak Order</a>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- filter data -->
            <div class="card-block">
              <div class="panel-heading">
                <h4><li class="fa fa-filter"></li> Filter Permintaan</h4>
              </div>
              <div>
                <div>
                  <form id="clear">          
                  <!--project-->
                  <div class="row">
                    <div class="col-md-4 pl-1">
                    <div class="form-group" id="filter_col" data-column="2">
                      <label>Alasan</label>
                      <select name="name" class="form-control column_filter" id="col2_filter">
                        <option disabled selected>-->Select One<--</option>
                        <option>Pembaruan Standar</option>
                        <option>Kadaluarsa</option>
                        <option>Habis</option>
                        <option>Hampir Habis</option>
                        <option>Hampir Kadaluarsa</option>
                      </select>
                    </div>
                    </div>
                  <!--brand-->
                  <div class="col-md-4 pl-1">
                    <div class="form-group" id="filter_col1" data-column="5">
                      <label>Bagian Pemohon</label>
                      <select name="brand" class="form-control column_filter" id="col5_filter" >
                        <option disabled selected>-->Select One<--</option>
                        @foreach ($bagian as $item)
                        <option>{{$item->bagian}}</option>y
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <!--Data-->
                  <div class="col-md-1 pl-1">
                    <div class="form-group" id="filter_col1" data-column="5">
                      <label class="text-center">refresh</label>    
                      <a href="" class="btn btn-info btn-sm"><li class="fa fa-refresh"></li></a>
                    </div>
                  </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- filter data selesai -->
          </div>
      <table id="ex" class="Table table-bordered table-hover text-center">
        <thead class="bg-dark">
          <tr>
            <th>Nama Item</th>
            <th>Kode Oracle/Kode Formula</th>
            <th>Alasan</th>
            <th>Tanggal Order</th>
            <th>Pemohon</th>
            <th>Bagian</th>
            <th>Catatan Permintaan</th>
            <th width="10%">Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
          <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
          <tr>
            <td>{{$o->nama_item}}</td>
          <td>{{$o->kode_oracle}} {{$o->kode_formula}}</td>
            <td>
              @if($o->alasan == 'aktif')
              <span class="right text-white text-bold p-1 badge badge-info" style="color:#fff">Pembaruan Standar</span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @elseif($o->alasan == 'kadaluarsa')
              <span class="right text-white text-bold p-1 badge badge-danger" style="color:#fff"> Kadaluarsa </span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @elseif($o->alasan == 'habis')
              <span class="right text-white text-bold p-1 badge badge-danger" style="color:#fff"> Habis </span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @elseif($o->alasan == 'Hampir Habis')
              <span class="right text-white text-bold p-1 badge badge-danger" style="color:#fff"> Hampir Habis </span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @elseif($o->alasan == 'HampirKosong')
              <span class="right text-white text-bold p-1 badge badge-danger" style="color:#fff"> Hampir Habis </span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @elseif($o->alasan == 'hampirExpired')
              <span class="right text-white text-bold p-1 badge badge-danger" style="color:#fff"> Hampir Kadaluarsa</span> <input type="hidden" value="{{$o->alasan}}" name="alasan">
              @endif
            </td>
            <td>{{$o->tgl_order}}</td>
            <td>{{$o->pemohon}} </td>
            <td>{{$o->bagian}}</td>
            <td>{{$o->catatan}}</td>
            <td>
              @if($o->stat == 'pesan')
                @if(Auth::user()->work_center=="ADMIN")
                <div class="row offset-2">
                  <button disabled class="btn btn-primary btn-sm" title="Siap Kirim" ><i class="fa fa-send"></i></button>
                  <form action="{{route('rnd/order/batal')}}" method="post">
                  {{csrf_field()}}
                  <input type="hidden" value="{{ $o->id_order}}" name="id_order">
                  <input type="hidden" value="{{ $o->standar_id}}" name="id_standar">
                  <button disabled class="btn btn-danger btn-sm ml-2" title="Hapus/batalkan order" onclick="return confirm('Anda Yakin Ingin Membatalkan Order ini ?');"><i class="fa fa-trash"></i></button>
                  </form>
                </div>
                @else
                <div class="row offset-2">
                  <a href="/rnd/order/proses/{{$o->id_order}}" class="btn btn-primary btn-sm" title="Siap Kirim" ><i class="fa fa-send"></i></a>
                  <form action="{{route('rnd/order/batal')}}" method="post">
                  {{csrf_field()}}
                  <input type="hidden" value="{{ $o->id_order}}" name="id_order">
                  <input type="hidden" value="{{ $o->standar_id}}" name="id_standar">
                  <button class="btn btn-danger btn-sm ml-2" title="Hapus/batalkan order" onclick="return confirm('Anda Yakin Ingin Membatalkan Order ini ?');"><i class="fa fa-trash"></i></button>
                  </form>
                </div>
                @endif
              @elseif($o->stat == 'kirim')
                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                <span class='glyphicon glyphicon-ok'></span> Terkirim <span class='caret'></span></button>
                <ul class='dropdown-menu p-1' role='menu'>
                  <li><p align='left' title='Jumlah Pesan' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-user"></i> Pengirim : {{$o->pengirim}}&nbsp;</p></li>
                  <li><p align='left' title='Jumlah Pesan' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Jumlah Pesan : {{$o->jumlah_pesan}}&nbsp;</p></li>
                  <li><p align='left' title='Jumlah Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Jumlah Kirim : {{$o->jumlah_kirim}}&nbsp;</p></li>
                  <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-share-square"></i> Tgl. Kirim : {{$o->tgl_kirim}}</p></li>
                  <li role='separator' class='divider'></li>
                </ul>
              @elseif($o->stat == 'order_diterima')
                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                <i class="fa fa-check"></i>  Order Telah Diterima <span class='caret'></span>
                <ul class='dropdown-menu p-1' role='menu'>
                  <li><p align='left' title='Pengirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-user"></i> Pengirim : {{$o->pengirim}} &nbsp;</p></li>
                  <li><p align='left' title='Penerima' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-users"></i> Penerima : {{$o->penerima}} &nbsp;</p></li>
                  <li><p align='left' title='Jumlah Pesan' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Jumlah Pesan : {{$o->jumlah_pesan}}&nbsp;</p></li>
                  <li><p align='left' title='Jumlah Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Jumlah Kirim : {{$o->jumlah_kirim}}&nbsp;</p></li>
                  <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-share-square"></i> Tgl. Kirim : {{$o->tgl_kirim}}</p></li>
                  <li><p align='left' title='Tanggal Diterima' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-download"></i> Tgl. Diterima : {{$o->tgl_diterima}}</p></li>
                  <li role='separator' class='divider'></li>
                  <li>
                  <!-- <a href='/rnd/order/terkirim/hapus/{{$o->id_order}}' class='btn btn-default btn-danger col-12'  data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a> -->
                  </li>
                </ul>
              @endif 
            </td>
          </tr>
          @endforeach
          </form>
        </tbody>
      </table>
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