@extends('layouts.layout')
@section('content')

<style>
  .badge-orange{
    background-color: orange !important;
  }
  #jumlah_pesan,#jumlah_kirim,#jumlah_kirim_serving{
    width: 120px !important;
  }
</style>

<body class="hold-transition sidebar-mini bg-secondary" onload="cekServingAwal()">
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div class="latar text-white mt-5">
        @if( Session::get('kirim') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-danger alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('kirim')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-10 offset-1">  
            <table id="example1" class="table table-bordered table-hover text-center">
              <tbody>
                @foreach($orders as $o)
                <form method='post' action='/rnd/order/proses/unrequest'>
                {{csrf_field()}}
                <input type="hidden" value="{{ Auth::user()->id }}" name="pengirim_id">
                <input type="hidden" value="{{ $o->id_order }}" name="order_id">
                <input type="hidden" value="{{ $o->standar_id }}" name="standar_id">
                <input type="hidden" value="order" name="jenis_perubahan">
                <input type="hidden" value="order" name="jenis_perubahan">
              	<tr>
                  <td colspan='2'><h3 class='form-signin-heading'><center><h5 class="tanda">Form Pengiriman {{$o->jenis_item}} </h5></center></h3></td>
                </tr>
                <tr>
                  <td>Nama Item</td>
                  <td><input type="text" name="nama_item" class="form-control" value="{{$o->nama_item}}" required readonly></td>
                </tr>
                <tr>
                  <td>Kode Oracle</td>
                  <td><input type="text" name="kode_oracle" class="form-control" value="{{$o->kode_oracle}}" required readonly></td>
                </tr>
                <tr>
                  <td>Status RND</td>
                  <td><input type="text" name="status_rnd" id="status_rnd" class="form-control" value="{{$o->status_rnd}}" disabled></td>
                </tr>
                <tr>
                  <td>Tanggal Kadaluarsa RND</td>
                  <td><input type="date" name="tgl_kadaluarsa_rnd" class="form-control" value="{{$o->tgl_kadaluarsa_rnd}}" disabled></td>
                </tr>
                <tr>
                  <td>Stok Awal</td>
                  <td>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="input-group input-group-xs">
                          <input name='stok_rnd' id="stok_rnd" class='form-control' value='{{$o->stok_rnd}}' readonly>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                          </div>
                        </div>
                      </div>
                      <p class="text-bold mt-2">--></p>
                      <div class="col-sm-5">
                        <div class="input-group input-group-xs">
                          <input name='stok_rnd_serving' id="stok_rnd_serving" class='form-control'readonly>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> {{$o->satuan}} </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Serving Size</td>
                  <td><input name='serving_size' id="serving_size" type="number" min="1" step="0.0001" class='form-control' value='{{$o->serving_size}}' readonly></td>
                </tr>
                <tr>
                  <td>Jumlah Kirim <br> <p class="small">(Pilih Salah Satu)</p></td>
                  <td>
                    <div class="row">
                      <div class="col-sm-5">   
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_kirim_gram' value="" autocomplete="off" autofocus onkeyup="disabel()" id="jumlah_kirim_gram" class='form-control' required>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                          </div>
                        </div>
                      </div>
                      <p class="text-bold mt-2">--></p>
                      <div class="col-sm-5">
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_kirim_serving' autocomplete="off" onkeyup="disabel2()" id="jumlah_kirim_serving" class='form-control' required>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> {{$o->satuan}} </button>
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
                            <button class="btn btn-secondary" disabled id="mata"> {{$o->satuan}} </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Alasan</td>
                  <td>
                    @if($o->stat == "keranjangrd")
                      <select name="alasan" class="form-control" required>
                        <option value="">~ Alasan ~</option>
                        <option value="standar baru">Standar Baru</option>
                        <option value="standar improvement">Standar Improvement</option>
                      </select>
                    @else
                      @if($o->status_qc == 'aktif')
                      <input type="hidden" name='alasan' class='form-control' value="{{$o->status_qc}}" readonly>
                      <input type="text" name='alasan_muncul' class='form-control' value="Pembaruan Standar" readonly>
                      @elseif($o->status_qc == 'kadaluarsa')
                      <input type="hidden" name='alasan' class='form-control' value="{{$o->status_qc}}" readonly>
                      <input type="text" name='alasan_muncul' class='form-control' value="Kadaluarsa" readonly>
                      @elseif($o->status_qc == 'hampirkadaluarsa')
                      <input type="hidden" name='alasan' class='form-control' value="{{$o->status_qc}}" readonly>
                      <input type="text" name='alasan_muncul' class='form-control' value="Hampir Kadaluarsa" readonly>
                      @elseif($o->status_qc == 'habis')
                      <input type="hidden" name='alasan' class='form-control' value="{{$o->status_qc}}" readonly>
                      <input type="text" name='alasan_muncul' class='form-control' value="Habis" readonly>
                      @elseif($o->status_qc == 'hampirhabis')
                      <input type="hidden" name='alasan' class='form-control' value="{{$o->status_qc}}" readonly>
                      <input type="text" name='alasan_muncul' class='form-control' value="Hampir Habis" readonly>
                      @endif
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Pengirim</td>
                  <td><input type="text" name="pengirim" class="form-control" value="{{Auth::user()->nama}}" required readonly></td>
                </tr>	
                <tr>
                  <td><a href='/rnd/order' class='btn btn btn-danger' role='button' onclick="document.location.href='/rnd'">Kembali</a></td>
                  <td><button type="submit" class='btn btn btn-success' onclick="myfunction()" value='submit'>Kirim Standar</button></td>
                </tr>
                </form>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

<script>
  function cekServingAwal(){
    var stok_rnd_serving = $('#stok_rnd_serving').val();
    var stok_rnd = $('#stok_rnd').val();
    var serving_size = $('#serving_size').val();
    var a = Math.floor( stok_rnd / serving_size );
    $('#stok_rnd_serving').val(a);

    var jumlah_pesan_serving = $('#jumlah_pesan_serving').val();
    var jumlah_pesan = $('#jumlah_pesan').val();
    var serving_size = $('#serving_size').val();
    var b = Math.floor( jumlah_pesan / serving_size );
    $('#jumlah_pesan_serving').val(b);
  }

  function disabel(){
    var jumlah_kirim_gram = $('#jumlah_kirim_gram').val();
    var jumlah_kirim_serving = $('#jumlah_kirim_serving').val();
    var serving_size = $('#serving_size').val();
    var stok_akhir = $('#stok_akhir').val();
    var stok_akhir_serving = $('#stok_akhir_serving').val();
    var stok_rnd = $('#stok_rnd').val();
    var stok_rnd_serving = $('#stok_rnd_serving').val();
    var c = Math.floor( jumlah_kirim_gram / serving_size );
    var stok_rnd = stok_rnd - jumlah_kirim_gram;
    var e = stok_rnd_serving - c ;
    if (jumlah_kirim_gram < 1) {
      $("#jumlah_kirim_serving").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    }
    else {
        $("#jumlah_kirim_serving").prop("disabled", true).val(c);
      $("#stok_akhir").prop("disabled", false).val(stok_rnd);
      $("#stok_akhir_serving").prop("disabled", false).val(e);
    }
  }

  function disabel2(){
    var jumlah_kirim_serving = $('#jumlah_kirim_serving').val();
    var stok_rnd = $('#stok_rnd').val();
    var stok_rnd_serving = $('#stok_rnd_serving').val();
    var stok_akhir = $('#stok_akhir').val();
    var serving_size = $('#serving_size').val();
    var c = Math.floor(jumlah_kirim_serving * serving_size);
    var d = stok_rnd - c ;
    var e = stok_rnd_serving - jumlah_kirim_serving;
    if (jumlah_kirim_serving != '') {
      $("#jumlah_kirim_gram").prop("disabled", true).val(c);
      $("#stok_akhir").prop("disabled", false).val(d);
      $("#stok_akhir_serving").prop("disabled", false).val(e);
    }
    else {
      $("#jumlah_kirim_gram").prop("disabled", false).val('');
      $("#stok_akhir").prop("disabled", false).val('');
      $("#stok_akhir_serving").prop("disabled", false).val('');
    }  
  }
</script>
@endsection