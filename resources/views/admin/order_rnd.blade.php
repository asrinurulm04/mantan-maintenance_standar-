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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
  <section class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6 offset-3 text-center ">
              <div class="card">
                <div class="card-header judul text-white text-bold">
                  <h2>Order</h2>
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
      <table id="example1" class="table table-bordered table-hover text-center">
                <thead class="bg-dark">
                <tr>
                  <th>Nama Item</th>
                  <th>Kode Oracle</th>
                  <th>Alasan</th>
                  <th>Tanggal Order</th>
                  <th>Pemohon</th>
                  <th>Plant</th>
                  <th>Work Center</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order as $o)
                  @if($o->status == "keranjang" && $o->work_center != "RND")
                  
                  @else
                          <input type="hidden" name="standar_id" value="{{$o->standar_id}}">
            <tr>
                <td>{{$o->nama_item}}</td>
                <td>{{$o->kode_oracle}}</td>
                <td>
                @if($o->alasan =='aktif')
                Pembaruan Standar <input type="hidden" value="{{ $o->alasan}}" name="alasan">
                @else
                {{$o->alasan}}
                @endif
                
                </td>
                <td>{{$o->tgl_order}}</td>
                <td> @if($o->pemohon_id !="")
                {{$o->nama}}
                  @else
                  -
               
                @endif</td>
                <td> @if($o->pemohon_id !="")
                {{$o->plant}}
                  @elseif($o->pemohon_id =="")
             
                    {{$peng->plant}}

                @endif</td>
                <td> @if($o->pemohon_id !="")
                {{$o->work_center}}
                  @elseif($o->pemohon_id =="")
             
                    {{$peng->work_center}}

                @endif</td>
                <td>
                @if($o->status == 'order')
                <a href="/rnd/order/proses/{{$o->id_order}}" disabled class="btn btn-primary"><i class="fa fa-send"></i></a><a class="btn btn-danger ml-2" href='/rnd/order/batal/{{$o->id_order}}' onclick="return confirm('Anda Yakin Ingin Membatalkan Order Berikut ?');"><i class="fa fa-trash"></i></button></td>
                @elseif($o->status == 'keranjangrd')
                <a href="/rnd/order/proses/{{$o->id_order}}" disabled class="btn btn-primary"><i class="fa fa-send"></i></a><a class="btn btn-danger ml-2" href='/rnd/order/batal/{{$o->id_order}}' onclick="return confirm('Anda Yakin Ingin Membatalkan Order Berikut ?');"><i class="fa fa-trash"></i></button></td>
                @elseif($o->status == 'kirim')
                
              
                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                    <span class='glyphicon glyphicon-ok'></span> Terkirim <span class='caret'></span></button>
                    <ul class='dropdown-menu' role='menu'>
                    <li><p align='left' title='Pengirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-users"></i> Pengirim : {{$peng->nama}}&nbsp;</p></li>
                    <li><p align='left' title='Jumlah Pesan' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Pesan : {{$o->jumlah_pesan}}&nbsp;</p></li>
                    <li><p align='left' title='Jumlah Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-list-ul"></i> Kirim : {{$o->jumlah_kirim}}&nbsp;</p></li>
                    <li><p align='left' title='Tanggal Kirim' data-toggle='tooltip' data-placement='auto top'>&nbsp;<i class="fa fa-upload"></i> Tgl. Kirim : {{$o->tgl_kirim}}</p></li>
                    <li role='separator' class='divider'></li>
                    <li>
                    <a href='/rnd/order/terkirim/hapus/{{$o->id_order}}' class='btn btn-default btn-danger col-12'  data-toggle='tooltip'  data-placement='auto top' title='Hapus Order Terkirim'><i class="fa fa-trash"></i> Hapus</a>
                    </li>
                    </ul>
                    @elseif($o->status == 'order_diterima')
                    <button class="btn btn-white" disabled><i class="fa fa-check"></i> Order Telah Diterima</button>
                
                </td>
                @endif
            </tr>
            @endif
            @endforeach
              
                </form>
                </tfoot>
              </table>
        </div>
      </div>
    </div>          
  </div>
@endsection