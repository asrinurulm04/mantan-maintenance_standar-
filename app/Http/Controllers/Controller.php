<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // $users = DB::table('users')
    // ->join('tb_pemohon','users.pemohon_id','=','tb_pemohon.id_pemohon')
    // ->join('tb_pengirim','users.pengirim_id','=','tb_pengirim.id_pengirim')
    // ->join('tb_penerima','users.penerima_id','=','tb_penerima.id_penerima')->where('id',$id)->get();

    
}
