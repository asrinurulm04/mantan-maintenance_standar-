@extends('layouts.layout')
@section('content')

<style>
  .pesan{
    background: #a5adba;
  }
  .judul{
    background: #6892d6;
  }
  .notif{
    background-color: #286303 !important;
    color: white;
    font-weight: bold;
  }
</style>

<div class="content-wrapper"><br>
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-10 offset-1">
        <div class="card">
          <div class="card-body">
            @if( Session::get('message') !="")
            <div class="latar text-white text-bold mt-5">
              <div class="col-sm-12">
                <div class="col-sm-12">
                  <div class="alert bg-success alert-dismissible fade show" role="alert">
                    <strong class="text-white">{{Session::get('message')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            @endif

						<div class="card-header flat bg-secondary text-center">
							<h5 class="">Input Bahan Baku Baru</h5>
						</div>
						<table class="table table-bordered text-center">
              <form action="/rnd/input/bahan/baku/baru/store" method="post">
              {{csrf_field()}}
              <input type="hidden" name="users_id" class="form-control" value="{{Auth::user()->id}}">
				      <tr>
                <td>Nama Produk</td>
                <td><input name='nama_item' type='text' class='form-control' value=''></td>
              </tr>
              <tr>
                <td>Kode Formula</td>
                <td>
                  <input type="text" name="kode_formula" class="form-control" tooltip="Kode Formula" required>
                </td>
              </tr>
              <tr>
                <td>Kode Oracle</td>
                <td>
                  <input type="text" name="kode_oracle" class="form-control" tooltip="Kode Oracle" required>
                </td>
              </tr>
              <tr>
                <td>Lokasi</td>
                <td> <input type="text" name="lokasi" class="form-control" tooltip="Lokasi" required></td>
    					</tr>
              <tr>
                <td>Stok ( Gram )</td>
                <td> <input type="number" name="stok_rnd" class="form-control" tooltip="Jumlah Stok" required></td>
              </tr>
              <tr>
                <td>Serving Size ( Gram )</td>
                <td><input type="number" name="serving_size" min="1" step="0.0001" class="form-control" tooltip="Serving Size" required></td>
              </tr>
              <tr>
                <td>Catatan Serving Size </td>
                <td><input type="text" name="catatan" class="form-control" tooltip="Catatan Serving Size" required></td>
              </tr>
              <tr>
                <td>Satuan</td>
                <td>
                  <select name="satuan" required class="form-control" tooltip="Satuan">
                    <option value="">-- Satuan --</option>-
                    @foreach($tb_satuan as $satuan)
                    <option value="{{$satuan->id_satuan}} ">{{$satuan->satuan}} </option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Sub. Kategori</td>
                <td>
                  <select name="sub_kategori" required class="form-control" tooltip="Kategori">
                    <option value=''> -- Sub Kategori -- </option>
                    @foreach($tb_sub_kategori as $tb)
                    <option value="{{$tb->id_sub_kategori}}">{{$tb->nama_kategori}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Plant</td>
                <td>
                  <select name="plant" required class="form-control" tooltip="Plant">
                    <option value=''> -- Plant -- </option>
                    @foreach($tb_plant as $tb)
                    <option value="{{$tb->id_plant}}">{{$tb->plant}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Umur Simpan</td>
                <td>  <input type="number" name="umur_simpan" class="form-control" tooltip="Umur Simpan" required></td>
              </tr>
              <tr>
                <td>Tanggal Kadaluarsa</td>
                <td> <input type="date" id="dpBootstrap" name="tgl_kadaluarsa_rnd" class="form-control" tooltip="Tanggal Kadaluarsa" required></td>
              </tr>
              <tr>
                <td>Tanggal dibuat</td>
                <td><input type="date" id="dpBootstrap" name="tgl_dibuat" class="form-control" tooltip="Tanggal Dibuat" required></td>
              </tr>
              <tr>
                <td>No. Lot</td>
                <td><input type="text" name="nolot" class="form-control" tooltip="No Lot" required></td>
              </tr>
              <tr>
                <td>Tempat Penyimpanan</td>
                <td> <input type="text" name="tempat_penyimpanan" class="form-control" tooltip="Tempat Penyimpanan" required></td>
              </tr>
              <tr>
                <td>Kode Revisi Formula</td>
                <td><input type="text" name="kode_revisi_formula" class="form-control" tooltip="Kode Revisi Formula" required></td>
              </tr>
              <tr>
                <td>Pembuat</td>
                <td><input type="text" name="pembuat" class="form-control" tooltip="Pembuat" required> </td>
              </tr>
              <tr>
                <td> <button class="btn btn-primary">Tambah</button></form></td>
                <td></td>
              </tr>
			      </table>
			  	</div>    				
        </div>
      </div>		
		</div>
	</div>
</div>
@endsection