@extends('layouts.layout')
@section('content')

<style>
 #keyword2{
   margin-left: 160px !important;
   
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-aktif">
  <section class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6 offset-3 text-center ">
              <div class="card">
                <div class="card-header judul text-white text-bold">
                  <h2>Stok QC</h2>
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

        
  @if( Session::get('keranjang') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert bg-secondary alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('keranjang')}} | <a href="/qc/order"> Lihat keranjang order :</a> </strong>
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


            
            <div class="card-header bg-secondary">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-3">
                    <form class="form-inline  mr-5" action="/qc/stok/cari/nama" method="GET">
                            <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                  <i class="fa fa-search"></i>
                                </button>
                              </div>
                            @if( request('nama') !='' )
                            <input class="form-control form-control-navbar" name="nama" value="{{request('nama')}}" type="search" placeholder="Pencarian" required aria-label="Search">
                            @else
                            <input class="form-control form-control-navbar" name="nama" type="search" placeholder="Pencarian" required aria-label="Search">
                            @endif  
                              
                  
                            </div>
                    </form>
                  </div>
                  <div class="col-sm-7">
                    <form action="/qc/stok/cari" method="GET" class="form-inline mr-2">
                            <!-- <select name="keyword3" class="form-control">
                              <option value="">Semua </option>
                              
                              @if( request('keyword3') =='WIP' )
                              <option value="WIP" selected>WIP </option>
                              @else
                              <option value="WIP" >WIP </option>
                              @endif
                              
                              @if( request('keyword3') =='Baku' )
                              <option value="Baku" selected>Baku </option>
                              @else
                              <option value="Baku">Baku </option>
                              @endif
                            </select> -->
                              <div class="form-group">
                              <label class="ml-1">
                                  <input type="submit" class="btn btn-primary" value="Filter">
                              </label>
                                <label>
                                @if( request('keyword') =='aktif' )
                                  <input type="radio" name="keyword" class="ml-2" checked value="aktif">
                                  @else
                                  <input type="radio" name="keyword" required class="ml-2" value="aktif">
                                  @endif
                                  Aktif
                                </label>
                                <label>
                                
                                @if( request('keyword') =='kadaluarsa' )
                                  <input type="radio" name="keyword"  class="ml-2" checked value="kadaluarsa">
                                  @else
                                  <input type="radio" name="keyword" required class="ml-2" value="kadaluarsa">
                                  @endif
                                  Kadaluarsa
                                </label>
                                <label>
                                
                                @if( request('keyword') =='habis' )
                                  <input type="radio" name="keyword"  class="ml-2" checked value="habis">
                                  @else
                                  <input type="radio" name="keyword" required class="ml-2" value="habis">
                                  @endif
                                  Habis
                                </label>
                                <label>
                                
                                @if( request('keyword') =='HampirKosong' )
                                  <input type="radio" name="keyword"  class="ml-2" checked value="HampirKosong">
                                  @else
                                  <input type="radio" name="keyword" required class="ml-2" value="HampirKosong">
                                  @endif
                                  Hampir Habis
                                </label>
                              </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        <table class="table table-bordered text-center mb-5">        
    
        
                <thead class="text-dark text-bold">
                <tr>
                  <th>Nama Item Standar</th>
                  <th>Kode Oracle</th>
                  <th>Stok</th>
                  <th>Terpakai</th>
                  <th>Lokasi</th>
               
                  <th>Tanggal Kadaluarsa</th>
                  <th>Tanggal Masuk</th>
                 
                </tr>
                </thead>
                <tbody>
                @foreach( $standar as $s )
              
                <input type="hidden" name="alasan" value="{{$s->status_qc}}" >
                  <input type="hidden" name="id_standar" value="{{$s->id_standar}}">   
                   @if($s->status_qc =='aktif')
                  <tr class="bg-aktif">
                      <td>
                      {{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                        <span class="right badge badge-info">{{$s->status_qc}}
                        
                          @elseif ($s->status_qc =='kadaluarsa')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-danger">{{$s->status_qc}}

                          @elseif ($s->status_qc =='hampirkadaluarsa')
                          <tr>
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-pink">{{$s->status_qc}}
                          @elseif ($s->status_qc =='habis')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-danger">habis
                              
                          @elseif ($s->status_qc =='HampirKosong')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-pink">hampir habis
                  
                          @elseif ($s->status_qc =='hampirkadaluarsa')
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          {{$s->status_qc}}

                          @else
                  <tr>
                          @endif
                        </td>
                  <td>{{$s->kode_oracle}}  <input type="hidden" name="nama_item" value="{{$s->kode_oracle}}"> </td>

                  <form action="/qc/terpakai" method="post" onSubmit="cek()">                  
                  <td> {{$s->stok_qc}} {{$s->satuan}}  <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc" id="stok_qc"></td>

                  {{ csrf_field() }}
					        <input type="hidden" name="id_standar" value="{{ $s->id_standar }}">
                  <td>
                  
                 @if($s->status_qc == 'kadaluarsa')
                  <input type="text" class="disabled form-control" size="1" name="terpakai" id="terpakai"disabled>
                  @elseif($s->status_qc == 'hampirkadaluarsa' )
                 <input type="text" class="form-control" required size="1" name="terpakai" id="terpakai">     
                  @elseif($s->status_qc == 'habis' )
                 <input type="text" class="disabled form-control" size="1" name="terpakai" id="terpakai" disabled>     
                 @elseif($s->status_qc == 'HampirKosong' )
                 <input type="text" class="form-control" required size="1" name="terpakai" id="terpakai">
                 @elseif($s->status_qc == 'aktif' )
                 <input type="text" class="form-control" required size="1" name="terpakai" id="terpakai">       
                 @endif         
                  </td>


                  <td>
                
                  @if($s->status_qc == 'kadaluarsa')
                  <input type="text" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
                  @elseif($s->status_qc == 'hampirkadaluarsa' )
                 <input type="text" class="form-control" size="1" name="lokasi" >     
                  @elseif($s->status_qc == 'habis')
                  <input type="text" class="disabled form-control" size="1" value="{{$s->lokasi}}" name="lokasi" disabled>
                  @elseif($s->status_qc == 'HampirKosong')
                  <input type="text" class="form-control" size="1" value="{{$s->lokasi}}" name="lokasi" >
                  @elseif($s->status_qc == 'aktif')
                  <input type="text" class="form-control" size="1" value="{{$s->lokasi}}" name="lokasi">
                  @endif
                  </td>

                
                 
                  <td><input type="text" value="{{$s->tgl_kadaluarsa_qc}} " disabled class="disabled form-control" size="1"></td>
                  <td><input type="text" value="{{$s->tgl_masuk}} " disabled class="disabled form-control" size="1"></td> 
                </tr>
                @endforeach
                </tfoot>
               
              </table>    
              {{ $standar->links() }}
              </div>
        </div>
    </div>
  </div>
@endsection