<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_standar extends Model
{
    //
    protected $table = "standar";
    protected $primaryKey = 'id_standar';
    public $incrementing = false;
    protected $fillable = [
        'id_standar','users_id','kategori_sub_id','plant_id','jenis_item_id','satuan_id'];

    public function order() {
        return $this->hasMany("App\Order", "standar_id", "id_standar");
    }

    public function plant1() {
        return $this->hasOne("App\plant", "id_plant", "plant_id");
    }

    public function satuanstok() {
        return $this->hasOne("App\satuan", "id_satuan", "satuan_id");
    }

    
}
