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
                <form method='post' action='/rnd/order/proses'>
                {{csrf_field()}}
                <input type="hidden" value="{{ Auth::user()->id }}" name="pengirim_id">
                <input type="hidden" value="{{ $o->id_order }}" name="order_id">
                <input type="hidden" value="{{ $o->standar_id }}" name="standar_id">
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
                  <td>Tanggal Order</td>
                  <td><input type="date" name="tgl_order" class="form-control" value="{{$o->tgl_order}}" readonly></td>
                </tr>
                <tr>
                  <td>Alasan</td>
                  <td>
                    <input type="hidden" name='alasan' class='form-control' value="{{$o->alasan}}" readonly>
                    @if($o->alasan == 'aktif')
                    <input type="text" name='alasan_muncul' class='form-control' value="Pembaruan Standar" readonly>
                    @elseif($o->alasan == 'kadaluarsa')
                    <input type="text" name='alasan_muncul' class='form-control' value="kadaluarsa" readonly>
                    @elseif($o->alasan == 'hampirExpired')
                    <input type="text" name='alasan_muncul' class='form-control'  value="hampir kadaluarsa"  readonly>
                    @elseif($o->alasan == 'habis')
                    <input type="text" name='alasan_muncul' class='form-control'  value="habis"  readonly>
                    @elseif($o->alasan == 'hampirKosong')
                    <input type="text" name='alasan_muncul' class='form-control'  value="hampir habis"  readonly>
                    @endif
                  </td>
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
                  <td>Serving Size</td>
                  <td>
                    <div class="row">
                      <div class="col-sm-3">   
                        <div class="input-group input-group-xs">
                          <input name='serving_size' id="serving_size" type="number" class='form-control' value='{{$o->serving_size}}' readonly>
                          <div class="input-group-append">
                              <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                          </div>
                        </div>
                      </div>
                      <p class="mt-2">Catatan</p>
                      <div class="col-sm-7">
                        <div class="input-group input-group-xs">
                          <input type="text" value="{{$o->catatan_serving_size}}" class='form-control' readonly>
                          <div class="input-group-append">
                              <button class="btn btn-secondary fa fa-book" disabled id="mata"></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Stok Awal RND</td>
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
                  <td>Jumlah Pesan <br> <p class="small">(Pilih Salah Satu)</p></td>
                  <td>
                    <div class="row">
                      <div class="col-sm-5">   
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_pesan' value="{{$o->jumlah_pesan}}" readonly autocomplete="off" autofocus onkeyup="disabel()" id="jumlah_pesan" class='form-control' required>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                          </div>
                        </div>
                      </div>
                      <p class="text-bold mt-2">--></p>
                      <div class="col-sm-5">
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_pesan_serving' autocomplete="off" readonly onkeyup="disabel2()" id="jumlah_pesan_serving" class='form-control' required>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> {{$o->satuan}} </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Jumlah Kirim <br> <p class="small"> (jumlah kirim max sesuai stok awal)</p></td>
                  <td>
                    <div class="row">
                      <div class="col-sm-5">   
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_kirim' min="0" max="{{$o->stok_rnd}}" value="" autocomplete="off" autofocus onkeyup="disabel()" id="jumlah_kirim" class='form-control' required>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> Gram</button>
                          </div>
                        </div>
                      </div>
                      <p class="text-bold mt-2">--></p>
                      <div class="col-sm-5">
                        <div class="input-group input-group-xs">
                        <input type="number" name='jumlah_kirim_serving' autocomplete="off" onkeyup="disabel2()" id="jumlah_kirim_serving" class='form-control' required readonly>
                          <div class="input-group-append">
                            <button class="btn btn-secondary" disabled id="mata"> {{$o->satuan}} </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Catatan Pengiriman</td>
                  <td><textarea name="catatan" id="catatan" cols="105" rows="3" ></textarea></td>
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
    var a = Math.ceil( stok_rnd / serving_size );
    $('#stok_rnd_serving').val(a);


    var jumlah_pesan_serving = $('#jumlah_pesan_serving').val();
    var jumlah_pesan = $('#jumlah_pesan').val();
    var serving_size = $('#serving_size').val();
    var b = Math.ceil( jumlah_pesan / serving_size );
    $('#jumlah_pesan_serving').val(b);
  }

  function disabel(){
    var jumlah_kirim = $('#jumlah_kirim').val();
    var jumlah_kirim_serving = $('#jumlah_kirim_serving').val();
    var serving_size = $('#serving_size').val();
    var stok_akhir = $('#stok_akhir').val();
    var stok_akhir_serving = $('#stok_akhir_serving').val();
    var stok_rnd = $('#stok_rnd').val();
    var stok_rnd_serving = $('#stok_rnd_serving').val();
    var c = Math.ceil( jumlah_kirim / serving_size );
    var stok_rnd = stok_rnd - jumlah_kirim;
    var e = Math.ceil( stok_rnd / serving_size ) ;
      if (jumlah_kirim < 1) {
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
    var c = Math.ceil(jumlah_kirim_serving * serving_size);
    var d = stok_rnd - c ;
    var e = stok_rnd_serving - jumlah_kirim_serving;
      if (jumlah_kirim_serving != '') {
        $("#jumlah_kirim").prop("disabled", true).val(c);
        $("#stok_akhir").prop("disabled", false).val(d);
        $("#stok_akhir_serving").prop("disabled", false).val(e);
      }
      else {
        $("#jumlah_kirim").prop("disabled", false).val('');
        $("#stok_akhir").prop("disabled", false).val('');
        $("#stok_akhir_serving").prop("disabled", false).val('');
      }
  }
</script>
@endsection