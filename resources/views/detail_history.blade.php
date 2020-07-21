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
            <div class="card-header judul text-white text-bold">
              <h5>Detail History</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="col-sm-12">
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body">
        <div class="card-header">
          <div class="col-sm-12">
            <div class="form-row">
              <div class="col">
                <form action="/cari/tanggal" method="GET" class="form-inline mr-2">
                <div class="form-group">
                  <select name="aktifitas" class="form-control" required>
                    <option value="">~ Aktifitas ~</option>
                    @if( request('aktifitas') =='tgl_kirim' )
                    <option value="tgl_kirim" selected>RD mengirim ke QC </option>
                    @else
                    <option value="tgl_kirim" >RD mengirim ke QC </option>
                    @endif
                           
                    @if( request('aktifitas') =='tgl_order' )
                    <option value="tgl_order" selected>QC memesan ke RND </option>
                    @else
                    <option value="tgl_order">QC memesan ke RND </option>
                    @endif
                              
                    @if( request('aktifitas') =='tgl_diterima' )
                    <option value="tgl_diterima" selected>QC menerima order</option>
                    @else
                    <option value="tgl_diterima">QC menerima order</option>
                    @endif
                  </select>
                  @if( request('dari_tanggal') !='' )
                  <input type="date" name="dari_tanggal" tooltip="Dari Tanggal" required class="ml-2 form-control" value="{{request('dari_tanggal')}}">
                  @else
                  <input type="date" name="dari_tanggal" tooltip="Dari Tanggal" class="ml-2 form-control" id="aktif" class="ml-2" required>
                  @endif
                  @if( request('ke_tanggal') !='' )
                  <input type="date" name="ke_tanggal" tooltip="Ke Tanggal" required class="ml-2 form-control" value="{{request('ke_tanggal')}}">
                  @else
                  <input type="date" name="ke_tanggal" tooltip="Ke Tanggal" class="ml-2 form-control" id="aktif" class="ml-2" required>
                  @endif
                  <button class="btn btn-primary ml-2">Filter</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        @if($orders->count() == "")
        <table class="table table-bordered table-hover text-center">
          <tr>
            <th>Nama Item</th>
            <th>Pemohon</th>
            <th>Pengirim</th>
            <th>Penerima</th>
            <th>Tgl Order</th>
            <th>Tgl Kirim</th>
            <th>Tgl Diterima</th>
            <th>Jumlah Pesan</th>
            <th >Jumlah Kirim</th>
          </tr>
          <tr> 
            <td colspan="9">Tidak Ditemukan Data</td>
          </tr>
        </table>
        @else
        <table class="table table-bordered table-hover text-center">
          <tr>
            <th>Nama Item</th>
            <th>Pemohon</th>
            <th>Pengirim</th>
            <th>Penerima</th>
            <th>Tgl Order</th>
            <th>Tgl Kirim</th>
            <th>Tgl Diterima</th>
            <th colspan="2">Jumlah Pesan</th>
            <th colspan="2">Jumlah Kirim</th>
          </tr>
          @foreach($orders as $o)
          <tr>
            <td>{{$o->nama_item}} </td>
            <td>{{$o->pemohon}} - {{$o->bagian}} </td>
            <td>{{$o->pengirim}} </td>
            <td>{{$o->penerima}} </td>
            <td>{{$o->tgl_order}} </td>
            <td>{{$o->tgl_kirim}} </td>
            <td>{{$o->tgl_diterima}} </td>
            <td>{{$o->jumlah_pesan}} gram </td>
            <td> <?php echo floor($o->jumlah_pesan / $o->serving_size)?> {{$o->satuan}} </td>
            <td>{{$o->jumlah_kirim}} gram </td>
            <td> <?php echo floor($o->jumlah_kirim / $o->serving_size)?> {{$o->satuan}}</td>
          </tr>
          @endforeach
          @if($orders->count() == "")
          @else
          <tr>
            <th colspan="7">Total</th>
            <td>
              @if(request('aktifitas') =="")
              {{$hitungSemua->sum('jumlah_pesan')}} gram
              @else
              {{$hitungJumlah->sum('jumlah_pesan')}} gram
              @endif
            </td>
            <td>
              @if(request('aktifitas') =="")
              {{$hitungSemua->sum('jumlah_pesan') / $o->serving_size }} {{$o->satuan}}
              @else
              {{$hitungJumlah->sum('jumlah_pesan')}}  
              @endif
            </td>
            <td>
              @if(request('aktifitas') =="")
              {{$orders->sum('jumlah_kirim')}} gram
              @else
              {{$orders->sum('jumlah_kirim') / $o->serving_size}} 
              @endif
            </td>
            <td>
              @if(request('aktifitas') =="")
              {{$orders->sum('jumlah_kirim') / $o->serving_size }} {{$o->satuan}}
              @else
              {{$orders->sum('jumlah_kirim')}} 
              @endif
            </td>
          </tr>
          @endif
        </table><br>
        @endif
        {{$orders->links()}}
      </div>
    </div>
  </div>
</div>

@endsection