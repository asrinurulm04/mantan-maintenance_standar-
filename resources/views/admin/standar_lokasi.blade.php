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
      
              <table id="example2" class="table table-bordered table-hover text-center" >
                <thead class="bg-dark">
                <tr>
                  <th>Nama Standar</th>
                  <th>Alasan</th>
                  <th>No. Lot</th>
                  <th>Lokasi</th>
                  <th>Sub Kategori</th>
                  <th>Jenis Item</th>
                  <th>Plant</th>
                </tr>
                </thead>
                <tbody>
                @foreach($standar as $s )
                <tr>
                  <td>{{$s->nama_item}}</td>
                  <td><span class="right badge badge-info">{{$s->status_rnd}} </span></td>
                  <td>{{$s->nolot}}</td>
                  <td>{{$s->lokasi}}</td>
                  <td>{{$s->nama_kategori}}</td>
                  <td>{{$s->jenis_item}}</td>
                  <td>{{$s->plant}}</td>
                </tr>
                @endforeach
                <!-- <tr>
                  <td>Acesulfame 33-00</td>
                  <td> <span class="right badge badge-danger">Kadaluwarsa</span></td>
                  <td>Acesulfame 33-00/B/20170109/FD002AK16022</td>
                  <td>C-13-33</td>
                  <td>Sweeteners</td>
                  <td>Baku Dairy Cibitung</td>
                  <td>E</td>
                  <td><button class="btn btn-primary">Ubah</button></td>
                </tr>
                <tr>
                        <td>Black Tea 33-00</td>
                        <td> <span class="right badge badge-danger">Habis</span></td>
                        <td>Acesulfame 33-00/B/20170109/FD002AK16022</td>
                        <td>C-13-30</td>
                        <td>Sweeteners</td>
                        <td>Baku Dairy Cibitung</td>
                        <td>E</td>
                        <td><button class="btn btn-primary">Ubah</button></td>
                </tr>
                <tr>
                        <td>Butter 33-00</td>
                        <td> <span class="right badge badge-primary">Aktif</span></td>
                        <td>Acesulfame 33-00/B/20170109/FD002AK16022</td>
                        <td>C-13-42</td>
                        <td>Sweeteners</td>
                        <td>Baku Dairy Cibitung</td>
                        <td>E</td>
                        <td><button class="btn btn-primary">Ubah</button></td>
                </tr>
                <tr>
                        <td>Aspartame 33-00</td>
                        <td> <span class="right badge badge-warning">Hampir Habis</span></td>
                        <td>Acesulfame 33-00/B/20170109/FD002AK16022</td>
                        <td>C-13-56</td>
                        <td>Sweeteners</td>
                        <td>Baku Dairy Cibitung</td>
                        <td>E</td>
                        <td><button class="btn btn-primary">Ubah</button></td>
                </tr> -->
                </tfoot>
              </table>
    </section>
    </div>
    @endsection