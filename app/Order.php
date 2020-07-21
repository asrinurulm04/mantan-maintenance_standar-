<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id_order';
    public $incrementing = false;
    protected $fillable = [
        'id_order','pemohon_id','pengirim_id','penerima_id','status', 'alasan','jumlah_kirim','jumlah_pesan','keterangan','tgl_order','tgl_kirim','tgl_diterima'
    ];

    
  
  

}
