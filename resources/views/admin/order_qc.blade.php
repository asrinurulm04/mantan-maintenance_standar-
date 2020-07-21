@extends('layouts.layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="card">
          <div class="card-body">

  
          @if($order->count() == "")
    
    
    <table id="example1" class="table table-bordered table-hover text-center">
            <thead class="hitam-legam text-white">
            <tr>
              <th>Nama Standar</th>
              <th>Kode Oracle</th>
              <th>Tanggal Kadaluarsa</th>
              <th>Tanggal Kadaluarsa Terbaru</th>
              <th>Jumlah Pesan</th>
              <th>Jumlah Kirim</th>
              <th>Tanggal Order</th>
              <th>Tanggal Kirim</th>
              <th></th>
            </tr>
            <tr>
            <td colspan = "9" class="bg-secondary text-white text-bold">Tidak Ada Order</td>
            </tr>
            </table>

      @else


          <table id="example1" class="table table-hover text-center mt-5">
                <thead class="bg-dark">
                <tr>
                  <th>Nama_item</th>
                  <th>Formula</th>
                  <th>Alasan</th>
                  <th>Pemohon</th>
                  <th>Work_center</th>
                  <th>Plant</th>
                  <th>Jumlah Pesan</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>

            
                
                   @foreach($orders as $o)
                   
               
                
                <form action="/qc/order/kirim/satu/post" method="post">
                {{csrf_field()}}
                 <input type="hidden" name="id_order" value="{{$o->id_order}}">    


                <tr>  
                <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
                  <td>
                  {{$o->nama_item}}
                  </td>
                  <td>{{$o->kode_formula}}</td>
                   <td>
                  @if($o->status_qc == 'aktif')
                 
                  <span class="right badge badge-info">Pembaruan Standar</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'kadaluarsa')
                 
                  <span class="right badge badge-danger"> {{$o->status_qc}}</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'habis')
                 
                  <span class="right badge badge-danger">{{$o->status_qc}}</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'hampirhabis')
                 
                  <span class="right badge badge-orange"> {{$o->status_qc}}</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @elseif($o->status_qc == 'hampirkadaluarsa')
                 
                  <span class="right badge badge-danger"> {{$o->status_qc}}</span> <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                  @endif
                   </td>
                   <td>{{$o->nama}}</td>
                   <td>
                   {{$o->bagian}}</td>
                   <td>{{$o->plant}}</td>
                 
                   <td>
                      {{$o->jumlah_pesan}}<input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
                   </td>
                 <td>
                
                 @if($o->status == 'order')
                  <button class="btn btn-secondary" disabled><i class="fa fa-check"></i> Order Terkirim</button>

                  @elseif($o->status == 'batal')
                  
                  <a class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                  <span class='glyphicon glyphicon-ok'></span> Dibatalkan RND <span class='caret'></span></a>
                  <ul class='dropdown-menu' role='menu'>
                    <li role='separator' class='divider'></li>
                    <li class="p-2">
                    <a href='/qc/order/hapus/satu/{{$o->id_order}}' onclick="return confirm('Anda yakin ingin membatalkan order ini ?')" class='btn btn-danger btn-danger col-12' data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a>
                    </li>
                  </ul>                  
                  @elseif($o->status == 'keranjang')
                  <a class="btn btn-danger" href='/qc/order/hapus/satu/{{$o->id_order}}' onclick="return confirm('Anda yakin ingin membatalkan order ini ?')"><i class="fa fa-times"></i></a>
                  <button class="btn btn-success ml-1"><i class="fa fa-check"></i></button>
                  </form>
                 @endif
                 
<!--                 
                 <button type="submit" class="btn btn-success ml-1" onclick="document.location.href='/qc/kirim/satu/keranjang/'"><i class="fa fa-check"></i></button> -->
               
                 </td>
                 
                 </tr>
                 
                 <form action="/qc/order/kirim/semua/post" method="post">
                {{csrf_field()}}
                <input type="hidden" value="{{$o->status_qc}}" name="alasan">
                <input type="hidden" name="id_order" value="{{$o->id_order}}">    
                <input type="hidden" name="id_users" value=" {{ Auth::user()->id }}">
                <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
                <input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
                 @endforeach
                
                 <tr>
                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                 <td>
                 <button class="btn btn-primary ml-1" title="Kirim Semua Order"  onclick="return confirm('Anda Yakin Ingin Mengirim Semua Order ?')"><i class="fa fa-envelope"></i> Kirim Semua Order</button>
                 </form>
                 </td>
                </tr>
               
                </tfoot>
              </table>
              @endif
          </div>
      </div>           
  </div>
    @endsection
