@extends('layouts.layout')
@section('content')
<?php 

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML('...');
libxml_clear_errors();
?>

<style>
	.pesan{
    background: #a5adba;
	}
	.bg-abu{
  background : #F5F5F5;
	}
	.judul{
    background: #6892d6;
  }
  button{
      cursor : pointer;
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
	<div class="container-fluid">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6 offset-3 text-center ">
					<div class="card">
						<div class="card-header judul text-white flat">
							<h5>Cetak Label Standar</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
  </section>
  <div class="card">
    <div class="card-body">
			<form class="form-horizontal form-label-left" method="POST" action="{{route('cetak_id')}}" novalidate>
			<a href="{{route('spreadsheet/download')}}" class="btn btn-success btn-sm"><li class="fa fa-table"></li> Cetak semua standar</a>&nbsp&nbsp
			<button class="btn btn-success btn-sm" type="submit"><li class="fa fa-check"></li> Cetak Label Standar Yang ditandai</button><br><br>
			{{ csrf_field() }}
			<label style="color:red"> KET : Standar yang ditandai harus dalam 1 halaman, silahkan gunkan filter untuk mengaturnya.</label>		
				<table class="Table table-bordered text-center "  style="overflow-y: scroll;">
					<thead>
						<tr style="background-color:#4a4848;color:#ffff">
							<th>Nama Standar</th>
							<th>No.Lot</th>
							<th>Kode Formula</th>
							<th>Tgl.Datang</th>
							<th>Tgl.Buat</th>
							<th>Tgl.Expired</th>
							<th>Plant</th>
							<th>Stok</th>
							<th></th>
						</tr>
					</thead>
					<tbody><?php $no = 0;?>
						@foreach ($standar as $standar)
						<?php $no++ ;?>
						<tr style="color:black">
							<td>{{$standar->nama_item}}</td>
							<td>{{$standar->nolot}}</td>
							<td>{{$standar->kode_formula}}</td>
							<td>{{$standar->tgl_terima}}</td>
							<td>{{$standar->tgl_dibuat}}</td>
							<td>{{$standar->tgl_kadaluarsa_rnd}}</td>
							<td>{{$standar->plant}}</td>
							<td>{{$standar->stok_rnd}} {{$standar->satuan}} </td>
							<td><input type="checkbox" name="id[]" id="id" value="{{$standar->id_standar}}"></td>
							<input type="hidden" value="{{$standar->id_standar}}" name="std[]" id="std">
						</tr>
						@endforeach
					</tbody>
				</table>
			</form>
		</div>
	</div>
	</section>
</div>
@endsection