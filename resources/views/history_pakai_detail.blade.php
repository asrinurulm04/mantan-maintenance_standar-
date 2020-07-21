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
  </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body">
        <div class="card-header">
          <div class="col-sm-12">
            <div class="form-row">
              <div class="col">
                <form action="/cari/tanggal/detail" method="GET" class="form-inline mr-2">
                <div class="form-group">
                  <input type="hidden" name="id_standar" value="{{$ambilSatu->standar_id}}">
                  <select name="aktifitas" class="form-control" required>
                    <option value="">~ Aktifitas ~</option>
                           
                    @if( request('aktifitas') =='QC memakai std' )
                    <option value="QC memakai std" selected>QC memakai std </option>
                    @else
                    <option value="QC memakai std">QC memakai std </option>
                    @endif
                    @if( request('aktifitas') =='QC menambah stok' )
                    <option value="QC menambah stok" selected>QC menambah stok bahan baku</option>
                    @else
                    <option value="QC menambah stok">QC menambah stok bahan baku</option>
                    @endif
                              
                    <!-- @if( request('aktifitas') =='RD mengubah std' )
                    <option value="RD mengubah std" selected>RD mengubah std </option>
                    @else
                    <option value="RD mengubah std">RD mengubah std </option>
                    @endif -->
     
                  </select>
                  @if( request('dari_tanggal') !='' )
                  <input type="date" name="dari_tanggal" tooltip="Dari Tanggal" required class="ml-2" value="{{request('dari_tanggal')}}">
                  @else
                  <input type="date" name="dari_tanggal" tooltip="Dari Tanggal" class="ml-2" id="aktif" class="ml-2" required>
                  @endif
                  @if( request('ke_tanggal') !='' )
                  <input type="date" name="ke_tanggal" tooltip="Ke Tanggal" required class="ml-2" value="{{request('ke_tanggal')}}">
                  @else
                  <input type="date" name="ke_tanggal" tooltip="Ke Tanggal" class="ml-2" id="aktif" class="ml-2" required>
                  @endif
                  <button class="btn btn-primary ml-2">Filter</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered table-hover text-center">
          <tr>
            <th>Nama Item</th>
            <th>Aktifitas</th>
            <th>Aktor</th>
            <th>Alasan</th>
            <th>Tgl</th>
            <th>Keterangan</th>
            <th>Serving Size</th>
            <th colspan="2">Jumlah</th>
          </tr>
          @foreach($history as $h)
          <tr>
            <td>{{$h->nama_item}}</td>
            <td>{{$h->aktifitas}} </td>
            <td>{{$h->nama}} </td>
            <td>
              @if($h->alasan == 'hampirExpired')    
              hampir kadaluarsa
              @else
              {{$h->alasan}}
              @endif
            </td>
            <td>{{$h->tgl}} </td>
            <td>{{$h->keterangan}} </td>
            <td>{{$h->serving_size}} </td>
            <td>{{$h->jumlah}} gram </td>
            <td><?php echo floor($h->jumlah / $h->serving_size)?> {{$h->satuan}} </td>
          </tr>
          @endforeach
          @if($history->count() == "")
          @else
          <tr>
            <td colspan="7">Total</td>
            <td> 
              @if(request('aktifitas') =="")
              {{$hitungSemua->sum('jumlah')}} gram
              @else
              {{$hitungJumlah->sum('jumlah')}} gram
              @endif
            </td> 
            <td> 
              @if(request('aktifitas') =="")
              {{$hitungSemua->sum('jumlah') / $h->serving_size}} {{$h->satuan}}
              @else
              {{$hitungJumlah->sum('jumlah') / $h->serving_size}} {{$h->satuan}}
              @endif
            </td>
            @endif
          </tr>
          @if($history->count() == "")
          <tr>
            <td colspan="8">Tidak Ditemukan Data</td>
          </tr>
          @else
        </table><br> 
        {{$history->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

@endsection