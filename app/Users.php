<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    
    //relasi one to many (Saya memiliki banyak anggota di model .....)
    public function get_order(){
        return $this->hasMany('App\\Model\\Order');
    }
}
