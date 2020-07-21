@extends('layouts.layout')
@section('content')

<div class="content-wrapper">
<section class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12">
          <div class="row">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
<!-- Content Header (Page header) -->
<section class="content">

<div class="card">  
    <div class="card-body">
    <div class="latar text-white mt-5">

        @if( Session::get('konfirmasi') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert bg-success alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('konfirmasi')}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
        @if( Session::get('konfirmasiGagal') !="")
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert bg-danger alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('konfirmasiGagal')}} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
     
        </div>  

<!--  
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
          </div>
        </div> -->
 
      @if($users->count()=="")  
      <div class="table-responsive">
        <table id="example1" class="table table-hover table-bordered text-center">
        <thead class="">
        <tr>
          <th>Nama Lengkap</th>
          <th>Username</th>
          <th>Email</th>
          <th>Work Center</th>
          <th>Bagian</th>
          <th>Opsi</th>
        </tr>
        <tr>
          <td colspan="6">Tidak Ditemukan Data</td>
        </tr>
      </table>
      </div>
      @else
      <div class="table-responsive">
        <table id="example1" class="table table-hover table-bordered text-center">
        <thead class="">
        <tr>
          <th>Nama Lengkap</th>
          <th>Username</th>
          <th>Email</th>
          <th>Work Center</th>
          <th>Bagian</th>
          <th>Opsi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
        @if($u->konfirmasi == 'N')
        <form action="/user/konfirmasi/post" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$u->id}}">
        <tr>
          <td>{{$u->nama}} <input type="hidden" name="nama" value="{{$u->nama}}"> </td>
          <td>{{$u->username}} <input type="hidden" name="username" value="{{$u->username}}"></td>
          <td>{{$u->email}} <input type="hidden" name="email" value="{{$u->email}}"> </td>
          <td>{{$u->work_center}} <input type="hidden" name="work_center" value="{{$u->work_center}}"> </td>
          <td>{{$u->bagian}} </td>
         
          <td><button class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin ? Dengan mengkonfirmasi maka Anda telah mengizinkan pengguna berikut untuk mengakses aplikasi')">Konfirmasi</button> </form>
          <a href="/user/hapus/{{$u->id}}" class="btn btn-primary btn-sm ml-1" onclick="return confirm('Anda Yakin ?');">Hapus</a></td>
          
         </tr>
              @if (session('alert'))
                  <div class="alert alert-success">
                      {{ session('alert') }}
                  </div>
              @endif
        @endif
        @endforeach
        </tfoot>
      </table>
      <br>
      {{ $users->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
</div>


@endsection

