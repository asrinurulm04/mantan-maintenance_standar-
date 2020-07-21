<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>MANTAN | Maintenance Standar</title>
  
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{url('/assets/dist/css/adminlte.min.css')}}">
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
    .bg-ungu{
     background: #edc6f4;
    }

    .bg-kuning{
      background: #f4e541;
    }

    .bg-aktif{
      background: #f5f5f5;
    }
    table{
      font-size: 14px;
    }
    .bg-jambu{
      background: #ff8484;
    }
    .dropdown-menu {
      width : 240px !important;
      overflow : auto !important;
      color : black;
      font-weight : bold;
    }
    .hitam-legam{
      background : #000000 !important;
    }
    .pesan {
      background : #bcddb1;
    }
    a.tooltips {
      position: relative;
      display: inline;
      text-decoration: none;
    }
    a.tooltips span {
      position: absolute;
      width:140px;
      color: #FFFFFF;
      background: #000000;
      height: 25px;
      line-height: 25px;
      text-align: center;
      visibility: hidden;
      border-radius: 5px;
    }
    a.tooltips span:after {
      content: '';
      position: absolute;
      bottom: 100%;
      left: 50%;
      margin-left: -8px;
      width: 0; height: 0;
      border-bottom: 8px solid #000000;
      border-right: 8px solid transparent;
      border-left: 8px solid transparent;
    }
    a:hover.tooltips span {
      visibility: visible;
      opacity: 0.5;
      top: 30px;
      left: 50%;
      margin-left: -76px;
      z-index: 999;
    }

    button.tooltip {
      position: relative;
      display: inline-block;
      border-bottom: 1px dotted black;
    }

    button.tooltip .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      
      /* Position the tooltip */
      position: absolute;
      z-index: 1;
      top: 100%;
      left: 50%;
      margin-left: -60px;
    }

    button.tooltip:hover .tooltiptext {
      visibility: visible;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <nav class="main-header navbar navbar-expand bg-dark text-white navbar-light border-bottom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          @if(Auth::user()->work_center == 'RND')
          <span class="badge badge-danger navbar-badge">{{$pesan2->count() + $pesan4->count()}}</span>
          @elseif(Auth::user()->work_center == 'QC')
          <span class="badge badge-danger navbar-badge">{{$pesan1->count() + $pesan3->count() + $pesan4->count()}}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="color:black;overflow-y: scroll;max-height:270px">
          @if(Auth::user()->work_center == 'QC')
          @foreach ($pesan3 as $item)
          <a href="#" class="dropdown-item" style="color:black">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body" style="color:black">
                <p class="text-sm">Stok {{$item->nama_item}} {{$item->subject}} {{$item->nama}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>{{$item->tgl}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <hr>
          @endforeach
          @foreach ($pesan1 as $item)
          <a href="#" class="dropdown-item" style="color:black">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body" style="color:black">
                <p class="text-sm">{{$item->nama}} menggunakan std {{$item->nama_item}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>{{$item->tgl}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <hr>
          @endforeach
          @foreach ($pesan4 as $item)
          <a href="#" class="dropdown-item" style="color:black">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body" style="color:black">
                <p class="text-sm">{{$item->nama}} Menambahkan stok BB {{$item->nama_item}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>{{$item->tgl}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a><hr>
          @endforeach
          @elseif(Auth::user()->work_center == 'RND')
          @foreach ($pesan2 as $item)
          <a href="#" class="dropdown-item" style="color:black">
            <!-- Message Start -->
            <div class="media" style="color:black">
              <div class="media-body">
                <p class="text-sm">{{$item->nama}} memesan std {{$item->nama_item}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>{{$item->tgl}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a><hr>
          @endforeach
          @foreach ($pesan4 as $item)
          <a href="#" class="dropdown-item" style="color:black">
            <!-- Message Start -->
            <div class="media" style="color:black">
              <div class="media-body">
                <p class="text-sm">{{$item->nama}} Menambahkan stok BB {{$item->nama_item}}</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>{{$item->tgl}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a><hr>
          @endforeach
          @endif
          <div class="dropdown-divider"></div>
          <a href="{{route('hapusnotif')}}" class="dropdown-item dropdown-footer"><p style="color:black"> Hapus semua notif</p> </a>
        </div>

      </li>
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <img style="width:30px" src="{{ asset('assets/dist/img/logo.png') }}" alt="..." class="profile_img"> Selamat Datang, {{ Auth::user()->nama }} <span class="caret"></span>
        </a>
        <div class="dropdown-menu bg-dark dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item bg-dark fa fa-power-off" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a class="brand-link text-white">
      <img src="{{url('/assets/dist/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light ml-3" style="color:#ffff">MANTAN</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <center>
        <div class="brand-link">
          <div class="info p-2 mt-2">
            <a class="brand-text text-bold"> {{ Auth::user()->nama }} </a> 
            <p class="brand-text small " style="color:#ffff">Work Center : {{Auth::user()->work_center}}</p>
          </div>
        </div>
      </center>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->work_center == 'ADMIN')

            <li class="nav-item ">
              <a href="/home" class="nav-link">
                <i class="fa fa-user nav-icon"></i><p>Profil</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-users"></i><p> Kelola Pengguna <i class="right fa fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/user" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Pengguna Aktif</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/data/user/belum/aktif" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Pengguna Non - Aktif</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-folder"></i><p> Data<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/admin/bagian" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Bagian</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/kategori" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Sub Kategori</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/plant" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Plant</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/satuan" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Satuan</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-suitcase"></i><p> Stok RD <i class="right fa fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/data/standar" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Stok WIP</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/standar/baku" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Stok Bahan Baku</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-edit"></i><p> Input<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/input/wip/baru" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Input WIP</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/input/bahan/baku/baru" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Input Bahan Baku</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-child"></i> <p> Aktifitas QC <i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/qc/order" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Keranjang Order</p> <span class="right badge badge-danger"> {{$order_qc->count()}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/qc/order/diterima" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Order Diterima</p> <span class="right badge badge-danger"> {{$order_diterima_qc->count()}} </span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-child"></i><p>Aktifitas RD<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/order/unrequest" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Keranjang Order</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/order" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Permintaan Order</p><span class="right badge badge-danger"> {{$order_diterima_rnd->count()}}</span>
                  </a>
                </li>
              </ul>
            </li>
                  
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-calendar"></i><p> Histori <i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="/history/pakai" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Histori Stok</p>
                  </a>
                </li>
              </ul>
            </li>
                        
            <li class="nav-item ">
              <a href="/rnd/standar/freeze" class="nav-link">
                <i class="fa fa-bolt nav-icon"></i><p>Standar Freeze</p>
              </a>
            </li>

          @elseif(Auth::user()->work_center == 'QC')
              
            <li class="nav-item ">
              <a href="/home" class="nav-link">
                <i class="fa fa-user nav-icon"></i><p>Profil</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-suitcase"></i> <p>Stok <i class="right fa fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/qc/stok/standar" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i> <p>Stok WIP</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/qc/stok/baku" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i> <p>Stok Bahan Baku</p>
                  </a>
                </li>
              </ul>
            </li>
                    
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-shopping-cart"></i><p>Kelola Order<i class="right fa fa-angle-left"></i><span class="right badge badge-danger"> {{$order_diterima_qc->count() + $hitungOrderSendiri->count()}} </span></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/qc/order" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Keranjang Order</p> <span class="right badge badge-danger"> {{$hitungOrderSendiri->count()}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/qc/order/diterima" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Order Diterima</p> <span class="right badge badge-danger"> {{$order_diterima_qc->count()}} </span>
                  </a>
                </li>    
              </ul>
            </li>

            <li class="nav-item has-treeview ">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-calendar"></i><p>Histori<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="/history/pakai" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Histori Stok</p>
                  </a>
                </li>
              </ul>
            </li>

          @else
                
            <li class="nav-item ">
              <a href="/home" class="nav-link">
                <i class="fa fa-user nav-icon"></i><p>Profile</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-book"></i><p>Data<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/data/standar" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Standar WIP</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/standar/baku" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Standar Bahan Baku</p>
                  </a>
                </li>

                <li class="nav-item ">
                  <a href="/rnd/kategori" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Sub Kategori</p>
                  </a>
                </li>

                <li class="nav-item ">
                  <a href="/rnd/plant" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Plant</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/satuan" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Satuan</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-edit"></i><p>Input<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/input/wip/baru" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Input WIP</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/input/bahan/baku/baru" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Input Bahan Baku</p>
                  </a>
                </li>
              </ul>
            </li>
                      
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-shopping-cart"></i><p>Kelola Order <i class="right fa fa-angle-left"></i></p>&nbsp<span class="right badge badge-danger"> {{$order_diterima_rnd->count() + $order_rnd->count()}} </span>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="/rnd/order/unrequest" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Keranjang Order</p><span class="right badge badge-danger"> {{$order_rnd->count()}} </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="/rnd/order" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Permintaan Order</p><span class="right badge badge-danger"> {{$order_diterima_rnd->count()}} </span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link secondary">
                <i class="nav-icon fa fa-calendar"></i><p>Histori<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="/history/pakai" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i><p>Histori Stok</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item ">
              <a href="/rnd/standar/freeze" class="nav-link">
                <i class="fa fa-bolt nav-icon"></i><p>Standar Freeze</p>
              </a>
            </li>
                  
          @endif
        </ul>
      </nav>
    </div>
  </aside>

  @yield('content')

  <script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
  <script src="{{url('/assets/dist/js/adminlte.js')}} "></script>
  <script src="{{url('/assets/dist/js/demo.js')}} "></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script type="text/javascript">$('.Table').DataTable({
    "language": {
      "search": "Cari :",
      "lengthMenu": "Tampilkan _MENU_ data",
      "zeroRecords": "Tidak ada data",
      "emptyTable": "Tidak ada data",
      "info": "Menampilkan data _START_  - _END_  dari _TOTAL_ data",
      "infoEmpty": "Tidak ada data",
      "paginate": {
          "first": "Awal",
          "last": "Akhir",
          "next": ">",
          "previous": "<"
        }
      }
    });
  </script>
  @stack('scripts')
</body>
</html>