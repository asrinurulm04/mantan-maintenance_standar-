<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MANTAN | Maintenance Standar</title>
 
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
    <!-- akhir Favicon -->
  <link rel="shortcut icon" href="favicon.ico">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Them')}}e style -->
  <link rel="stylesheet" href="{{('/assets/dist/css/adminlte.min.css')}}">
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
   
    .bg-aktif{
      background: #f5f5f5;
    }
    table{
      font-size: 14px;
    }
    .bg-jambu{
      background: #F2DEDE;
    }
   .dropdown-menu {
    width : 240px !important;
    overflow : auto !important;
    color : black;
    font-weight : bold;
    }
    /* .card-body{
      min-height : 800px !important;
    }
    table{
      color : black !important;
      font-weight : bold;
    }
    table:hover{
      color : white;
      font-weight : bold;
    }
    .card-body{
      background : #123803 !important;
    } */
    .hitam-legam{
      background : #000000 !important;
    }
    .pesan {
      background : #bcddb1;
    }
  </style>
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
    <ul class="navbar-nav ml-auto"><!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->nama }}
        </a>
          <div class="dropdown-menu">
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
  
     <a class="brand-link text-white" data-toggle='dropdown'>
      <img src="{{url('/assets/dist/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <div><span class="brand-text font-weight-light ml-3">MANTAN</span></div>
      <div class="dropdown-menu">
         This Application was created by Mochamad Satriatna
      </div>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <center>
            <div class="brand-link">
            <div class="info p-2 mt-2">
               <a class="brand-text text-bold"> {{ Auth::user()->nama }} </a> 
               <p class="brand-text small text-white ">Work Center : {{Auth::user()->work_center}}</p>
              </div>
              </div>
            </center>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
          
                 <li class="nav-item has-treeview">
                  <a href="#" class="nav-link secondary">
                    <i class="nav-icon fa fa-suitcase"></i>
                    <p>
                      Lihat Stok
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item ">
                        <a href="/qc/stok/standar" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Stok WIP</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="/qc/stok/baku" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Stok Bahan Baku</p>
                        </a>
                    </li>
                    
                  
                    <!-- <li class="nav-item ">
                        <a href="/qc/notifikasi" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Notifikasi</p>
                          <span class="right badge badge-danger">2 notifikasi</span>
                        </a>
                    </li> -->
              </ul>

                </li>
                 

                 
              <li class="nav-item has-treeview">
                  <a href="#" class="nav-link secondary">
                    <i class="nav-icon fa fa-cogs"></i>
                    <p>
                    Kelola Order
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                  <li class="nav-item ">
                    <a href="/qc/order" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Order</p> <span class="right badge badge-danger"> {{$order->count()}} </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="/qc/order/diterima" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Order Diterima</p> <span class="right badge badge-danger"> {{$order2->count()}} </span>
                        </a>
                    </li>
                    
              </ul>

                </li>
                 
       
                    
                    <li class="nav-item has-treeview">
                        <a href="/qc/history" class="nav-link">
                          <i class="fa fa-calendar nav-icon"></i>
                         <p>History</p>
                        </a>
                    </li>

                    <!-- <li class="nav-item ">
                        <a href="/qc/history/update" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                         <p>History Update</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="/qc/history/pemakaian" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                         <p>History Pemakaian</p>
                        </a>
                    </li> -->


        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>



    <!-- /.content -->
    
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
<!-- iCheck 1.0.1 -->
<script src="{{url('/assets/plugins/iCheck/icheck.min.js')}}"></script>
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

  function cek()
  {
    var stok = document.getElementById('stok_qc').value;
    var terpakai = document.getElementById('terpakai').value;

    if(stok >= terpakai){
      return false;
    }else if(stok < terpakai){
      return alert('Stok tidak cukup');
      return false;
    }
  }

  </script>

</body>
</html>
@yield('content')