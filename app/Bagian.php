<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $table = "tb_bagian";
    
    public function user() {
        return $this->hasMany("App\User", "bagian_id");
    }

    
}
