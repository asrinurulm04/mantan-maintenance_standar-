@extends('layouts.layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <div class="container-fluid">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-3 text-center ">
          <div class="card" style="background-color:#4a4848">
            <div class="card-header judul text-white flat">
              <h5 style="color:#ffff">Bahan Baku</h5>
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
        @if( Session::get('freeze') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-success alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('freeze')}} | <a href="/rnd/standar/freeze"> Lihat standar freeze : </a> </strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;<x/span>
              </button>
            </div>
          </div>
        </div>
        @endif
        
        @if( Session::get('delete') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-success text-white text-dark alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('delete')}} </strong>
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
              <strong class="text-white">{{Session::get('keranjang')}} | <a href="/rnd/order/unrequest"> Lihat keranjang order : </a> </strong>
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
            <div class="alert bg-success text-white text-dark alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('message')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;<x/span>
              </button>
            </div>
          </div>
        </div>
        @endif

        @if( Session::get('alert') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-success text-white text-dark alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('alert')}} <a href="/rnd/standar/freeze"> Lihat standar freeze :</a> </strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        @endif

        <a href="/rnd/ExportBaku" onclick="return confirm('Anda Yakin ?')"class="btn btn-flat btn-success"><i class="fa fa-download"></i> Download Excel Baku RD</a>
        <a href="{{route('cetakstandarBB')}}" class="btn btn-success"><li class="fa fa-print"></li> Cetak Label Standar</a><br><br>
        <table class="Table table-bordered text-center" style="overflow-y: scroll;">
          <thead class="">
            <tr style="background-color:#4a4848;color:#ffff">
              <th>Nama Standar</th>
              <th>Kode Oracle</th>
              <th>Stok</th>
              <th>Tanggal Datang</th>
              <th>Tanggal Dibuat</th>
              <th>Tanggal Kadaluarsa</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($standar as $s)
            <tr> 
              <td>
                {{$s->nama_item}} <br>
                  @if ($s->status_rnd =='aktif')
                  <span class="right badge badge-info">{{$s->status_rnd}}
                  @elseif ($s->status_rnd =='kadaluarsa')
                  <span class="right badge badge-danger">{{$s->status_rnd}}
                  @elseif ($s->status_rnd =='hampirkadaluarsa')
                  <span class="right badge badge-pink">{{$s->status_rnd}}
                  @elseif ($s->status_rnd =='habis')
                  <span class="right badge badge-danger">{{$s->status_rnd}}
                  @elseif ($s->status_rnd =='HampirKosong')
                  <span class="right text-dark text-bold badge" style="background:#EDC6F4 !important; color">hampir habis
                  @elseif ($s->status_rnd =='hampirExpired')
                  <span class="right badge badge-pink">hampir kadaluarsa
                  @endif
              </td>
              <td>{{$s->kode_oracle}}</td>
              <td><?php echo floor($s->stok_rnd / $s->serving_size) ?> {{$s->satuan}} </td>
              <td><input type="text" value="{{$s->tgl_terima}}" disabled class="disabled form-control" size="1"></td>
              <td><input type="text" value="{{$s->tgl_dibuat}}" disabled class="disabled form-control" size="1"></td>
              <td><input type="text" value="{{$s->tgl_kadaluarsa_rnd}}" disabled class="disabled form-control" size="1"></td>
              <td>
                <div class='btn-group'>
                  <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Opsi <span class='caret'></span></button>
                  <ul class='dropdown-menu' role='menu'>
                    <li class="nav-item has-treeview"> <a class="dropdown-item" href="/rnd/data/standar/lihat/{{$s->id_standar}}" title="Lihat"><i class="fa fa-eye"></i> Lihat</a></li>
                    <li> <a class="dropdown-item" href="/rnd/data/standar/edit/{{$s->id_standar}}" title="Edit"><i class="fa fa-edit"></i> Edit</a></li>
                    @if(Auth::user()->work_center == 'ADMIN')
                    @else
                      <li>       
                        @if($s->status_rnd =='kadaluarsa') 
                        <button class="dropdown-item disabled" disabled title="Masukkan Keranjang"><i class="fa fa-shopping-cart"></i> Kirim</button>
                        @elseif($s->status_rnd =='habis') 
                        <button class="dropdown-item disabled" disabled title="Masukkan Keranjang"><i class="fa fa-shopping-cart"></i> Kirim</button>
                        @else
                        <form action="/rnd/masuk/keranjang" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id_standar" value="{{$s->id_standar}}">                          <input type="hidden" name="pengirim_id" value="{{Auth::user()->id}}"> 
                        <button class="dropdown-item" title="Masukkan Keranjang"><i class="fa fa-shopping-cart"></i> Kirim</button></form>
                        @endif
                      </li>
                    @endif
                    <li>
                      <form action="/rnd/data/standar/freeze" method="post">
                      {{csrf_field()}}
                      <input type="hidden" name="id_standar" value="{{$s->id_standar}}">
                      <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                      <button class="dropdown-item" href="" title="Freeze"><i class="fa fa-bolt"></i> Freeze</button>
                      </form>
                    </li>
                    <li>
                      <form action="/rnd/data/standar/hapus" method="post">
                      {{csrf_field()}}
                      <input type="hidden" name="id_standar" value="{{$s->id_standar}}">
                      <input type="hidden" name="nama_item" value="{{$s->nama_item}}">
                      <button class="dropdown-item" href=""  title="Hapus" onclick="return confirm('Anda yakin ingin menghapus standar ini ?')"><i class="fa fa-trash"></i> Hapus</button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            @endforeach  
          </tbody>  
        </table>
      </div>
    </div>
  </section>
</div>

@endsection