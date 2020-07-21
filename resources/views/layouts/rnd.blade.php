<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MANTAN | Maintenance Standar</title>
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/js/app.css">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon -->
<link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
<link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
<link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
  <!-- akhir Favicon -->
<!-- Font Awesome -->
<link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
<!-- Theme style -->
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
  .bg-pink{
      background-color: pink !important;
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


    [tooltip] {
      position: relative; /* opinion 1 */
}

/* Applies to all tooltips */
[tooltip]::before,
[tooltip]::after {
  text-transform: none; /* opinion 2 */
font-size: .9em; /* opinion 3 */
line-height: 1;
user-select: none;
pointer-events: none;
position: absolute;
display: none;
opacity: 0;
}
[tooltip]::before {
  content: '';
border: 5px solid transparent; /* opinion 4 */
z-index: 1001; /* absurdity 1 */
}
[tooltip]::after {
  content: attr(tooltip); /* magic! */
/* most of the rest of this is opinion */
font-family: Helvetica, sans-serif;
text-align: center;
/* 
  Let the content set the size of the tooltips 
  but this will also keep them from being obnoxious
  */
min-width: 3em;
max-width: 21em;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
padding: 1ch 1.5ch;
border-radius: .3ch;
box-shadow: 0 1em 2em -.5em rgba(0, 0, 0, 0.35);
background: #333;
color: #fff;
z-index: 1000; /* absurdity 2 */
}

/* Make the tooltips respond to hover */
[tooltip]:hover::before,
[tooltip]:hover::after {
  display: block;
}

/* don't show empty tooltips */
[tooltip='']::before,
[tooltip='']::after {
  display: none !important;
}

/* FLOW: UP */
[tooltip]:not([flow])::before,
[tooltip][flow^="up"]::before {
  bottom: 100%;
border-bottom-width: 0;
border-top-color: #333;
}
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::after {
  bottom: calc(100% + 5px);
}
[tooltip]:not([flow])::before,
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::before,
[tooltip][flow^="up"]::after {
  left: 50%;
transform: translate(-50%, -.5em);
}

/* FLOW: DOWN */
[tooltip][flow^="down"]::before {
  top: 100%;
border-top-width: 0;
border-bottom-color: #333;
}
[tooltip][flow^="down"]::after {
  top: calc(100% + 5px);
}
[tooltip][flow^="down"]::before,
[tooltip][flow^="down"]::after {
  left: 50%;
transform: translate(-50%, .5em);
}

/* FLOW: LEFT */
[tooltip][flow^="left"]::before {
  top: 50%;
border-right-width: 0;
border-left-color: #333;
left: calc(0em - 5px);
transform: translate(-.5em, -50%);
}
[tooltip][flow^="left"]::after {
  top: 50%;
right: calc(100% + 5px);
transform: translate(-.5em, -50%);
}

/* FLOW: RIGHT */
[tooltip][flow^="right"]::before {
  top: 50%;
border-left-width: 0;
border-right-color: #333;
right: calc(0em - 5px);
transform: translate(.5em, -50%);
}
[tooltip][flow^="right"]::after {
  top: 50%;
left: calc(100% + 5px);
transform: translate(.5em, -50%);
}

/* KEYFRAMES */
@keyframes tooltips-vert {
  to {
    opacity: .9;
  transform: translate(-50%, 0);
}
}

@keyframes tooltips-horz {
  to {
    opacity: .9;
  transform: translate(0, -50%);
}
}

/* FX All The Things */ 
[tooltip]:not([flow]):hover::before,
[tooltip]:not([flow]):hover::after,
[tooltip][flow^="up"]:hover::before,
[tooltip][flow^="up"]:hover::after,
[tooltip][flow^="down"]:hover::before,
[tooltip][flow^="down"]:hover::after {
  animation: tooltips-vert 300ms ease-out forwards;
}

[tooltip][flow^="left"]:hover::before,
[tooltip][flow^="left"]:hover::after,
[tooltip][flow^="right"]:hover::before,
[tooltip][flow^="right"]:hover::after {
  animation: tooltips-horz 300ms ease-out forwards;
}

}
 
 </style>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
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
   <a class="brand-link text-white">
   <img src="{{url('/assets/dist/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light ml-3">MANTAN</span>
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
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link secondary">
        <i class="nav-icon fa fa-book"></i>
        <p>
        Lihat Data Standar
        <i class="right fa fa-angle-left"></i>
        </p>
        </a>
        <ul class="nav nav-treeview">

        <li class="nav-item ">
          <a href="/rnd/data/standar" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Standar WIP</p>
          </a>
        </li>

        <li class="nav-item ">
          <a href="/rnd/standar/baku" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Standar Bahan Baku</p>
          </a>
        </li>
          <!-- <li class="nav-item ">
          <a href="/rnd/standar/lokasi" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Standar Lokasi</p>
          </a>
          </li> -->
          <li class="nav-item ">
              <a href="/rnd/standar/freeze" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Standar Freeze</p>
              </a>
          </li>
      </ul>
      </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link secondary">
            <i class="nav-icon fa fa-edit"></i>
            <p>
              Input
              <i class="right fa fa-angle-left"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">

          <li class="nav-item ">
          <a href="/rnd/input/wip/baru" class="nav-link">
              <i class="fa fa-circle-o nav-icon"></i>
              <p>Input WIP</p>
          </a>
          </li>

          <li class="nav-item ">
          <a href="/rnd/input/bahan/baku/baru" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Input Bahan Baku</p>
          </a>
          </li>

          <li class="nav-item ">
            <a href="/rnd/input/item/baru" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Input Kategori</p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="/rnd/input/item/baru" class="nav-link">
            <i class="fa fa-circle-o nav-icon"></i>
            <p>Input Plant</p>
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

            <li class="nav-item ">
              <a href="/rnd/order" class="nav-link">
              <i class="fa fa-shopping-cart nav-icon"></i>
              <p>Order</p>
              <span class="right badge badge-danger"> {{$order->count()}}</span>
              </a>
            </li>

             <li class="nav-item ">
             <a href="/rnd/history" class="nav-link">
             <i class="fa fa-calendar nav-icon"></i>
             <p>History</p>
             </a>
             </li>

            </li>

            <!-- <li class="nav-item ">
            <a href="/rnd/notifikasi" class="nav-link">
              <i class="fa fa-circle-o nav-icon"></i>
              <p>Notifikasi</p>
              <span class="right badge badge-danger">2 notifikasi</span>
            </a>
            </li> -->
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
            </aside>


<!-- MEMPENGARUHI LOGOUT -->
<!-- jQuery -->
<script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('assets/https://code.jquery.com/ui/1.12. 	/jquery-ui.min.js')}} "></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{url('/assets/dist/js/adminlte.js')}} "></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/assets/v')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/assets/dist/js/demo.js')}} "></script>

<script>
  $(function () {
      //Initialize Select2 Elements
    $('.select2').select2()
  })

  $(document).ready(function() {
      $('.select2').select2();
});
</script>

</body>
</html>
@yield('content')