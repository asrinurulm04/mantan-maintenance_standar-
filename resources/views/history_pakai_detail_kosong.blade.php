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
            <div class="card-header judul text-white text-bold">
              <h5>Detail History</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="col-sm-12">
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover text-center">
          <tr>
            <th>Nama Item</th>
            <th>Aktifitas</th>
            <th>Aktor</th>
            <th>Alasan</th>
            <th>Tgl</th>
            <th>Keterangan</th>
            <th>Serving Size</th>
          </tr>
          <tr>
            <td colspan="7">Tidak Ditemukan Data</td>
          </tr>
        </table><br>
      </div>
    </div>
  </div>
</div>

@endsection