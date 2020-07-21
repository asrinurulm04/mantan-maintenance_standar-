@extends('layouts.layout')
@section('content')

<body class="hold-transition sidebar-mini">
<div class="card">
	<section class="content">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6 offset-4"><br>
          <div class="card">
            <div class="card-body">
							<div class="card-header flat bg-secondary text-center">
								@foreach($standar as $s)
									@if($s->jenis_item_id == 1)
									<h5 class="">Detail WIP</h5>
									@else
									<h5 class="">Detail Bahan Baku</h5>
									@endif
								@endforeach
							</div>
							<table class="table table-bordered text-center">
          			@foreach($standar as $s)
								<form class='form' method='post' action="/rnd/data/standar/update"><br>
								@if($s->freeze =='Y')
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Standar sedang dalam keadaan freeze</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								@else
								@endif
								{{ csrf_field() }}
								<input type="hidden" name="id_standar" value="{{ $s->id_standar }}"> <br/>
								<tr>
									<td>Nama Produk</td>
									<td><input readonly name='nama_item' type='text' class='form-control' value='{{$s->nama_item}} '></td>
								</tr>
								<tr>
									<td>Kode Formula</td>
									<td>
										<input readonly name='kode_formula' type='text' class='form-control' value='{{$s->kode_formula}}'>
									</td>
								</tr>
								<tr>
									<td>Kode Oracle</td>
									<td>
										<input readonly name='kode_oracle' type='text' class='form-control' value='{{$s->kode_oracle}}'>
									</td>
								</tr>
								<tr>
									<td>Revisi Formula <br> Std RND</td>
									<td><input readonly name='kode_revisi_formula' class='form-control' value='{{$s->kode_revisi_formula}}' ></td>
								</tr>
								@if($s->jenis_item_id =='2')
								<tr>
									<td>No. Lot</td>
									<td><input readonly name='nolot' class='form-control' value='{{$s->nolot}}' ></td>
								</tr>
								<tr>
									<td>Sub. Kategori</td>
									<td>
											<select class="form-control select2" readonly name="sub_kategori">
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
										<select class="form-control select2" readonly name="jenis_item">
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
									<td><input readonly name='lokasi' class='form-control' value='{{$s->lokasi}}' ></td>
								</tr>
								<tr>
									<td>Umur Simpan</td>
									<td><input readonly name='umur_simpan' type="number" class='form-control' value='{{$s->umur_simpan}}'></td>
								</tr>
								<tr>
									<td>Plant</td>
									<td>  
										<div class="form-group">
										<label>
										@foreach($standar as $s)
											@foreach($tb_plant as $tb)
											@if($tb->id_plant == $s->plant_id)
											<input type="radio" class="minimal" name="plant" value="{{$tb->id_plant}}" disabled checked>{{$tb->plant}}	
											@else
											<input type="radio" class="minimal" name="plant" disabled value="{{$tb->id_plant}}">{{$tb->plant}}	
											@endif
											@endforeach
										@endforeach
										</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tanggal Dibuat Std</td>
									<td><input readonly name='tgl_dibuat' type='date' class='form-control' value='{{$s->tgl_dibuat}}'></td>
								</tr>
								<tr>
									<td>Tanggal Expire Std</td>
									<td><input readonly name='tgl_kadaluarsa_rnd' type='date' id='dpBootstrap' class='form-control' required value='{{$s->tgl_kadaluarsa_rnd}}'></td>
								</tr>
								<tr>
									<td>Tempat Penyimpanan</td>
									<td><input readonly name='tempat_penyimpanan' type='text' id='dpBootstrap' class='form-control' value='{{$s->tempat_penyimpanan}}'></td>
								</tr>
								<tr>
									<td>Serving Size <br> ( Gram )</td>
									<td><input readonly name='serving_size' class='form-control' value='{{$s->serving_size}}'></td>
								</tr>
								<tr>
								<tr>
									<td>Stok</td>
									<td>
										<div class="row">
											<div class="col-sm-5">   
												<div class="input-group input-group-xs">
												<input readonly name='stok_rnd' class='form-control' value='{{$s->stok_rnd}}'>
													<div class="input-group-append">
														<button class="btn btn-secondary" disabled id="mata"> Gram</button>
													</div>
												</div>
											</div>
											<p class="text-bold mt-2">--></p>
											<div class="col-sm-5">
												<div class="input-group input-group-xs">
												<input readonly name='stok_rnd' class='form-control' value='<?php echo floor($s->stok_rnd / $s->serving_size)?>'>
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
									<td><input readonly name='satuan' class='form-control' value='{{$s->satuan}}'></td>
								</tr>
								<tr>
									<td>Pembuat</td>
									<td><input readonly name='pembuat' class='form-control' value='{{$s->pembuat}}'></td>
								</tr>
								<tr>
									<td>
										@foreach($standar as $s)
											@if($s->freeze == 'Y')
											<a href='/rnd/standar/freeze' class='btn btn btn-danger' name='go' role='button'>Kembali</a>
											@else
												@if($s->jenis_item_id == 1)
												<a href='/rnd/data/standar' class='btn btn btn-danger' name='go' role='button'>Kembali</a>
												@else
												<a href='/rnd/standar/baku' class='btn btn btn-danger' name='go' role='button'>Kembali</a>
												@endif
											@endif
										@endforeach
									</td>
									<td></td>
								</tr>
								</form>
								@endforeach
							</table>
						</div>
					</div>    				
				</div>
			</div>		
		</div>
	</section>
</div>
</body>
@endsection