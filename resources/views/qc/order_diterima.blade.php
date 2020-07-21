@extends('layouts.js')
@section('content')

<style>
  .judul{
    background: #6892d6;
  }
</style>

<div class="content-wrapper bg-aktif">
  <section class="content-header">
    <div class="container-fluid">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6 offset-3 text-center ">
            <div class="card">
              <div class="card-header judul text-white text-bold">
                <h5>Order Diterima</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
  <div class="card">
    <div class="card-body">
    @if($orders->count() == "")
      <div class="latar text-white mt-5">
      @if( Session::get('alert') !="")
        <div class="col-sm-12">
          <div class="col-sm-12">
            <div class="alert bg-success alert-dismissible fade show" role="alert">
              <strong class="text-white">{{Session::get('alert')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
      @endif
      </div>
    
      <table id="example1" class="table table-bordered table-hover text-center">
        <thead class="bg-secondary">
          <tr>
            <th>Nama Standar</th>
            <th>Kode Formula</th>
            <th>Alasan</th>
            <th>Serving Size</th>
            <th>Jumlah Pesan</th>
            <th>Jumlah Kirim</th>
          </tr>
          <tr>
            <td colspan = "9" class="bg-secondary text-white">Tidak Ada Order Diterima</td>
          </tr>
      </table>
  
    @else
        
    <div class="latar text-white text-bold mt-5">
    @if( Session::get('alert') !="")
      <div class="col-sm-12">
        <div class="col-sm-12">
          <div class="alert bg-success alert-dismissible fade show" role="alert">
            <strong class="text-white">{{Session::get('alert')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    @endif
    </div>
         
    <table id="example1" class="table table-bordered table-hover text-center">
      <thead class="bg-secondary">
        <tr>
          <th>Nama Standar</th>
          <th>Kode Formula</th>
          <th>Kode Revisi</th>
          <th>Alasan</th>
          <th>Serving Size</th>
          <th colspan="2">Jumlah Pesan</th>
          <th colspan="2">Jumlah Kirim</th>
          <th>Jenis Item</th>
          <th></th>
        </tr>
      </thead>      
      @foreach($orders as $o)   
        <tr class="data-row">
          <td class="idStandar" style="display:none;">{{$o->standar_id}}</span></td>
          <td class="pemohon" style="display:none;">{{$o->pemohon}} - {{$o->bagian}} </span></td>
          <td class="pengirim" style="display:none;">{{$o->pengirim}}</span></td>
          <td class="status" style="display:none;">{{$o->stat}}</span></td>
          <td class="tglPesan" style="display:none;">{{$o->tgl_order}}</span></td>
          <td class="tglKirim" style="display:none;">{{$o->tgl_kirim}}</span></td>
          <td class="tglKdQC" style="display:none;">{{$o->tgl_kadaluarsa_qc}}</span></td>
          <td class="tglKdRND" style="display:none;">{{$o->tgl_kadaluarsa_rnd}}</span></td>
          <td class="jumlahPesan" style="display:none;">{{$o->jumlah_pesan}}</span></td>
          <td class="servingSize" style="display:none;">{{$o->serving_size}}</span></td>
          <td class="satuan" style="display:none;">{{$o->satuan}}</span></td>
          <td class="gram" style="display:none;">gram</span></td>
          <td class="namaItem">{{$o->nama_item}}</span></td>
          <td class="kodeOracle">{{$o->kode_formula}}</td>
          <td class="kodeRevisi">{{$o->kode_revisi_formula}}</td>
          <td class="jumlahKirim" style="display:none;">{{$o->jumlah_kirim}}</td>
          <td class="jumlahKirimServing" style="display:none;">    <?php echo (ceil($o->jumlah_kirim / $o->serving_size))?></td>
          <td class="jumlahPesanServing" style="display:none;">    <?php echo (ceil($o->jumlah_pesan / $o->serving_size))?></td>
          <td class="alasan">@if($o->alasan == "aktif")Pembaruan Standar
             @else
              {{$o->alasan}}
            @endif</td>
          <td class="">{{$o->serving_size}} gram</td>
          <td class=""> 
            @if($o->jumlah_pesan == "")
            -
            @else
              {{$o->jumlah_pesan}} gram<input type="hidden" value="{{$o->jumlah_pesan}}" name="jumlah_pesan">
            @endif
          </td>
          <td> 
            @if($o->jumlah_pesan == "")
            -
            @else
            <?php echo ceil($o->jumlah_pesan / $o->serving_size)?> {{$o->satuan}}
            @endif
          </td>
          <td class="">{{$o->jumlah_kirim}} gram</td>
          <td class=""> <?php echo ceil($o->jumlah_kirim / $o->serving_size)?> {{$o->satuan}}</td>
          <td class="jenisItem">{{$o->jenis_item}}</td>
          <td class="aksi">
            @if(Auth::user()->work_center == 'ADMIN')
            <button class="btn btn-success" disabled >Terima Order</button>
            @else
            <button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal{{$o->id_order}}"><i class="fa fa-download"></i><span>Terima Order</span></a></button>
            <div class="modal fade ml-5" id="edit-modal{{$o->id_order}}" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Terima Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/qc/terima/order" method="post"> 
                  <div class="modal-body">
                    <table class="table table-bordered text-center">       
                      {{ csrf_field() }}
                      <input type="hidden" name="id_standar" class="form-control" id="modal-input-idStandar" value="{{$o->standar_id}}"> <br/>
                    <input type="hidden" name="id_order" value="{{$o->id_order}}" class="form-control" id="modal-input-idOrder" required></td>
                      <input type="hidden" name="status" class="form-control" id="modal-input-status" required value="{{$o->stat}}"></td>
                      <tr>
                        <td>Nama Produk</td>
                        <td><input type="text" readonly name="nama_item" value="{{$o->nama_item}}" class="form-control" id="modal-input-namaItem" required></td>
                      </tr>
                      <tr>
                        <td>Kode Oracle</td>
                        <td>
                          <input readonly name='kode_oracle' value="{{$o->kode_oracle}}" type='text' class='form-control' id="modal-input-kodeOracle">
                        </td>
                      </tr>
                      <tr>
                        <td>Alasan</td>
                        <td><input readonly name='alasan' class='form-control' id="modal-input-alasan" value="{{$o->alasan}}"></td>
                      </tr>
                      <tr>
                        <td>Serving Size</td>
                        <td>
                          <div class="row">
                            <div class="col-sm-3">
                              <div class="input-group input-group-xs">
                                <input name='serving_size' min="0" step="0.0001" value="{{$o->serving_size}}" id="modal-input-servingSize" class='form-control' readonly>
                                <div class="input-group-append">
                                  <a class="btn btn-secondary modal-input-gram" disabled>Gram</a>
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
                        <td>Jumlah Pesan</td>
                        <td>
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                              <input name='jumlah_pesan' value="{{$o->jumlah_pesan}}" id="modal-input-jumlahPesan" class='form-control' readonly>
                                <div class="input-group-append">
                                  <a class="btn btn-secondary modal-input-gram" disabled>Gram</a>
                                </div>
                              </div>
                            </div> 
                            <p class="text-bold mt-2">--></p>
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                                <input type="text" value="<?php echo (ceil($o->jumlah_pesan / $o->serving_size))?>" name='stok_akhir_serving' id="modal-input-jumlahPesanServing" class='form-control' readonly>
                                <div class="input-group-append">
                                  <a class="btn btn-secondary modal-input-satuan" disabled id="" >{{$o->satuan}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Jumlah Kirim</td>
                        <td>
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                                <input name='jumlah_kirim' value="{{$o->jumlah_kirim}}" id="modal-input-jumlahKirim" class='form-control' readonly>
                                <div class="input-group-append">
                                  <a class="btn btn-secondary modal-input-gram" disabled >Gram</a>
                                </div>
                              </div>
                            </div> 
                            <p class="text-bold mt-2">--></p>
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                                <input type="text" name='stok_akhir_serving' value="<?php echo (ceil($o->jumlah_kirim / $o->serving_size))?>" id="modal-input-jumlahKirimServing" class='stok_akhir_serving form-control' readonly>
                                <div class="input-group-append">
                                  <a class="btn btn-secondary modal-input-satuan" disabled id="">{{$o->satuan}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr> 
                      <tr>
                        <td>Tanggal Kadaluarsa</td>
                        <td>
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                                <input readonly name='tgl_kadaluarsa' value="{{$o->tgl_kadaluarsa_rnd}}" type='date' class='form-control' id="modal-input-tglKdQC">
                              </div>
                            </div> 
                            <p class="text-bold mt-2">--></p>
                            <div class="col-sm-5">
                              <div class="input-group input-group-xs">
                                <input readonly name='tgl_kadaluarsa_rnd' value="{{$o->tgl_kadaluarsa_rnd}}" type='date' class='form-control' id="modal-input-tglKdRND" required>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Tanggal Pesan</td>
                        <td><input readonly name='tgl_order' type='text' value="{{$o->tgl_order}}" class='form-control' id="modal-input-tglPesan"></td>
                      </tr>
                      <tr>
                        <td>Tanggal Dikirim</td>
                        <td><input readonly name='tgl_kirim' value="{{$o->tgl_kirim}}" class='form-control' id="modal-input-tglKirim"></td>
                      </tr>
                      <tr>
                        <td>Jenis Item</td>
                      <td><input readonly name='jenis_item' value="{{$o->jenis_item}}" class='form-control' id="modal-input-jenisItem"></td>
                      </tr>
                      <tr>
                        <td>Pemohon</td>
                        <td><input readonly name='jenis_item' value="{{$o->pemohon}}" class='form-control' id="modal-input-pemohon"></td>
                      </tr>
                      <tr>
                        <td>Pengirim</td>
                        <td><input readonly name='jenis_item' value="{{$o->pengirim}}" class='form-control' id="modal-input-pengirim"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Terima</button>
                    <a type="button" class="btn btn-secondary" data-dismiss="modal" style="color:white">Tutup</a>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            @endif
          </td>
        </tr>
      @endforeach
    </table>
    @endif
    </div>
  </div>
</div>
@endsection
 
@push('scripts')
<script>
  $(document).ready(function() {

    $(document).on('click', "#edit-item", function() {
      $(this).addClass('edit-item-trigger-clicked'); 
      var options = {
        'backdrop': 'static'
      };
      $('#edit-modal').modal(options)
    })

    // on modal show
    $('#edit-modal').on('show.bs.modal', function() {
      var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
      
    
      var row = el.closest(".data-row");

      // get the data
      var id = el.data('item-id');
      var idStandar = row.children(".idStandar").text();
      var pemohon = row.children(".pemohon").text();
      var pengirim = row.children(".pengirim").text();
      var status = row.children(".status").text();
      var namaItem = row.children(".namaItem").text();
      var kodeOracle = row.children(".kodeOracle").text();
      var kodeRevisi = row.children(".kodeRevisi").text();
      var alasan = row.children(".alasan").text();
      var servingSize = row.children(".servingSize").text();
      var jumlahPesan = row.children(".jumlahPesan").text();
      var satuan = row.children(".satuan").text();
      var gram = row.children(".gram").text();
      var jumlahPesan = row.children(".jumlahPesan").text();
      var hitungPesan = row.children(".jumlahPesan").text();
      var jumlahPesanServing = row.children(".jumlahPesanServing").text();
      var jumlahKirim = row.children(".jumlahKirim").text();
      var jumlahKirimServing = row.children(".jumlahKirimServing").text();
      var tglKdQC = row.children(".tglKdQC").text();
      var tglKdRND = row.children(".tglKdRND").text();
      var tglPesan = row.children(".tglPesan").text();
      var tglKirim = row.children(".tglKirim").text();
      var jenisItem = row.children(".jenisItem").text();

      // fill the data in the input fields
      $("#modal-input-idOrder").val(id);
      $("#modal-input-idStandar").val(idStandar);
      $("#modal-input-pemohon").val(pemohon);
      $("#modal-input-pengirim").val(pengirim);
      $("#modal-input-status").val(status);
      $("#modal-input-namaItem").val(namaItem);
      $("#modal-input-kodeOracle").val(kodeOracle);
      $(".modal-input-satuan").text(satuan);
      $(".modal-input-gram").text(gram);
      $("#modal-input-alasan").val(alasan);
      $("#modal-input-servingSize").val(servingSize);
      $("#modal-input-jumlahPesan").val(jumlahPesan);
      $("#modal-input-jumlahPesanServing").val(jumlahPesanServing);
      $("#modal-input-jumlahKirim").val(jumlahKirim);
      $("#modal-input-jumlahKirimServing").val(jumlahKirimServing);
      $("#modal-input-tglKdQC").val(tglKdQC);
      $("#modal-input-tglKdRND").val(tglKdRND);
      $("#modal-input-tglPesan").val(tglPesan);
      $("#modal-input-tglKirim").val(tglKirim);
      $("#modal-input-jenisItem").val(jenisItem);

    })

    // on modal hide
    $('#edit-modal').on('hide.bs.modal', function() {
      $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
      $("#edit-form").trigger("reset");
    })
  })
</script>
@endpush