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
              <h5 style="color:#fff">Keranjang Order</h5>
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
      <div class="row ml-1">
        <form action="/rnd/cari/tanggal/order/unrequest" method="GET" class="form-inline mr-2">
        <div class="form-group">
          <select name="status" class="form-control" title="Status Pengiriman">
            <option value="">Semua</option>
            @if( request('stat') =='kirim_unrequest' )
            <option value="kirim_unrequest" selected>Order terkirim ke QC </option>
            @else
            <option value="kirim_unrequest" >Order terkirim ke QC</option>
            @endif
                        
            @if( request('stat') =='order_unrequest_diterima' )
            <option value="order_unrequest_diterima" selected>Order telah diterima oleh QC </option>
            @else
            <option value="order_unrequest_diterima">Order telah diterima oleh QC </option>
            @endif

            @if( request('stat') =='keranjangrd' )
            <option value="keranjangrd" selected>Order Belum Dikirim</option>
            @else
            <option value="keranjangrd">Order Belum Dikirim</option>
            @endif
          </select>
          @if( request('dari_tanggal') !='' )
            <input type="date" name="dari_tanggal" class="form-control" tooltip="Dari Tanggal" required class="ml-2" value="{{request('dari_tanggal')}}">
          @else
          <input type="date" name="dari_tanggal" class="form-control" tooltip="Dari Tanggal" class="ml-2" id="aktif" class="ml-2" required>
          @endif
          @if( request('ke_tanggal') !='' )
            <input type="date" name="ke_tanggal" class="form-control" tooltip="Ke Tanggal" required class="ml-2" value="{{request('ke_tanggal')}}">
          @else
          <input type="date" name="ke_tanggal" class="form-control" tooltip="Ke Tanggal" class="ml-2" id="aktif" class="ml-2" required>
          @endif
          <button class="btn btn-primary ml-2">Filter</button>
        </div>
        </form>
      </div><br>
    <a href="{{route('cetakkeranjang')}}" class="btn btn-success btn-sm"> Cetak label All Data Keranjang Order</a><br><br>
      <table id="example1" class="Table table-bordered table-hover text-center">
        <thead class="bg-dark">
          <tr>
            <th>Nama Item</th>
            <th>Kode Oracle/Kode Formula</th>
            <th>Tgl</th>
            <th>Jenis Item</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
          <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
          <tr>
            <td>{{$o->nama_item}}</td>
          <td>{{$o->kode_oracle}}/{{$o->kode_formula}}</td>
            <td>{{$o->tgl_order}} </td>
            <td>{{$o->jenis_item}} </td>
            <td>
              @if($o->stat == 'keranjangrd')
              <div class="row offset-4">
                <a href="/rnd/order/proses/unrequest/{{$o->id_order}}" title="Siap Kirim" class="btn btn-primary"><i class="fa fa-send"></i></a>
                <form action="/rnd/order/unrequest/batal" method="post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_order" value="{{$o->id_order}}"> 
                  <button class="btn btn-danger ml-1" title="Hapus/batalkan permintaan" onclick="return confirm('Anda yakin ingin membatalkan order ini ?')"><i class="fa fa-times"></i></button>
                </form>
              </div>
              @elseif($o->stat == 'kirim_unrequest')
              <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
              <span class='glyphicon glyphicon-ok'></span> Terkirim <span class='caret'></span></button>
              <ul class='dropdown-menu' role='menu'>
                <li><p align='left' title='Pengirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-user"></i> Pengirim : {{$o->pengirim}}&nbsp;</p></li>
                <li><p align='left' title='Jumlah Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-share"></i> Kirim : {{$o->jumlah_kirim}}&nbsp;</p></li>
                <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-share-square"></i> Tgl. Kirim : {{$o->tgl_kirim}}</p></li>
                <li role='separator' class='divider'></li>
                <li>
                <!-- <a href='/rnd/order/terkirim/hapus/{{$o->id_order}}' class='btn btn-default btn-danger col-12'  data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a> -->
                </li>
              </ul>
              @elseif($o->stat == 'order_unrequest_diterima')
              <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
              <i class="fa fa-check"></i>  Order Telah Diterima <span class='caret'></span>
              <ul class='dropdown-menu' role='menu'>
                <li><p align='left' title='Jumlah Pesan' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-user-ul"></i> Pengirim : {{$o->pengirim}}&nbsp;</p></li>
                <li><p align='left' title='Pengirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-users"></i> Penerima : {{$o->penerima}}&nbsp;</p></li>
                <li><p align='left' title='Jumlah Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Jumlah Kirim : {{$o->jumlah_kirim}}&nbsp;</p></li>
                <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-share-square"></i> Tgl. Kirim : {{$o->tgl_kirim}}</p></li>
                <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-download"></i> Tgl. Diterima : {{$o->tgl_diterima}}</p></li>
                <li role='separator' class='divider'></li>
                <li>
                <!-- <a href='/rnd/order/terkirim/hapus/{{$o->id_order}}' class='btn btn-default btn-danger col-12'  data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a> -->
                </li>
              </ul>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>          
  </div>
  </div>
@endsection