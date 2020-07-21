
<?php 

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML('...');
?>

      <table class="table table-bordered text-center " >
                <tr>
                  <th>Nama Standar</th>
                  <th>Jenis Item</th>
                  <th>Kode Formula</th>
                  <th>Kode Oracle</th>
                  <th>Stok RD</th>
                  <th>Tanggal Datang</th>
                  <th>Tanggal Dibuat</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Kadaluarsa</th>
                  <th>Umur Simpan</th>
                  <th>Satuan</th>
                  <th>No. Lot</th>
                  <th>Serving Size</th>
                  <th>Tempat Penyimpanan</th>
                  <th>Kode Revisi Formula</th>
                  <th>Pembuat</th>
                  <th>Freeze</th>
                  
                </tr>
              @foreach($standar as $s)
              <tr>
                  <td>{{$s->nama_item}}</td>
                  <td>{{$s->jenis_item}}</td>
                  <td>{{$s->kode_formula}}</td>
                  <td>{{$s->kode_oracle}}</td>
                  <td>{{$s->stok_rnd}}</td>
                  <td>{{$s->tgl_datang}}</td>
                  <td>{{$s->tgl_dibuat}}</td>
                  <td>{{$s->tgl_masuk}}</td>
                  <td>{{$s->tgl_kadaluarsa_rnd}}</td>
                  <td>{{$s->umur_simpan}}</td>   
                  <td>{{$s->satuan}}</td>  
                  <td>{{$s->nolot}}</td>
                  <td>{{$s->serving_size}}</td>
                  <td>{{$s->tempat_penyimpanan}}</td>
                  <td>{{$s->kode_revisi_formula}}</td>
                  <td>{{$s->pembuat}}</td>
                  <td>{{$s->freeze}}</td>
              </tr>
              @endforeach
        </table>