@extends('layouts.layout')
@section('content')

<body class="hold-transition sidebar-mini bg-secondary" onload="cekServingAwal()">
<div class="content-wrapper"><br>
  <div class="col-sm-12">
    <div class="col-sm-10 offset-1">
      <div class="card">
        <div class="card-body mb-5">
        @if( Session::get('cekStok') !="")
          <div class="latar text-white mt-5">
            <div class="col-sm-12">
              <div class="col-sm-12">
                <div class="alert bg-danger alert-dismissible fade show" role="alert">
                  <strong class="text-white">{{Session::get('cekStok')}}</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endif

        <table id="example1" class="table table-bordered table-hover text-center">
          @foreach($standar as $s)
					<form class='form' method='post' action="/qc/pakai/stok">
          {{ csrf_field() }}
					<input type="hidden" name="id_standar" value="{{ $s->id_standar }}">
					<input type="hidden" name="nama_item" value="{{ $s->nama_item }}">
          <input type="hidden" name="jenis_item" value="{{ $s->jenis_item }}">
          <input type="hidden" name="pemohon_id" value="{{ Auth::user()->id }}"> <br/>
					<tr>
						<td colspan='2'>
              <h3 class='form-signin-heading'>
                @if($s->jenis_item_id == '1')
                <center><h5>Gunakan Stok ( WIP )</h5></center>
                @else
                <center><h5>Gunakan Stok ( Bahan Baku )</h5></center>
                @endif
              </h3>
            </td>
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
						<td>Serving Size ( Gram )</td>
						<td>
              <div class="row">
                <div class="col-sm-3">   
                  <div class="input-group input-group-xs">
                    <input name='serving_size' id="serving_size" min="1" step="0.0001" type="number" class='form-control' value='{{$s->serving_size}}' >
                    <div class="input-group-append">
                        <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                    </div>
                  </div>
                </div>
                <p class="mt-2">Catatan</p>
                <div class="col-sm-7">
                  <div class="input-group input-group-xs">
                    <input type="text" value="{{$s->catatan_serving_size}}" class='form-control' readonly>
                    <div class="input-group-append">
                        <button class="btn btn-secondary fa fa-book" disabled id="mata"></button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
					</tr>
					<tr>
						<td>Stok Sebelum Dipakai</td>
						<td>
              <div class="row">
                <div class="col-sm-5">
                  <div class="input-group input-group-xs">
                    <input name='stok_qc' id="stok_qc" class='form-control' value='{{$s->stok_qc}}' readonly>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                    </div>
                  </div>
                </div>
                <p class="text-bold mt-2">--></p>
                <div class="col-sm-5">
                  <div class="input-group input-group-xs">
                    <input name='stok_qc_serving' id="stok_qc_serving" class='form-control'readonly>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> {{$s->satuan}} </button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
					</tr>
          
					<tr>
						<td>Jumlah Pakai <br> <p class="small">(Pilih Salah Satu)</p></td>
						<td>
              <div class="row">
                <div class="col-sm-5">   
                  <div class="input-group input-group-xs">
                    <input type="number" max="{{$s->stok_qc}}" name='jumlah_pakai_gram' min="0" autocomplete="off" autofocus onkeyup="disabel()" id="jumlah_pakai_gram" class='form-control' required>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                    </div>
                  </div>
                </div>
                <p class="text-bold mt-2">--></p>
                <div class="col-sm-5">
                  <div class="input-group input-group-xs">
                    <input type="number" name='jumlah_pakai_serving' autocomplete="off" onkeyup="disabel2()" id="jumlah_pakai_serving" class='form-control' required>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> {{$s->satuan}} </button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
					</tr>
            
          <tr>
						<td>Stok Sesudah Dipakai</td>
						<td>
              <div class="row">
                <div class="col-sm-5">
                  <div class="input-group input-group-xs">
                    <input name='stok_akhir' id="stok_akhir" class='stok_akhir form-control' value='' readonly>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                    </div>
                  </div>
                </div> 
                <p class="text-bold mt-2">--></p>
                <div class="col-sm-5">
                  <div class="input-group input-group-xs">
                    <input type="text" name='stok_akhir_serving' id="stok_akhir_serving" class='stok_akhir_serving form-control' readonly>
                    <div class="input-group-append">
                      <button class="btn btn-secondary" disabled id="mata"> {{$s->satuan}} </button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
					</tr>

          <!-- <tr>
						<td>Jumlah Serving</td>
						<td><input type="number" name='jumlah_serving' id="jumlah_serving"  class='form-control' readonly></td>
					</tr> -->
					
          <tr>
            <td align='right'>
            @if($s->jenis_item == "WIP")
            <a href='/qc/stok/standar' class='btn btn-sm btn btn-danger' name='go' role='button'>Kembali</a>
            @else
            <a href='/qc/stok/baku' class='btn btn-sm btn btn-danger' name='go' role='button'>Kembali</a>
            @endif
            &nbsp;
            <button class='btn btn-sm btn btn-primary' name='go' value='submit'>Gunakan</i></button><td>
          </tr>
          </form>
          @endforeach
        </table>
        </div>
      </div>
    </div>
  </div>    
</div><br>

<script>

  function cekServingAwal(){
    var stok_qc_serving = $('#stok_qc_serving').val();
    var stok_qc = $('#stok_qc').val();
    var serving_size = $('#serving_size').val();
    var a = Math.ceil( stok_qc / serving_size );
    $('#stok_qc_serving').val(a);
    console.log(a);
  }

  function disabel(){
    var jumlah_pakai_gram = $('#jumlah_pakai_gram').val();
    var jumlah_pakai_serving = $('#jumlah_pakai_serving').val();
    var serving_size = $('#serving_size').val();
    var stok_akhir = $('#stok_akhir').val();
    var stok_akhir_serving = $('#stok_akhir_serving').val();
    var stok_qc = $('#stok_qc').val();
    var s = Math.ceil( stok_qc / serving_size );
    $('#stok_qc_serving').val(s);
    var stok_qc_serving = $('#stok_qc_serving').val();
    var c = Math.ceil( jumlah_pakai_gram / serving_size );
    var d = Math.ceil( stok_qc - jumlah_pakai_gram );
    var e = Math.ceil( d / serving_size );
    if (jumlah_pakai_gram < 1) {
      $("#jumlah_pakai_serving").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    }
    else {
      $("#jumlah_pakai_serving").prop("disabled", true).val(c);
      $("#stok_akhir").prop("disabled", false).val(d);
      $("#stok_akhir_serving").prop("disabled", false).val(e);
    } 
  }

  function disabel2(){
    var jumlah_pakai_serving = $('#jumlah_pakai_serving').val();
    var stok_qc = $('#stok_qc').val();
    var stok_qc_serving = $('#stok_qc_serving').val();
    var stok_akhir = $('#stok_akhir').val();
    var serving_size = $('#serving_size').val();
    var c = Math.ceil(jumlah_pakai_serving * serving_size);
    var d = Math.ceil( stok_qc - c );
    var e = Math.ceil( stok_qc_serving - jumlah_pakai_serving );
    if (jumlah_pakai_serving != '') {
      $("#jumlah_pakai_gram").prop("disabled", true).val(c);
      $("#stok_akhir").prop("disabled", false).val(d);
      $("#stok_akhir_serving").prop("disabled", false).val(e);
    }
    else {
      $("#jumlah_pakai_gram").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    } 
  }

</script>
@endsection