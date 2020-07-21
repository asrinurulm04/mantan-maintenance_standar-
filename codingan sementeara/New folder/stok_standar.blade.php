<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DATAR | Data Standar</title>
  <style>
    input.disabled:hover{
      cursor : not-allowed;
    }
    button.disabled:hover{
      cursor : not-allowed;
    }
    .badge-pink{
      background-color: orange !important;
      color: white;
      font-weight: bold;
    }
    .bg-pink{
      background-color: pink !important;
    }
  </style>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{('/assets/https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{('/assets/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{('/assets/plugins/daterangepicker/daterangepicker-bs3.c')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{('/assets/plugins/iCheck/all.css')}}">
  <!-- Bootstrap Col')}}or Picker -->
  <link rel="stylesheet" href="{{('/assets/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{('/assets/plugins/timepicker/bootstrap-timepicker.min.c')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{('/assets/plugins/select2/select2.min.css')}}">
  <!-- Them')}}e style -->
  <link rel="stylesheet" href="{{('/assets/dist/css/adminlte.min.css')}}">
  <!-- Google Fon')}}t: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->nama }} <span class="caret"></span>
        </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="{{url('/assets/dist/img/logo.png')}}" alt="logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DATAR</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{url('/assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="" class="d-block">QC</a>
          </div>
        </div>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
              <a href="" class="nav-link active">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  QC
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                    <li class="nav-item ">
                        <a href="/qc/stok/standar" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Stok Standar</p>
                        </a>
                    </li>
                    
                    <li class="nav-item ">
                        <a href="/qc/order" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                         <p>History Order</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                    <a href="/qc/keranjang" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Keranjang <i class="fa fa-shopping-cart text-danger"></i></p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="/qc/order/diterima" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Order Diterima</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="/qc/notifikasi" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Notifikasi</p>
                          <span class="right badge badge-danger">2 notifikasi</span>
                        </a>
                    </li>
              </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stok Standar</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../#">QC</a></li>
              <li class="breadcrumb-item active">Stok Standar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="card danger">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-3">
                  <!-- <select class="form-control select2" name="keywordd" style="width: 100%;">
                      <option value="Semua">Semua</option>
                      <option value="Bulking Agents">Bulking Agents</option>
                      <option value="Bulking Agents">WIP F / Non-Dairy Ciawi</option>
                      <option value="Baku A">WIP A / Dairy Cibitung</option>
                      <option value="Baku E">WIP E / Non-Dairy Cibitung</option>
                      <option value="Baku B">Baku A / Dairy Ciawi</option>
                      <option value="Baku F">Baku F / Non-Dairy Ciawi</option>
                      <option value="Baku F">WIP E / Dairy Cibitung</option>
                      <option value="Baku F">WIP F / Non-Dairy Cibitung</option>
                      <option value="Baku F">Baku Sentul</option>
                    </select> -->
                  </div>
                 
                  <div class="col-sm-8 mr-5">
                    <div class="card-shadow">
                      <form action="/qc/stok/cari" method="GET">
                        <div class="form-group">
                          <label>
                            <input type="radio" class="minimal" checked name="keyword" value="Aktif">
                            Aktif
                          </label>
                          <label>
                            <input type="radio" class="minimal" checked name="keyword" value="kadaluarsa">
                            Kadaluarsa
                          </label>
                          <label>
                            <input type="radio" class="minimal" checked name="keyword" value="hampirkadaluarsa">
                            Hampir Kadaluarsa
                          </label>
                          <label>
                            <input type="radio" class="minimal" checked name="keyword" value="Habis">
                            Habis
                          </label>
                          <label>
                            <input type="radio" class="minimal" checked name="keyword" value="Hampirhabis">
                            Hampir Habis
                          </label>
                          <label>
                            <input type="submit" class="btn btn-success" value="Filter">
                          </label>
                        </div>
                      </form>
                      <form action="/qc/stok/cari2" method="GET">
                            <div class="input-group mb-3">
                              <input type="text" name="keyword2" class="form-control" placeholder="Cari Data .." value="{{ old('cari') }}">
                                <div class="input-group-append">
                                  <input type="submit" class="btn btn-outline-secondary" value="CARI">
                                </div>
                            </div>
                      </form>
                    </div>
                  </div>
                 
                

                    <div class="col-md-12">
                    <div class="card shadow ">  
                      <div class="card-body">
                        <p class="lead"> Halaman : {{ $standar->currentPage() }} </p>
                        <p>Pencarian : <i> {{request('keyword2')}} </i></p>
                        <p class="lead"> Ditemukan : {{ $standar->total() }} Data | <span class="text-danger"> status : <u> <b>{{request('keyword')}}</b></u> </span> </p>
                        <p class="lead">	Data Per Halaman : {{ $standar->perPage() }} </p> 
                      </div>
                    </div>
                    
                     
                    
                    <!-- pencarian laravel -->
                    <!-- <div class="card shadow-sm">
                      <div class="card-body">
                        <h3 class="h3">Cari Data Pegawai :</h3>
                        <form action="/qc/stok/cari" method="GET">
                          <div class="input-group mb-3">
                          <input type="text" name="cari" class="form-control" placeholder="Cari Data .." value="{{ old('cari') }}">
                            <div class="input-group-append">
                            <input type="submit" class="btn btn-outline-secondary" value="CARI">
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>	<br><br> -->
                </div>
              </div>
          </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover text-center">
                <thead class="bg-dark">
                <tr>
                  <th>Nama Item Standar</th>
                  <th>Kode Oracle</th>
                  <th>Stok</th>
                  <th>Terpakai</th>
                  <th>Opsi</th>
                  <th>Lokasi</th>
                  <th>Kadaluwarsa</th>
                  <th>Tanggal Masuk</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $standar as $s )
                
               
                  @if($s->status =='Aktif')
                 
                  
                  <tr>
                      <td>{{$s->nama_item}}
                        <span class="right badge badge-info">{{$s->status}}

                          @elseif ($s->status =='kadaluarsa')
                          <tr class="bg-warning">
                          <td>{{$s->nama_item}}
                          <span class="right badge badge-danger">{{$s->status}}

                          @elseif ($s->status =='hampirkadaluarsa')
                          <tr class="bg-pink">
                          <td>{{$s->nama_item}}
                          <span class="right badge badge-pink">{{$s->status}}
                          @elseif ($s->status =='Habis')
                          <tr class="bg-warning">
                          <td>{{$s->nama_item}}
                          <span class="right badge badge-danger">{{$s->status}}
                              
                          @elseif ($s->status =='Hampirhabis')
                          <tr class="bg-pink">
                          <td>{{$s->nama_item}}
                          <span class="right badge badge-pink">{{$s->status}}
                  
                          @elseif ($s->status =='hampirkadaluarsa')
                          <td>{{$s->nama_item}}
                          {{$s->status}}

                          @else
                  <tr>
                          @endif
                        </td>
                  <td>{{$s->kode_oracle}}  </td>
                  <form action="/qc/stok/standar" method="post">
                  <td> {{$s->stok_qc}} <input type="hidden" value="{{ $s->stok_qc}}" name="stok_qc"></td>
                  <td>
                 
                 @if($s->status == 'kadaluarsa')
                  <input type="text" class="disabled form-control" size="1" name="terpakai" disabled id="disabled">
                  @elseif($s->status == 'hampirkadaluarsa' )
                 <input type="text" class="form-control" size="1" name="terpakai" id="disabled">     
                  @elseif($s->status == 'Habis' )
                 <input type="text" class="disabled form-control" size="1" name="terpakai" disabled id="disabled">     
                 @elseif($s->status == 'Hampirhabis' )
                 <input type="text" class="form-control" size="1" name="terpakai" id="">
                 @elseif($s->status == 'Aktif' )
                 <input type="text" class="form-control" size="1" name="terpakai">       
                 @endif         
                  </td>
                  <td>  @if($s->status == 'kadaluarsa')
                  <button type="submit" class="disabled btn btn-success mb-1" disabled>OK</button>
                  @elseif($s->status == 'hampirkadaluarsa')
                  <button type="submit" class="btn btn-success mb-1" onclick="document.location.href='/qc/order/proses/{{$s->id_standar}}'">OK</button>
                  @elseif($s->status == 'Habis')
                  <button type="submit" class="disabled btn btn-success mb-1" disabled>OK</button>
                  @elseif($s->status == 'Hampirhabis')
                  <button type="submit" class="btn btn-success mb-1" onclick="document.location.href='/qc/order/proses/{{$s->id_standar}}'" >OK</button>
                  @elseif($s->status == 'Aktif')
                  <button type="submit" class="btn btn-success mb-1" name="ok" href="{{$s->id_standar}} ">OK</button>
                  
                  @else
                  @endif</td>
                  </form>
                  <td>
                
                  @if($s->status == 'kadaluarsa')
                  <input type="text" class="disabled form-control" size="1" value="1.C.8" name="lokasi" disabled >
                  @elseif($s->status == 'hampirkadaluarsa' )
                 <input type="text" class="form-control" size="1" name="lokasi" id="">     
                  @elseif($s->status == 'Habis')
                  <input type="text" class="disabled form-control" size="1" value="1.C.8" name="lokasi" disabled >
                  @elseif($s->status == 'Hampirhabis')
                  <input type="text" class="form-control" size="1" value="1.C.8" name="lokasi" >
                  @elseif($s->status == 'Aktif')
                  <input type="text" class="form-control" size="1" value="1.C.8" name="lokasi">
                  @endif
                  </td>
                 
                  <td><input type="text" value="{{$s->tgl_kadaluarsa}} " disabled class="disabled form-control" size="1"></td>
                  <td><input type="text" value="{{$s->tgl_masuk}} " disabled class="disabled form-control" size="1"></td>
                  <td>
                  @if($s->status == 'kadaluarsa')
                 <button type="submit" class="btn btn-danger ml-1" name="pesan" onclick="document.location.href='/qc/order/keranjang/{{$s->id_standar}}'"><i class="fa fa-shopping-cart"></i></button>
                  @elseif($s->status == 'hampirkadaluarsa')
                 <button type="submit" class="btn btn-danger ml-1" name="pesan" onclick="document.location.href='/qc/order/keranjang/{{$s->id_standar}}'"><i class="fa fa-shopping-cart"></i></button>
                  @elseif($s->status == 'Habis')
                 <button type="submit" class="btn btn-danger ml-1" name="pesan" onclick="document.location.href='/qc/order/keranjang/{{$s->id_standar}}'"><i class="fa fa-shopping-cart"></i></button>
                  @elseif($s->status == 'Hampirhabis')
                 <button type="submit" class="btn btn-danger ml-1" name="pesan" onclick="document.location.href='/qc/order/keranjang/{{$s->id_standar}}'"><i class="fa fa-shopping-cart"></i></button>
                  @elseif($s->status == 'Aktif')
                  <button type="submit" class="btn btn-danger ml-1" name="pesan" onclick="document.location.href='/qc/order/keranjang/{{$s->id_standar}}'"><i class="fa fa-shopping-cart"></i></button>
                  @else
                  @endif
                  </td>
                </tr>
              
                @endforeach
                <!-- <tr>
                        <td>Ca Carbonate 44-00</td>
                        <td>Dairy Ciawi (B)</td>
                        <td> 25 gram	</td>
                        <td><input type="text" class="form-control" size="1"></td>
                        <td><input type="text" class="form-control" size="1" value="1.C.8"></td>
                        <td><input type="text" value="20/02/2019" disabled class="form-control" size="1"></td>
                        <td><input type="text" value="01/01/2019" disabled class="form-control" size="1"></td>
                        <td><button onclick="document.location.href='stok_standar.html'" type="submit" class="btn btn-success">OK</button><button type="submit" class="btn btn-danger ml-1"><i class="fa fa-shopping-cart"></i></button></td>
                </tr> -->
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
           <div class="col-md-12 justify-content-center">
           <div class="col-md-6 offset-3">
                <div class="card-shadow">
                {{ $standar->links() }}
                </div>
            </div>    
           </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('assets/https://code.jquery.com/ui/1.12.1/jquery-ui.min.js')}} "></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<!-- Morris.js charts -->
<script src="{{url('/assets/https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')}} "></script>
<script src="{{url('/assets/plugins/morris/morris.min.js')}} "></script>
<!-- Sparkline -->
<script src="{{url('/assets/plugins/sparkline/jquery.sparkline.min.js')}} "></script>
<!-- jvectormap -->
<script src="{{url('/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}} "></script>
<script src="{{url('/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}} "></script>
<!-- jQuery Knob Chart -->
<script src="{{url('/assets/plugins/knob/jquery.knob.js')}} "></script>
<!-- daterangepicker -->
<script src="{{url('/assets/https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js')}} "></script>
<script src="{{url('/assets/plugins/daterangepicker/daterangepicker.js')}} "></script>
<!-- datepicker -->
<script src="{{url('/assets/plugins/datepicker/bootstrap-datepicker.js')}} "></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}} "></script>
<!-- Slimscroll -->
<script src="{{url('/assets/plugins/slimScroll/jquery.slimscroll.min.js')}} "></script>
<!-- iCheck 1.0.1 -->
<script src="{{url('/assets/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('/assets/plugins/fastclick/fastclick.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{url('/assets/dist/js/adminlte.js')}} "></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/assets/v')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/assets/dist/js/demo.js')}} "></script>
<!-- Select2 -->
<script src="{{url('/assets/plugins/select2/select2.full.min.js')}} "></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })


    $("#example1").DataTable();
  
    $('input').hover(function(){
  cursor:not-allowed;
   $(this).attr('disabled','disabled');        
});

var style = document.createElement('style');
style.type = 'text/css';
style.innerHTML = 'disabled { cursor: not-allowed; }';
document.getElementsByTagName('head')[0].appendChild(style);

document.getElementById('disabled').className = 'disabled';
  </script>

</body>
</html>
