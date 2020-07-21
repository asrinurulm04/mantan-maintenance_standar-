@extends('layouts.layout')
@section('content')

<body class="hold-transition sidebar-mini">
	<div class="card">
		<section class="content">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-4">
          <div class="card">
            <div class="card-body">
							<div class="card-header flat bg-secondary text-center">
								@foreach($standar as $s)
									@if($s->jenis_item_id == 1)
									<h5 class="">Edit Standar Freeze ( WIP )</h5>
									@else
									<h5 class="">Edit Standar Freeze ( Bahan Baku )</h5>
									@endif
								@endforeach
							</div>
							<table class="table table-bordered text-center">
								@foreach($standar as $s)<br>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Standar sedang dalam keadaan freeze</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form class='form' method='post' action="/rnd/standar/freeze/update">
								{{ csrf_field() }}
								<input type="hidden" name="id_standar" value="{{ $s->id_standar }}">
								<input type="hidden" name="jenis_item_id" value="{{ $s->jenis_item_id }}">  <br/>
								<tr>
									<td>Nama Produk</td>
									<td><input name='nama_item' type='text' class='form-control' value='{{$s->nama_item}} '></td>
								</tr>
								<tr>
									<td>Kode Formula</td>
									<td>
										<input name='kode_formula' type='text' class='form-control' value='{{$s->kode_formula}}'>
									</td>
								</tr>
								<tr>
									<td>Kode Oracle</td>
									<td>
										<input name='kode_oracle' type='text' class='form-control' value='{{$s->kode_oracle}}'>
									</td>
								</tr>
								<tr>
									<td>Revisi Formula <br> Std RND</td>
									<td><input name='kode_revisi_formula' class='form-control' value='{{$s->kode_revisi_formula}}' ></td>
								</tr>
								@if($s->jenis_item_id=='2')
								<tr>
									<td>No. Lot</td>
									<td><input name='nolot' class='form-control' value='{{$s->nolot}}' ></td>
								</tr>
								<tr>
									<td>Sub. Kategori</td>
									<td>
										<select class="form-control select2" name="sub_kategori">
											@foreach($standar as $s)
												@foreach($tb_sub_kategori as $tb)
													@if($tb->id_sub_kategori == $s->kategori_sub_id)
													<option value="{{$tb->id_sub_kategori}} " selected="selected">{{$tb->nama_kategori}}</option>
													@else
													<option value="{{$tb->id_sub_kategori}} ">{{$tb->nama_kategori}}</option>
													@endif
												@endforeach
											@endforeach
										</select>
									</td>
								</tr>
								@else
								@endif
								<tr>
									<td>Jenis Item</td>
									<td>
										<select class="form-control select2" name="jenis_item">
											@foreach($standar as $s)
												@foreach($tb_jenis_item as $tb)
												@if($tb->id_jenis_item == $s->jenis_item_id)
												<option value="{{$tb->id_jenis_item}}" selected="selected">{{$tb->jenis_item}}</option>
												@else
												<option value="{{$tb->id_jenis_item}}">{{$tb->jenis_item}}</option>
												@endif
												@endforeach
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>Lokasi</td>
									<td><input name='lokasi' class='form-control' value='{{$s->lokasi}}' ></td>
								</tr>
								<tr>
									<td>Umur Simpan</td>
									<td><input name='umur_simpan' type="number" class='form-control' value='{{$s->umur_simpan}}'></td>
								</tr>
								<tr>
									<td>Plant</td>
									<td>  
										<div class="form-group">
											<label>
											@foreach($standar as $s)
												@foreach($tb_plant as $tb)
													@if($tb->id_plant == $s->plant_id)
													<input type="radio" class="minimal" name="plant" value="{{$tb->id_plant}}" checked>{{$tb->plant}}	
													@else
													<input type="radio" class="minimal" name="plant" value="{{$tb->id_plant}}">{{$tb->plant}}	
													@endif
												@endforeach
											@endforeach
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tanggal Dibuat Std</td>
									<td><input name='tgl_dibuat' type='date' class='form-control' value='{{$s->tgl_dibuat}}'></td>
								</tr>
								<tr>
									<td>Tanggal Expire Std</td>
									<td><input name='tgl_kadaluarsa_rnd' type='date' id='dpBootstrap' class='form-control' required value='{{$s->tgl_kadaluarsa_rnd}}'></td>
								</tr>
								<tr>
									<td>Tempat Penyimpanan</td>
									<td><input name='tempat_penyimpanan' type='text' id='dpBootstrap' class='form-control' value='{{$s->tempat_penyimpanan}}'></td>
								</tr>
								<tr>
									<td>Serving Size</td>
									<td><input name='serving_size' min="0" step="0.0001" class='form-control' value='{{$s->serving_size}}'></td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<div class="row">
											<div class="col-sm-5">   
												<div class="input-group input-group-xs">
												<input  name='stok_rnd' class='form-control' value='{{$s->stok_rnd}}'>
													<div class="input-group-append">
														<button class="btn btn-secondary" disabled id="mata"> Gram</button>
													</div>
												</div>
											</div>
											<p class="text-bold mt-2">--></p>
											<div class="col-sm-5">
												<div class="input-group input-group-xs">
												<input readonly class='form-control' value='<?php echo floor($s->stok_rnd / $s->serving_size)?>'>
													<div class="input-group-append">
														<button class="btn btn-secondary" disabled id="mata"> {{$s->satuan}} </button>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<select class="form-control" name="satuan" required>
											@foreach($standar as $s)
												@foreach($tb_satuan as $tb)
													@if($tb->id_satuan == $s->satuan_id)
													<option value="{{$tb->id_satuan}}" selected="selected">{{$tb->satuan}}</option>
													@else
														@if($tb->status == 'non-aktif')
														<option value="{{$tb->id_satuan}}" disabled>{{$tb->satuan}}</option>
														@else
														<option value="{{$tb->id_satuan}}">{{$tb->satuan}}</option>
														@endif
													@endif
												@endforeach
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>Pembuat</td>
									<td><input name='pembuat' class='form-control' value='{{$s->pembuat}}'></td>
								</tr>
								<tr>
									<td>
										<a href='/rnd/standar/freeze' class='btn btn btn-danger' name='go' role='button'>Kembali</a>
									</td>
									<td><button class='btn btn btn-success' name='go' value='submit'>Ubah</button></td>
								</tr>
								</form>
								@endforeach
							</table>
						</div>
					</div>
				</div>    				
			</div>
		</div>		
	</div>
</div>

@endsection