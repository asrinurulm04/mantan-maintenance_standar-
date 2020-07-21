@extends('layouts.layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   
      <div class="card">
        <div class="card-body">
              <table id="example2" class="table table-bordered table-hover table-responsive">
                <thead class="bg-dark">
                <tr class="flex">
                  <th>Nama Standar</th>
                  <th>No. Lot</th>
                  <th>Kode Oracle</th>
                  <th>Tgl.Datang</th>
                  <th>Tgl.Buat</th>
                  <th>Tgl.Expired</th>
                  <th>Work Center</th>
                  <th>Plant</th>
                  <th>Umur Simpan</th>
                  <th>Stok</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($standar as $s)
                <tr>
                  <td>{{$s->nama_item }} </td>
                  <td>{{$s->nolot }} </td>
                  <td>{{$s->kode_formula }} </td>
                  <td>{{$s->tgl_datang }} </td>
                  <td>{{$s->tgl_dibuat }} </td>
                  <td>{{$s->tgl_kadaluarsa_rnd }} </td>
                  <td>{{$s->jenis_item }} </td>
                  <td>{{$s->plant }} </td>
                  <td>{{$s->umur_simpan }} </td>
                  <td>{{$s->stok_rnd }} </td>
                  <td>
                  <div class='btn-group'>
                                    <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
                                    Opsi <span class='caret'></span></button>
                                    <ul class='dropdown-menu' role='menu'>
                                      <li><a href='#' name='edit' class="ml-4"><i class="fa fa-download"></i> Edit</a></li>
                                      <li><a href='/data/standar/unfreeze/{{$s->id_standar}}' class="ml-4"><i class="fa fa-download"></i> Unfreeze</a></li>
                                    </ul>
                                  </div>
                  </td>
                </tr>
                @endforeach
                </tfoot>
              </table>

              </div>
      </div>

            @endsection