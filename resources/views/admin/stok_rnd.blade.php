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
                  <h2>WIP</h2>
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

        @if( Session::get('delete') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('delete')}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if( Session::get('freeze') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('freeze')}} | <a href="/admin/standar/freeze"> Lihat data freeze:</a> </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if( Session::get('message') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('message')}}</strong>
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
                <div class="alert notif text-white text-bold text-dark alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('alert')}} | <a href="/rnd/standar/freeze"> Lihat standar freeze :</a> </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
      
        @endif
          @if( request('keyword') == "" )
          
          @elseif( $standar->total()== 0 )
          <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
                            Menampilkan data dengan pencarian <strong class="text-danger">{{request('keyword')}}</strong> | <strong class="text-danger"> Hasil Tidak Ditemukan </strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                  </div>
                @else
                
                <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
                            Menampilkan data dengan pencarian <strong class="text-danger">{{request('keyword')}}</strong> | <strong class="text-danger">{{ $standar->total() }}</strong> data ditemukan 
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                  </div>
                @endif        

          @if( request('stok') == "" )
          
          @elseif( $standar->total()== 0 )
          <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
                            Menampilkan data dengan status <strong class="text-danger">{{request('stok')}} </strong>| <strong class="text-danger"> Hasil Tidak Ditemukan </strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
          </div>
                @else
          <div class="alert pesan text-bold text-dark alert-dismissible fade show" role="alert">
                          Menampilkan data dengan status <strong class="yg">{{request('stok')}}</strong> | <strong class="text-danger">{{ $standar->total() }}</strong> data ditemukan 
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
            </div>
                  @endif        
        </div>  


        <div class="card-header bg-secondary">
          <div class="row">

          <div class="col-sm-3">
              <form class="form-inline mt-1 ml-2 mr-2" action="/rnd/standar/cari" method="GET">
                  <div class="input-group input-group-sm">
                  <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                    @if( request('keyword') !='' )
                    <input class="form-control form-control-navbar" name="keyword" value="{{request('keyword')}}" type="search" placeholder="Pencarian" required aria-label="Search">
                    @else
                    <input class="form-control form-control-navbar" name="keyword" type="search" placeholder="Pencarian" required aria-label="Search">
                    @endif
                  </div>
              </form>
            </div>

            <div class="col-sm-7">
            <form action="/rnd/stok/wip/cari" method="GET" class="form-inline ml-1">
                
                <div class="form-group">
                <br>
                  <label class="ml-1">
                    <input type="submit" class="btn btn-primary" value="Filter">
                  </label>
                  
                  <label for="aktif">
                  @if( request('stok') =='aktif' )
                    <input type="radio" name="stok" id="aktif" class="ml-2" checked value="aktif">
                    @else
                    <input type="radio" name="stok" id="aktif" class="ml-2" value="aktif" required>
                    @endif
                    Aktif
                  </label>
                  <label>
                  
                  @if( request('stok') =='kadaluarsa' )
                    <input type="radio" name="stok"  class="ml-2" checked value="kadaluarsa">
                    @else
                    <input type="radio" name="stok"  class="ml-2" value="kadaluarsa" required>
                    @endif
                    Kadaluarsa
                  </label>
                  <label>
                  
                  @if( request('stok') =='habis' )
                    <input type="radio" name="stok"  class="ml-2" checked value="habis">
                    @else
                    <input type="radio" name="stok"  class="ml-2" value="habis" required>
                    @endif
                    Habis
                  </label>
                  <label>
                  
                  @if( request('stok') =='HampirKosong' )
                    <input type="radio" name="stok"  class="ml-2" checked value="HampirKosong">
                    @else
                    <input type="radio" name="stok"  class="ml-2" value="HampirKosong" required>
                    @endif
                    Hampir Habis
                  </label>
                  
                  
                </div>
              </form>
            </div>
            
          </div>
        </div>
        
      <table class="table table-bordered text-center " >
                <thead class="">
                <tr>
                  <th>Nama Standar</th>
                  <!-- <th>No. Lot</th> -->
                  <!-- <th>Kode Formula</th> -->
                  <th>Kode Oracle</th>
                  <!-- <th>Tanggal Datang</th>
                  <th>Tanggal Buat</th> -->
                  <th>Tanggal Kadaluarsa</th>
                  <!-- <th>Work Center</th> -->
                  <th>Umur Simpan</th>
                  <th>Stok</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>
              @foreach($standar as $s)
              <form action="/rnd/masuk/keranjang" method="post">
                          {{csrf_field()}}
                          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">
                          <input type="hidden" name="pengirim_id" value="{{Auth::user()->id}}"> 
              @if($s->status_rnd =='aktif')
                  <tr class="bg-aktif">
                      <td>
                      {{$s->nama_item}}  <input type="hidden" name="nama_item" value="{{$s->nama_item}}" >
                        <span class="right badge badge-info">{{$s->status_rnd}}

                          @elseif ($s->status_rnd =='kadaluarsa')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-danger">{{$s->status_rnd}}

                          @elseif ($s->status_rnd =='hampirkadaluarsa')
                          <tr>
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-pink">{{$s->status_rnd}}
                          @elseif ($s->status_rnd =='habis')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-danger">{{$s->status_rnd}}
                              
                          @elseif ($s->status_rnd =='HampirKosong')
                          <tr class="bg-jambu">
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <span class="right badge badge-pink">{{$s->status_rnd}}
                    
                          @elseif ($s->status_rnd =='hampirkadaluarsa')
                          <td>{{$s->nama_item}} <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          {{$s->status_rnd}}

                          @else
                  <tr>
                          @endif
                        </td>
                  <!-- <td>{{$s->nolot}}</td> -->
                  <!-- <td>{{$s->kode_formula}}</td> -->
                  <td>{{$s->kode_oracle}}</td>
                  <!-- <td><input type="text" value="{{$s->tgl_datang}} " disabled class="disabled form-control" size="1"></td>
                  <td><input type="text" value="{{$s->tgl_dibuat}}" disabled class="disabled form-control" size="1"></td> -->
                  <td><input type="text" value="{{$s->tgl_kadaluarsa_rnd}} " disabled class="disabled form-control" size="1"></td>
                  <td>{{$s->umur_simpan}}</td>
                  <td>{{$s->stok_rnd}}</td>
                  <td>
                    <div class="btn-group" role="group">
                      <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Opsi
                      </button>
                      <div class="col-sm-12">
                        <div class="col-sm-8">
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <li> <a class="dropdown-item" href="/rnd/bahan/baku/edit/{{$s->id_standar}}"><i class="fa fa-edit"></i> Edit</a></li>
                           <form action="/rnd/data/standar/freeze" method="post">
                          {{csrf_field()}}
                          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">
                          <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                          <button class="dropdown-item" href=""><i class="fa fa-bolt"></i> Freeze</button>
                          </form>
                          </li>
                          <li>
                          <form action="/rnd/data/standar/hapus" method="post">
                          {{csrf_field()}}
                          <input type="hidden" name="id_standar" value="{{$s->id_standar}}">
                          <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                           <button class="dropdown-item" href="" onclick="return confirm('Anda yakin ingin menghapus standar ini ?')"><i class="fa fa-trash"></i> Hapus</button>
                           </form>
                           </li>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </td>     
              @endforeach
              
        </table>
      <br>
      {{ $standar->links() }}
      @if( request('stok') == "" )
      <span class="right badge badge-pink">Total Data {{ $standar->total() }}</span> 
        @else
        @endif
      </div>
    </div>
  </div>
  </div>

@endsection