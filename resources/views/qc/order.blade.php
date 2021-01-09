@extends('layouts.layout')
@section('content')

<style>
  #jumlah_serving{
    width: 120px !important;
    margin-left: 30px !important;
  }
  .judul{
    background: #6892d6;
  }
  .notif{
      background-color: #286303 !important;
      color: white;
      font-weight: bold;
    }
</style>

<body onload="myFunction()">
  
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6 offset-3 text-center ">
            <div class="card">
              <div class="card-header judul text-white text-bold">
                <h5>Keranjang Order</h5>
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
        @if( Session::get('orderGagal') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-danger alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('orderGagal')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        @endif
  
        @if(Auth::user()->work_center == "ADMIN")
        @if($orders->count() == "")
        <table id="example1" class="table table-bordered table-hover text-center">
          <thead class="bg-secondary">
            <tr>
              <th>Nama Item</th>
              <th>Kode Formula</th>
              <th>Alasan</th>
              <th>Serving Size</th>
              <th colspan="2">Jumlah Pesan</th>
              <th>Pemohon</th>
              <th>Opsi</th>
            </tr>
            <tr>
              <td colspan ="8" class="bg-secondary text-white">Tidak Ada Order</td>
            </tr>
        </table>
        @else

        <table id="example1" class="table table-bordered table-hover text-center mt-5">
          <thead class="bg-secondary">
            <tr>
              <th>Nama Item</th>
              <th>Kode Formula</th>
              <th>Alasan</th>
              <th>Serving Size</th>
              <th colspan="2">Jumlah Pesan</th>
              <th>Pemohon</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
          @foreach($orders as $o)
          <form action="/qc/order/kirim/satu/post" method="post">
            {{csrf_field()}}
            <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
            <input type="hidden" name="id_order" value="{{$o->id_order}}">
            <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
            <input type="hidden" value="{{$o->status_qc}}" name="alasan">
            <tr>
              <td>{{$o->nama_item}}</td>
              <td>{{$o->kode_formula}}</td>
              <td>
                @if($o->status_qc == 'aktif')
                <span class="right text-white text-bold p-1 badge badge-info">Pembaruan Standar</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                @elseif($o->status_qc == 'kadaluarsa')
                <span class="right text-white text-bold p-1 badge badge-danger"> Kadaluarsa </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                @elseif($o->status_qc == 'habis')
                <span class="right text-white text-bold p-1 badge badge-danger"> Habis </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                @elseif($o->status_qc == 'HampirKosong')
                <span class="right text-white text-bold p-1 badge badge-danger"> Hampir Kosong </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                @elseif($o->status_qc == 'hampirExpired')
                <span class="right text-white text-bold p-1 badge badge-warning"> Hampir Kadaluarsa </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                @endif
              </td>
              <td>{{$o->serving_size}} </td>
              <td>{{$o->jumlah_pesan}} gram</td>
              <td><?php echo floor($o->jumlah_pesan / $o->serving_size) ?> {{$o->satuan}} <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan"></td>
              <td>{{$o->pemohon}} - {{$o->bagian}} </td>
              <td>
                <div class="row"></div>
                @if($o->stat == 'pesan')
                <a class='btn btn-default'>
                  <i class="fa fa-check"></i> Order Terkirim<span class='caret'></span>
                </a>
                @elseif($o->stat == 'batal')
                <a class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                <span class='glyphicon glyphicon-ok'></span> Dibatalkan RND <span class='caret'></span></a>
                <ul class='dropdown-menu' role='menu'>
                  <li role='separator' class='divider'></li>
                  <li class="p-2">
                  <a href='/qc/order/hapus/satu/{{$o->id_order}}' onclick="return confirm('Anda yakin ingin membatalkan order ini ?')" class='btn btn-danger btn-danger col-12' data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a>
                  </li>
                </ul>
                @elseif($o->stat == 'keranjang')
                <div class="row offset-1">
                  <button class="tooltips btn btn-primary btn-sm"><span>Kirim Order</span> </button>
                  </form>
                  <form action="/qc/order/hapus/satu" method="post">
                  {{csrf_field()}}
                  <input type="hidden" name="id_order" value="{{$o->id_order}}"> 
                  <input type="hidden" name="id_standar" value="{{$o->standar_id}}">
                  <button class="btn btn-danger btn-sm ml-1" title="hapus" onclick="return confirm('Anda yakin ingin membatalkan order ini ?')">Batal</button>
                  </form>
                </div>
                @endif
              </td>
            </tr>
          @endforeach
        
          @foreach($orders as $o)
          <form action="/qc/order/kirim/semua/post" method="post">
          {{csrf_field()}}
          <input type="hidden" name="id_order" value="{{$o->id_order}}"> 
          <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
          <input type="hidden" value="{{$o->status_qc}}" name="alasan">
          <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
          @endforeach
          <!-- @if(Auth::user()->work_center == "QC")
            <td colspan="5">
            <td><button class="btn btn-primary ml-1"><i class="fa fa-envelope"></i> Kirim Semua Order</button></form></td>
          @else
          @endif -->
          </tbody>
        </table>
        @endif

        @else
          @if($orders->count() == "")
          <table id="example1" class="table table-bordered table-hover text-center">
            <thead class="bg-secondary">
              <tr>
                <th>Nama Item</th>
                <th>Kode Formula</th>
                <th>Alasan</th>
                <th>Serving Size</th>
                <th colspan="2">Jumlah Pesan</th>
                <th>Pemohon</th>
                <th>Opsi</th>
              </tr>
              <tr>
                <td colspan ="8" class="bg-secondary text-white">Tidak Ada Order</td>
              </tr>
          </table>
          @else

          <table id="example1" class="table table-bordered table-hover text-center mt-5">
            <thead class="bg-secondary">
              <tr>
                <th>Nama Item</th>
                <th>Kode Formula</th>
                <th>Alasan</th>
                <th>Serving Size</th>
                <th colspan="2">Jumlah Pesan</th>
                <th>Pemohon</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($orders as $o)
            <form action="/qc/order/kirim/satu/post" method="post">
              {{csrf_field()}}
              <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
              <input type="hidden" name="id_order" value="{{$o->id_order}}">
              <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
              <input type="hidden" value="{{$o->status_qc}}" name="alasan">
              <tr>
                <td>{{$o->nama_item}}</td>
                <td>{{$o->kode_formula}}</td>
                <td>
                  @if($o->status_qc == 'aktif')
                  <span class="right text-white text-bold p-1 badge badge-info">Pembaruan Standar</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'kadaluarsa')
                  <span class="right text-white text-bold p-1 badge badge-danger"> Kadaluarsa </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'habis')
                  <span class="right text-white text-bold p-1 badge badge-danger"> Habis </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'HampirKosong')
                  <span class="right text-white text-bold p-1 badge badge-danger"> Hampir Kosong </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'hampirExpired')
                  <span class="right text-white text-bold p-1 badge badge-warning"> Hampir Kadaluarsa </span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @endif
                </td>
                <td>{{$o->serving_size}} </td>
                <td>{{$o->jumlah_pesan}} gram</td>
                <td><?php echo floor($o->jumlah_pesan / $o->serving_size) ?> {{$o->satuan}} <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan"></td>
                <td>{{$o->pemohon}} - {{$o->bagian}} </td>
                <td>
                  <div class="row"></div>
                  @if($o->stat == 'pesan')
                  <a class='btn btn-default'>
                    <i class="fa fa-check"></i> Order Terkirim<span class='caret'></span>
                  </a>
                  @elseif($o->stat == 'batal')
                  <a class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                  <span class='glyphicon glyphicon-ok'></span> Dibatalkan RND <span class='caret'></span></a>
                  <ul class='dropdown-menu' role='menu'>
                    <li role='separator' class='divider'></li>
                    <li class="p-2">
                    <a href='/qc/order/hapus/satu/{{$o->id_order}}' onclick="return confirm('Anda yakin ingin membatalkan order ini ?')" class='btn btn-danger btn-danger col-12' data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a>
                    </li>
                  </ul>
                  @elseif($o->stat == 'keranjang')
                  <div class="row offset-1">
                    <button class="tooltips btn btn-primary btn-sm"><span>Kirim Order</span> </button>
                    </form>
                    <form action="/qc/order/hapus/satu" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id_order" value="{{$o->id_order}}"> 
                    <input type="hidden" name="id_standar" value="{{$o->standar_id}}">
                    <button class="btn btn-danger btn-sm ml-1" title="hapus" onclick="return confirm('Anda yakin ingin membatalkan order ini ?')">Batal</button>
                    </form>
                  </div>
                  @endif
                </td>
              </tr>
            @endforeach
          
            @foreach($orders as $o)
            <form action="/qc/order/kirim/semua/post" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id_order" value="{{$o->id_order}}"> 
            <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
            <input type="hidden" value="{{$o->status_qc}}" name="alasan">
            <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
            @endforeach
            <!-- @if(Auth::user()->work_center == "QC")
              <td colspan="5">
              <td><button class="btn btn-primary ml-1"><i class="fa fa-envelope"></i> Kirim Semua Order</button></form></td>
            @else
            @endif -->
            </tbody>
          </table>
          @endif

        @endif  
      </div>
    </div> 
  </section>          
</div>

<script type="text/javascript" src="jquery.js"></script> 

@endsection
