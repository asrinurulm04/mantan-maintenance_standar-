<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MANTAN | Maintenance Standar</title>
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/js/app.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{('/asset/ico/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{('/assets/ico/favicon-16x16.png')}}" sizes="16x16" />
  <link rel="stylesheet" href="{{('/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{('/assets/https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{url('/assets/dist/css/adminlte.min.css')}}">
	<style>
		.tanda{
			margin-left:100px !important;
		}
	</style>
</head>

<body class="hold-transition sidebar-mini bg-secondary">
<div class="col-sm-12">
  <div class="col-sm-6 offset-3 mt-5">
    <div class="card">
      <div class="card-body">
        <table id="example1" class="table bg-dark table-bordered table-hover text-center">
          @foreach($standar as $s)
					<form class='form' method='post' action="/rnd/masuk/keranjang/">
          {{ csrf_field() }}
					<input type="hidden" name="standar_id" value="{{ $s->id_standar }}">
          <input type="hidden" name="pengirim_id" value="{{ Auth::user()->id }}"> <br/>
					<tr>
						<td colspan='2'><h3 class='form-signin-heading'><center><b class="tanda">Masukkan Ke Keranjang</b></center></h3></td>
					</tr>
				  <tr>
						<td>Nama Produk</td>
						<td><input name='nama_item' type='text' class='form-control' value='{{$s->nama_item}}' readonly></td>
					</tr>
					<tr>
						<td>Kode Formula</td>
						<td>
							<input name='kode_formula' type='text' class='form-control' value='{{$s->kode_formula}}' readonly>
						</td>
					</tr>
					<tr>
						<td>Stok</td>
						<td><input name='stok_rnd' class='form-control' value='{{$s->stok_rnd}}' readonly></td>
					</tr>
					<tr>
						<td>Jumlah Kirim</td>
						<td><input type="number" name='jumlah_kirim' class='form-control' required></td>
					</tr>
					<tr>
						<td>Alasan</td>
						<td>
              <select name="alasan" class="form-control" required>
                <option value="">Alasan</option>
                <option value="standar baru">Standar Baru</option>
                <option value="standar improvement">Standar Improvement</option>
              </select>
            </td>
					</tr>
          <tr>
            <td></td>
            <td align='right'><br><button class='btn btn btn-success' name='go' value='submit'><i class="fa fa-shopping-cart"></i></button>&nbsp;
            <a href='/rnd/data/standar' class='btn btn btn-danger' name='go' role='button'>Kembali</a><td>
          </tr>
          </form>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>    
     
<script src="{{url('assets/plugins/jquery/jquery.min.js')}} "></script>
<script src="{{url('assets/https://code.jquery.com/ui/1.12. 	/jquery-ui.min.js')}} "></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
<script src="{{url('/assets/dist/js/adminlte.js')}} "></script>
<script src="{{url('/assets/v')}} "></script>
<script src="{{url('/assets/dist/js/demo.js')}} "></script>

<script>
  $(function () {
    $('.select2').select2()
  })
  $("#example1").DataTable();
  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass   : 'iradio_minimal-blue'
  })
  $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass   : 'iradio_minimal-red'
  })
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  })

	$(function () {
    $('.select2').select2()
  })

  $(document).ready(function() {
    $('.select2').select2();
  });
</script>