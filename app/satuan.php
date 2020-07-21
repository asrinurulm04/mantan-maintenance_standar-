<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    protected $table = "tb_satuan";
    protected $primaryKey = 'id_satuan';
    protected $fillable = [
        'id_satuan','satuan','status'];
}
