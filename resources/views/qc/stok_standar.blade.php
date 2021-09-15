@extends('layouts.layout')
@section('content')

<link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
<style>

  a.larang:hover{
    cursor : not-allowed !important;
  }
 .disabled:hover{
    cursor : not-allowed !important;
  }
  #keyword2{
    margin-left: 160px !important;
  }
  table{
   font-size:13px !important;
  }
  #lokasi {
    width: 5.9em;
  }
  .bg-jambu{
    background: #ff8484;
  }

  #tgl {
    width: 6.9em;
  }
  #tgl_terima {
    width: 6.9em;
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
</style>

<div class="content-wrapper bg-aktif">
  <section class="content-header">
  <div class="container-fluid">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-3 text-center ">
          <div class="card">
            <div class="card-header judul text-white text-bold">
              <h5>WIP</h5>
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

        @if( Session::get('keranjang') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-success alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('keranjang')}} | <a href="/qc/order"> Lihat keranjang : </a> </strong>
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
          Menampilkan data dengan status <strong class="yg">{{request('keyword')}}</strong> | <strong class="text-danger">{{ $standar->total() }}</strong> data ditemukan 
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

      @if(auth::user()->work_center == "ADMIN")
      <table class="Table table-bordered text-center mb-5">
        <thead class="text-dark text-bold">
          <tr>
            <th>Nama Item</th>
            <th>Kode Formula</th>
            <th>Revisi formula</th>
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
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}"> 
                <span class="right badge badge-info">{{$s->status_qc}} </span>
              @endif       
            </td>                
            @elseif ($s->status_qc =='kadaluarsa')
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
                <span class="right badge badge-danger">{{$s->status_qc}} </span>
              @endif  
            </td>
            @elseif ($s->status_qc =='habis')
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
                <span class="right badge badge-danger">{{$s->status_qc}} </span>
              @endif   
            </td>  
            @elseif ($s->status_qc =='HampirKosong')
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
                <span class="right badge badge-danger">hampir habis </span>
              @endif     
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
            <td>{{$s->status_qc}}  <input type="hidden" name="nama_item" value="{{$s->kode_formula}}"> </td>  
            <td>{{$s->status_qc}}  <input type="hidden" name="nama_item" value="{{$s->kode_revisi_formula}}"> </td>         
            <td> <?php echo (ceil($s->stok_qc / $s->serving_size))?> {{$s->satuan}} <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>
            <td>
              @if($s->status_qc == 'kadaluarsa')
              <input type="text" class="disabled form-control" size="1" value="{{$s->lokasi}}"  name="lokasi" disabled>
              @elseif($s->status_qc == 'hampirExpired' )
              <input type="text" class="disabled form-control" size="1" disabled name="lokasi" disabled>     
              @elseif($s->status_qc == 'habis')
              <input type="text" class="disabled form-control" size="1" value="{{$s->lokasi}}"  name="lokasi" disabled>
              @elseif($s->status_qc == 'HampirKosong')
              <input type="text" class="disabled form-control" size="1" value="{{$s->lokasi}}" disabled name="lokasi" disabled>
              @elseif($s->status_qc == 'aktif')
              <input type="text" class="disabled form-control disabled" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
              @endif
            </td>
            <td><input type="text" id="tgl" value="{{$s->tgl_kadaluarsa_qc}} " disabled class="disabled form-control" size="1"></td>
            <td><input type="text" id="tgl_terima" value="{{$s->tgl_terima}} " disabled class="disabled form-control" size="1"></td>
          </tr>
          @endforeach
        </tbody>
      </table>    
      {{ $standar->links() }}
      @else
      <table class="Table table-bordered mb-5">
        <thead class="text-dark text-bold">
          <tr>
            <th class="text-center" width="30%">Nama Item</th>
            <th class="text-center">Kode Formula</th>
            <th class="text-center">Revisi Formula</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Lokasi</th>
            <th class="text-center">Tanggal Kadaluarsa</th>
            <th class="text-center">Tanggal Terima</th>
            <th class="text-center" width="9%">Opsi</th>
          </tr>
        </thead>
        <tbody>
          @if(auth::user()->plant == "ciawi")
          @foreach( $standar as $s )
          <input type="hidden" name="alasan" value="{{$s->status_qc}}" >
          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">   
          <tr class="bg-aktif">
            @if($s->status_qc =='aktif')
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
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}"> 
                <span class="right badge badge-info"> aktif </span>
              @endif        
            </td>             
            @elseif($s->status_qc =='kadaluarsa')
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
                <span class="right badge badge-danger"> kadaluarsa </span>
              @endif     
            </td>
            @elseif ($s->status_qc =='habis')
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
                <span class="right badge badge-danger"> habis </span>
              @endif   
            </td>     
            @elseif ($s->status_qc =='HampirKosong')
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
                <span class="right badge badge-danger">hampir habis </span>
              @endif    
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
            <td class="text-center">{{$s->kode_formula}}</td>
            <td class="text-center">{{$s->kode_revisi_formula}}</td>
            <td> <?php echo (ceil($s->stok_qc / $s->serving_size))?> {{$s->satuan}} <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>
            <td>
              <input type="text" class="disabled form-control" size="1" disabled value="{{$s->lokasi}}" id="lokasi" name="lokasi" disabled>
            </td>
            <td><input type="text" id="tgl" value="{{$s->tgl_kadaluarsa_qc}}" minlength="1" disabled class="disabled form-control" size="1"></td>
            <td><input type="text" id="tgl_terima" value="{{$s->tgl_terima}} " disabled class="disabled form-control" size="1"></td>
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

              @if($s->kondisi =='keranjang')
              <a class="disabled tooltips btn btn-netral btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
              @elseif($s->kondisi =='order')
              <a class="tooltips btn btn-netral btn-sm disabled" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
              @elseif($s->kondisi =='proses_kirim')
              <button disabled data-placement="top" class="tooltips btn btn-netral btn-sm disabled"><span><i class="fa fa-shopping-cart"></i></span></button>
              @else
                @if($s->freeze == 'Y')            
                <a onclick="return alert('Maaf standar sedang dalam kondisi Freeze. Silahkan menghubungi pihak RD !')" class="tooltips btn btn-warning btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
                @else
                <a href="/qc/awal/pesan/{{$s->id_standar}}" class="tooltips btn btn-primary btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
                @endif
              @endif
            </td>
          </tr>
          @endforeach
          @elseif(auth::user()->plant == "cibitung")
          @foreach( $standar1 as $s )
          <input type="hidden" name="alasan" value="{{$s->status_qc}}" >
          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">   
          <tr class="bg-aktif">
            @if($s->status_qc =='aktif')
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
                {{$s->nama_item}}<input type="hidden" name="nama_item" value="{{$s->nama_item}}"> 
                <span class="right badge badge-info"> aktif </span>
              @endif        
            </td>             
            @elseif($s->status_qc =='kadaluarsa')
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
                <span class="right badge badge-danger"> kadaluarsa </span>
              @endif     
            </td>
            @elseif ($s->status_qc =='habis')
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
                <span class="right badge badge-danger"> habis </span>
              @endif   
            </td>     
            @elseif ($s->status_qc =='HampirKosong')
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
                <span class="right badge badge-danger">hampir habis </span>
              @endif    
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
            <td clas="text-center">{{$s->kode_formula}}</td>
            <td clas="text-center">{{$s->kode_revisi_formula}}</td>
            <td> <?php echo (ceil($s->stok_qc / $s->serving_size))?> {{$s->satuan}} <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>
            <td>
              <input type="text" class="disabled form-control" size="1" disabled value="{{$s->lokasi}}" id="lokasi" name="lokasi" disabled>
            </td>
            <td><input type="text" id="tgl" value="{{$s->tgl_kadaluarsa_qc}}" minlength="1" disabled class="disabled form-control" size="1"></td>
            <td><input type="text" id="tgl_terima" value="{{$s->tgl_terima}} " disabled class="disabled form-control" size="1"></td>
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

              @if($s->kondisi =='keranjang')
              <a class="disabled tooltips btn btn-netral btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
              @elseif($s->kondisi =='order')
              <a class="tooltips btn btn-netral btn-sm disabled" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
              @elseif($s->kondisi =='proses_kirim')
              <button disabled data-placement="top" class="tooltips btn btn-netral btn-sm disabled"><span><i class="fa fa-shopping-cart"></i></span></button>
              @else
                @if($s->freeze == 'Y')            
                <a onclick="return alert('Maaf standar sedang dalam kondisi Freeze. Silahkan menghubungi pihak RD !')" class="tooltips btn btn-warning btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
                @else
                <a href="/qc/awal/pesan/{{$s->id_standar}}" class="tooltips btn btn-primary btn-sm" href="#"><i class="fa fa-shopping-cart"></i><span>Pesan </span></a>
                @endif
              @endif
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>    
      @endif
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });
  function jumlahKan() {
		var stok_qc = document.getElementById('stok_qc');
		var terpakai = document.getElementById('terpakai');
    var jumlah_serving = document.getElementById('jumlah_serving');
    jumlah_serving.value = Math.ceil(stok_qc.value / terpakai.value);
	}
</script>

@endsection