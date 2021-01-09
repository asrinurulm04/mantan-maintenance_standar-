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
            <form class='form' method='post' action="/qc/stok/update">
            {{ csrf_field() }}
            <input type="hidden" name="id_standar" value="{{ $s->id_standar }}">
            <input type="hidden" name="nama_item" value="{{ $s->nama_item }}">
					  <tr>
						  <td colspan='2'><h3 class='form-signin-heading'>
              <center><h5 class="tanda">Tambah Stok ( Bahan Baku )</h5></center></h3></td>
					  </tr>
				    <tr>
						  <td>Nama Produk</td>
						  <td><input name='nama_item' type='text' class='form-control' value='{{$s->nama_item}}' readonly></td>
					  </tr>
					  <tr>
						  <td>Kode Oracle</td>
						  <td>
							  <input name='kode_oracle' type='text' class='form-control' value='{{$s->kode_oracle}}' readonly>
						  </td>
					  </tr>
            <tr>
              <td>Tanggal Terima</td>
              <td><input name='tgl_terima' type='date' class='form-control' value='{{$s->tgl_terima}}' readonly></td>
            </tr>
            
            <tr>
						  <td>Alasan</td>
						  <td>
                @if($s->status_qc == 'aktif')
                <input type="hidden" name='alasan' id="alasan" class='form-control' value="{{$s->status_qc}}" readonly>
                <input type="text" name='alasan_muncul' class='form-control' value="Pembaruan Standar" readonly>
                @elseif($s->status_qc == 'kadaluarsa')
                <input type="hidden" name='alasan' id="alasan" class='form-control' value="{{$s->status_qc}}" readonly>
                <input type="text" name='alasan_muncul' class='form-control' value="Kadaluarsa" readonly>
                @elseif($s->status_qc == 'hampirExpired')
                <input type="hidden" name='alasan' id="alasan" class='form-control' value="{{$s->status_qc}}" readonly>
                <input type="text" name='alasan_muncul' class='form-control' value="Hampir Kadaluarsa" readonly>
                @elseif($s->status_qc == 'habis')
                <input type="hidden" name='alasan' id="alasan" class='form-control' value="{{$s->status_qc}}" readonly>
                <input type="text" name='alasan_muncul' class='form-control' value="Habis" readonly>
                @elseif($s->status_qc == 'HampirKosong')
                <input type="hidden" name='alasan' id="alasan" class='form-control' value="Hampir Habis" readonly>
                <input type="text" name='alasan_muncul' class='form-control' value="Hampir Habis" readonly>
                @endif
              </td>
					  </tr>
            
            <tr>
              <td>Serving Size</td>
              <td>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="input-group input-group-xs">
                      <input name='serving_size' id="serving_size" min="1" step="0.0001" type="number" class='form-control' value='{{$s->serving_size}}'>
                      <div class="input-group-append">
                        <a class="btn btn-secondary modal-input-gram" disabled>Gram</a>
                      </div>
                    </div>
                  </div> 
                  <p class="mt-2">Catatan</p>
                  <div class="col-sm-7">
                    <div class="input-group input-group-xs">
                      <input type="text" value="{{$s->catatan_serving_size}}" class='form-control' >
                      <div class="input-group-append">
                          <button class="btn btn-secondary fa fa-book" disabled id="mata"></button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>

					  <tr>
              <td>Stok Awal</td>
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
              <td>Jumlah Penambahan <br> <p class="small">(Pilih Salah Satu)</p></td>
              <td>
                <div class="row">
                  <div class="col-sm-5">   
                    <div class="input-group input-group-xs">
                      <input type="number" name='jumlah_penambahan_gram' min="0" autocomplete="off" autofocus onkeyup="disabel()" id="jumlah_penambahan_gram" class='form-control' required>
                      <div class="input-group-append">
                        <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                      </div>
                    </div>
                  </div>
                  <p class="text-bold mt-2">--></p>
                  <div class="col-sm-5">
                    <div class="input-group input-group-xs">
                    <input type="number" name='jumlah_penambahan_serving' autocomplete="off" onkeyup="disabel2()" id="jumlah_penambahan_serving" class='form-control' >
                      <div class="input-group-append">
                        <button class="btn btn-secondary" disabled id="mata"> {{$s->satuan}} </button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>Stok Akhir</td>
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

            <tr>
              <td>Tanggal Kadaluarsa</td>
              <td><input name='tgl_kadaluarsa_qc_terbaru' type='date' class='form-control' value='{{$s->tgl_kadaluarsa_qc}}'></td>
            </tr>
         
            <!-- <tr>
              <td>Jumlah Serving</td>
              <td><input type="number" name='jumlah_serving' id="jumlah_serving"  class='form-control' readonly></td>
            </tr> -->
					
            <tr>
              <td align='right'><a href='/qc/stok/baku' class='btn btn-sm btn btn-danger' name='go' role='button'>Kembali</a>&nbsp;
              <button class='btn btn-sm btn-success' name='go' value='submit'>Tambah Stok</button></td></form>
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
  }

  function disabel(){
    var alasan = $('#alasan').val();
    var jumlah_penambahan_gram = $('#jumlah_penambahan_gram').val();
    var jumlah_penambahan_serving = $('#jumlah_penambahan_serving').val();
    var serving_size = $('#serving_size').val();
    var stok_akhir = $('#stok_akhir').val();
    var stok_akhir_serving = $('#stok_akhir_serving').val();
    var stok_qc = $('#stok_qc').val();
    var g = Math.ceil( stok_qc / serving_size );
    $('#stok_qc_serving').val(g);
    var stok_qc_serving = $('#stok_qc_serving').val();
    var c = Math.ceil( jumlah_penambahan_gram / serving_size );
    var stok_qc = parseInt(stok_qc) + parseInt(jumlah_penambahan_gram);
    var e = parseInt( stok_qc_serving ) + parseInt( c );
    var f = Math.ceil(stok_qc / serving_size);
    console.log(stok_qc);
    if (jumlah_penambahan_gram < 1) {
      $("#jumlah_penambahan_serving").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    }
    else {
        $("#jumlah_penambahan_serving").prop("disabled", true).val(c);
        if(alasan == 'kadaluarsa')
      {
        $("#stok_akhir").prop("disabled", false).val(stok_qc);
        $("#stok_akhir_serving").prop("disabled", false).val(f);
      }
    }
  }

  function disabel2(){
    var jumlah_penambahan_serving = $('#jumlah_penambahan_serving').val();
    var stok_qc = $('#stok_qc').val();
    var stok_qc_serving = $('#stok_qc_serving').val();
    var stok_akhir = $('#stok_akhir').val();
    var serving_size = $('#serving_size').val();
    var c = Math.ceil(jumlah_penambahan_serving * serving_size);
    var d = parseInt(stok_qc) + parseInt(c) ;
    var e = parseInt(stok_qc_serving) + parseInt(jumlah_penambahan_serving);
    if (jumlah_penambahan_serving != '') {
      $("#jumlah_penambahan_gram").prop("disabled", true).val(c);
      $("#stok_akhir").prop("disabled", false).val(d);
      $("#stok_akhir_serving").prop("disabled", false).val(e);
    }
    else {
      $("#jumlah_penambahan_gram").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    }  
  }

</script>
@endsection