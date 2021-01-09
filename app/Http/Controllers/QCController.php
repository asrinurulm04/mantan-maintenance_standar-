<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Standar;
use App\CartQC;
use App\Keranjang_QC;
use App\Order_QC;
use App\History;
use DataTables;
use App\Users;
use Carbon;
use Mail;

class QCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    // Stok Standar
    public function stok()
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         
        $standar = DB::table('standar')
            ->leftjoin('users','standar.peminta_id','=','users.id')->where('status_qc','!=','belum_dikirim')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('jenis_item','WIP')
            ->where('plant_id','!=','3')->where('plant_id','!=','4')
            ->orderBy('nama_item','ASC')->get();
        $standar1 = DB::table('standar')
            ->leftjoin('users','standar.peminta_id','=','users.id')->where('status_qc','!=','belum_dikirim')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('jenis_item','WIP')
            ->where('plant_id','!=','1')->where('plant_id','!=','2')
            ->orderBy('nama_item','ASC')->get();
        return view('/qc/stok_standar',compact('standar','standar1','order_qc','hitungOrderSendiri','bagi','order_diterima_qc','pesan1','pesan2','pesan3','pesan4','order_diterima_rnd','order_rnd','orders','ok'));
    }

    public function pakai_stok($id)
    {
        if(Auth::user()->work_center != 'QC'){
           return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->where('id_standar',$id)->get();
        return view('/qc/pakai_stok',compact('standar','order_qc','hitungOrderSendiri','pesan1','pesan2','pesan3','pesan4','order_diterima_qc','order_diterima_rnd','order_rnd','orders','ok'));
    }

    public function pakai_stok_proses(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
           return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->get();
        
        foreach($standar as $s){
            if($request->jumlah_pakai_gram != "")
            {
                $cek = $request->jumlah_pakai_gram;
                if($s->stok_qc < $cek)
                {
                    return redirect()->back()->with('cekStok','Maaf pemakaian gagal, stok tidak mencukupi');
                }
                else{
                    $cek = $request->jumlah_pakai_gram;
                    $stok_qc = $s->stok_qc - $cek ;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc
                    ]);
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' => 'QC memakai std',
                        'jumlah' => $cek,
                        'alasan' => "kebutuhan",
                        'tgl'=> Carbon\Carbon::now(),
                        "keterangan" => "QC memakai std",
                    ]);

                    DB::table('tb_notification')->insert([
                        'id_user' => Auth::user()->id,
                        'id_standar' => $request->id_standar,
                        'subject' => 'QC memakai std',
                        "tgl" =>  Carbon\Carbon::now(),
                    ]);
                    
                    if($request->jenis_item == 'WIP')
                    {
                        $info = "Stok". " ". $request->nama_item. " ". "berhasil digunakan";
                        return redirect('/qc/stok/standar')->with('cekStok',$info);
                    }
                    else{
                        $info = "Stok". " ". $request->nama_item. " ". "berhasil digunakan";
                        return redirect('/qc/stok/baku')->with('cekStok',$info);
                    }
                }
            }
                
            if($request->jumlah_pakai_gram == "")
            {
                $cek = $request->jumlah_pakai_serving * $request->serving_size;
                if($s->stok_qc < $cek)
                    {
                        return redirect()->back()->with('cekStok','Maaf pemakaian gagal, stok tidak mencukupi');
                    }
                else{
                    $cek = $request->jumlah_pakai_serving * $request->serving_size;
                    $stok_qc = $s->stok_qc - $cek ;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                       'stok_qc' => $stok_qc
                    ]);
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' => 'QC memakai std',
                        'jumlah' => $cek,
                        'alasan' => "kebutuhan",
                        'tgl'=> Carbon\Carbon::now(),
                        "keterangan" => "QC memakai std",
                    ]);
                    DB::table('tb_notification')->insert([
                        'id_user' => Auth::user()->id,
                        'id_standar' => $request->id_standar,
                        'subject' => 'QC memakai std',
                        "tgl" =>  Carbon\Carbon::now(),
                    ]);
                    if($request->jenis_item == 'WIP')
                    {
                        $info = "Stok". " ". $request->nama_item. " ". "berhasil digunakan";
                        return redirect('/qc/stok/standar')->with('cekStok',$info);
                    }
                    else{
                        $info = "Stok". " ". $request->nama_item. " ". "berhasil digunakan";
                        return redirect('/qc/stok/baku')->with('cekStok',$info);
                    }
                }         
            }    
        }      
    }

    public function cari_baku_nama(Request $request)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
       
        $standar = DB::table('standar')
        ->join('tb_sub_kategori', function ($join) {
            $join->on('standar.kategori_sub_id', '=', 'tb_sub_kategori.id_sub_kategori')
            ->where('jenis_item_id','2') ->where('status_qc','!=', 'belum_dikirim');
        })
        ->join('tb_satuan', function ($join) {
            $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
        })
        ->join('tb_plant', function ($join) {
            $join->on('standar.plant_id', '=', 'tb_plant.id_plant');
        })
       ->when($request->nama,function ($query) use ($request) {
           $query
           ->where('nama_item', 'like', "%{$request->nama}%")
           ->orWhere('kode_oracle', 'like', "%{$request->nama}%");
       })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
       $standar->appends($request->only('nama'));

        return view('/qc/stok_baku', compact('standar','pesan1','pesan2','pesan3','pesan4','order_qc','hitungOrderSendiri','order_diterima_qc','order_diterima_rnd','order_rnd'));
    }

    public function cari_nama(Request $request)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
         
        $cekOrder = DB::table('order')->get();
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->leftjoin('users', function ($join) {
                $join->on('standar.users_id', '=', 'users.id');
            })
            ->join('tb_satuan', function ($join) {
                $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
            })
            ->join('tb_jenis_item', function ($join) {
                $join->on('standar.jenis_item_id', '=', 'tb_jenis_item.id_jenis_item')->where('status_qc','!=','belum_dikirim')
                ->where('jenis_item','WIP');
            })
            ->when($request->nama,function ($query) use ($request) {
                $query
                ->where('nama_item', 'like', "%{$request->nama}%")
                ->orWhere('kode_oracle', 'like', "%{$request->nama}%");
            })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('nama'));
    
        return view('/qc/stok_standar', compact('standar','pesan1','pesan2','pesan3','pesan4','order_diterima_rnd','order_rnd','order_qc','hitungOrderSendiri','order_diterima_qc','cekOrder'));
    }

    public function stok_baku_tambah($id)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $standar = DB::table('standar')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('id_standar',$id)
            ->get();
        return view('/qc/stok_baku_tambah',compact('standar','order_rnd','order_diterima_rnd','order_qc','hitungOrderSendiri','pesan1','pesan2','pesan3','pesan4','order_diterima_qc'));
    }
    
    public function stok_update(Request $request)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }

        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->get();
        $stok = [];
        foreach($standar as $sta)
        {
            if($request->jumlah_penambahan_gram !='')
            {
                if($request->alasan == 'kadaluarsa' || $request->alasan == 'hampirExpired')
                {
                    $stok_qc = $sta->stok_qc;
                    $jumlah = $request->jumlah_penambahan_gram - $stok_qc;
                    $buangStok =  $sta->stok_qc -  $sta->stok_qc;
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'membuang stok bahan baku',
                        'jumlah' => $stok_qc,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'membuang stok bahan baku sebanyak'. " ". $stok_qc
                    ]);
                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $buangStok ,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                        
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'menambah stok bahan baku',
                        'jumlah' => $request->jumlah_penambahan_gram,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'menambah stok bahan baku dari 0'. " ". "menjadi". " ". $request->jumlah_penambahan_gram,
                    ]);
                    DB::table('tb_notification')->insert([
                        'id_user' => Auth::user()->id,
                        'id_standar' => $request->id_standar,
                        'subject' => 'menambah stok bahan baku',
                        "tgl" =>  Carbon\Carbon::now(),
                    ]);

                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $request->jumlah_penambahan_gram ,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                    $info = "Data". " ". $request->nama_item. " ". "berhasil ditambah";
                    return redirect('/qc/stok/baku')->with('cekStok',$info);
                    
                }        
                else{
                    $stok_qc = $sta->stok_qc;
                    $jumlah = $request->jumlah_penambahan_gram - $stok_qc;
                    $jumlahAkhir = $sta->stok_qc + $request->jumlah_penambahan_gram;
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'menambah stok bahan baku',
                        'jumlah' => $request->jumlah_penambahan_gram,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'menambah stok bahan baku dari'. " ".  $stok_qc. " ". "menjadi". " ". $jumlahAkhir,
                    ]);
                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $jumlahAkhir,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                    DB::table('tb_notification')->insert([
                        'id_user' => Auth::user()->id,
                        'id_standar' => $request->id_standar,
                        'subject' => 'menambah stok bahan baku',
                    ]);
                    $info = "Data". " ". $request->nama_item. " ". "berhasil ditambah";
                    return redirect('/qc/stok/baku')->with('cekStok',$info);
                        
                }
            }

            if($request->jumlah_penambahan_gram =='')
            {
                $hitung = $request->jumlah_penambahan_serving * $request->serving_size;
                if($request->alasan == 'kadaluarsa' || $request->alasan == 'hampirExpired')
                {
                    $stok_qc = $sta->stok_qc;
                    $buangStok = $sta->stok_qc - $sta->stok_qc;
                    $jumlah = $hitung - $stok_qc;
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'membuang stok bahan baku',
                        'jumlah' => $stok_qc,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'membuang stok bahan baku sebanyak'. " ". $stok_qc
                    ]);
                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $buangStok ,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'menambah stok bahan baku',
                        'jumlah' => $hitung,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'menambah stok bahan baku dari 0'. " "." ". "menjadi". " ". $hitung
                    ]);
                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $hitung,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                    $info = "Data". " ". $request->nama_item. " ". "berhasil ditambah";
                    return redirect('/qc/stok/baku')->with('alert',$info);
                }
                else{
                    DB::table('history')->insert([
                        'users_id' => Auth::user()->id,
                        'standar_id' => $request->id_standar,
                        'jenis_perubahan' => 'update',
                        'aktifitas' =>  Auth::user()->work_center .' '. 'menambah stok bahan baku',
                        'jumlah' => $hitung,
                        'alasan' => $request->alasan,
                        'tgl'=> Carbon\Carbon::now(),
                        'keterangan' => Auth::user()->work_center .' '. 'menambah stok bahan baku dari'. " " . "0". " ". "menjadi". " ". $hitung
                    ]);
                    DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $hitung,
                        'tgl_kadaluarsa_qc' => $request->tgl_kadaluarsa_qc_terbaru,
                    ]);
                    $info = "Data". " ". $request->nama_item. " ". "berhasil ditambah";
                    return redirect('/qc/stok/baku')->with('alert',$info);
                }
            }
        }
    }

    public function stok_terpakai(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }
        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->get();
        foreach($standar as $s){
            if($s->stok_qc < $request->terpakai)
            {
                $stok_qc = $s->stok_qc;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc
                ]);    
                return redirect()->back()->with('cekStok',"Maaf stok tidak mencukupi");
                       
            } else{
                $stok_qc = $s->stok_qc - $request->terpakai;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc
                ]);
            }    
                  
            $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                'lokasi' => $request['lokasi']
            ]);

            DB::table('history')->insert([
                'users_id' => Auth::user()->id,
                'standar_id' => $request->id_standar,
                'jenis_perubahan' => 'update',
                'aktifitas' => 'QC memakai std',
                'jumlah' => $request->terpakai,
                'alasan' => "kebutuhan",
                'tgl'=> Carbon\Carbon::now(),
                "keterangan" => "QC memakai std",
            ]);

        }
        return redirect()->back()->with('cekStok',"Berhasil memakai stok");;
    }

    public function stok_baku()
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
       
        $orders = DB::table('order')
            ->join('standar','order.standar_id','=','standar.id_standar')
            ->join('users','order.pemohon_id','=','users.id')
            ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('standar_id','id_standar')->where('stat','keranjang');

        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('status_qc','!=', 'belum_dikirim')->where('jenis_item_id','2')
            ->orderBy('nama_item','ASC')->get();
        return view('/qc/stok_baku',compact('standar','order_diterima_rnd','order_rnd','pesan1','pesan2','pesan3','pesan4','order_qc','hitungOrderSendiri','order_diterima_qc','order3','order4','or','orders'));
    }

    public function cari(Request $request)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $standar = DB::table('standar')
        ->leftjoin('users', function ($join) {
            $join->on('standar.users_id', '=', 'users.id');
        })
        ->join('tb_satuan', function ($join) {
            $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
        })
        ->join('tb_jenis_item', function ($join) {
            $join->on('standar.jenis_item_id', '=', 'tb_jenis_item.id_jenis_item')->where('status_qc','!=','belum_dikirim')
            ->where('jenis_item','WIP');
        })
        ->when($request->keyword,function ($query) use ($request) {
            $query->where('jenis_item', 'like', "%{$request->keyword3}%")
            ->where('status_qc', 'like', "%{$request->keyword}%");
        })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('keyword3','keyword'));
   
        return view('/qc/stok_standar',compact('standar','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_rnd','order_qc','hitungOrderSendiri','order_diterima_qc'));
    }

    public function cari_baku(Request $request)
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = Standar::join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('status_qc','!=', 'belum_dikirim')->where('jenis_item_id', '2')->when($request->keyword,function ($query) use ($request) {
          
        $query->where('jenis_item', 'like', "%{$request->keyword3}%")
            ->where('status_qc', 'like', "%{$request->keyword}%");
        })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('keyword3','keyword'));
   
        return view('/qc/stok_baku',compact('standar','order_rnd','order_diterima_rnd','order_qc','pesan1','pesan2','pesan3','pesan4','hitungOrderSendiri','order_diterima_qc'));
    }

    public function order()
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }

        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')
            ->join('standar','order.standar_id','=','standar.id_standar')
            ->where('stat','pesan')->orWhere('stat','keranjang')->get();
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest');
        $user = DB::table('users')
         ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->get();
        $orders = DB::table('order')
            ->join('standar', function ($join) {
                $join->on('order.standar_id', '=', 'standar.id_standar')
                ->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
            })
            ->join('tb_satuan', function ($join) {
                $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
            })
            ->join('tb_bagian', function ($join) {
                $join->on('order.bagian_pemohon', '=', 'tb_bagian.id_bagian');
            })
            ->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/qc/order',compact('orders','user','standar','order_rnd','order_diterima_rnd','order_qc','pesan1','pesan2','pesan3','pesan4','hitungOrderSendiri','order_diterima_qc','orders'));
    }

    public function pesan_stok($id)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }
        
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->join('standar','order.standar_id','=','standar.id_standar')->where('stat','pesan')->orWhere('stat','keranjang')->get();
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest');
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('id_standar',$id)->get();
        return view('/qc/awal_pesan',compact('standar','order_qc','hitungOrderSendiri','order_diterima_qc','tb_plant','pesan1','pesan2','pesan3','pesan4','tb_sub_kategori','tb_jenis_item'));
    }

    public function masuk_keranjang(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }

        if($request->jumlah_pesan_gram != "")
        {
            $order_qc = DB::table('order')->insert([
                'standar_id'=> $request->id_standar,
                'catatan' => $request->catatan,
                'pemohon'=> Auth::user()->nama,
                'pengirim'=> null,
                'penerima'=> null,
                'stat' => 'keranjang',
                'alasan' => $request->alasan,
                'jumlah_kirim' => null,
                'jumlah_pesan' => $request->jumlah_pesan_gram,
                "tgl_order" => null,
                "tgl_kirim" => null,
                "tgl_diterima" => null,
                "email_pemohon" => auth::user()->email,
                "bagian_pemohon" => auth::user()->bagian_id,
                
            ]);
            DB::table('standar')->where('id_standar',$request->id_standar)->update([ 
                "kondisi" => 'keranjang',
                "serving_size" => $request->serving_size,
                "peminta_id" => Auth::user()->id,
             ]);
             DB::table('tb_notification')->insert([
                'id_user' => Auth::user()->id,
                'id_standar' => $request->id_standar,
                'subject' => 'QC Memesan std',
                "tgl" =>  Carbon\Carbon::now(),
            ]);
           
            $info = "Data". " ". $request->nama_item. " ". "telah berhasil dimasukkan ke dalam keranjang";
            return redirect('/qc/stok/standar')->with('keranjang',$info);
        }
         
        if($request->jumlah_pesan_gram == "")
        {
            $jumlahServing = $request->jumlah_pesan_serving * $request->serving_size;
            $order_qc = DB::table('order')->insert([
                'standar_id'=> $request->id_standar,
                'pemohon'=> Auth::user()->nama,
                'pengirim'=> null,
                'penerima'=> null,
                'stat' => 'keranjang',
                'alasan' => $request->alasan,
                'jumlah_kirim' => null,
                'jumlah_pesan' => $jumlahServing,
                "tgl_order" => null,
                "tgl_kirim" => null,
                "tgl_diterima" => null,
                "email_pemohon" => auth::user()->email,
                "bagian_pemohon" => auth::user()->bagian_id,
            ]);
            DB::table('standar')->where('id_standar',$request->id_standar)->update([ 
                "kondisi" => 'keranjang',
                "peminta_id" => Auth::user()->id,
            ]);
            DB::table('tb_notification')->insert([
                'id_user' => Auth::user()->id,
                'id_standar' => $request->id_standar,
                'subject' => 'QC Memesan std',
                "tgl" =>  Carbon\Carbon::now(),
            ]);
            $info = "Data". " ". $request->nama_item. " ". "telah berhasil dimasukkan ke dalam keranjang";
            return redirect('/qc/stok/standar')->with('keranjang',$info);
        }
    }

    public function order_hapus_satu(Request $request)
    {
        DB::table('order')->where('id_order',$request->id_order)->delete();
        DB::table('standar')->where('id_standar',$request->id_standar)->update([
            'kondisi' => null,
            'peminta_id' => null
        ]);
        return redirect()->back()->with('alert','Berhasil membatalkan order');
    }

    public function order_kirim_satu_post(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }
            
        DB::table('order')->where('id_order',$request->id_order)->update([
            "stat" => "pesan",
            "tgl_order" => Carbon\Carbon::now()
        ]);
        DB::table('standar')->where('id_standar',$request->standar_id)->update([
            "kondisi" => "order",
        ]);
        DB::table('history')->insert([
            "standar_id" => $request->standar_id,
            "users_id" => Auth::user()->id,
            "alasan" => $request->alasan,
            "jenis_perubahan" => 'order',
            "jumlah" => $request->jumlah_pesan,
            "keterangan" => "QC meminta std",
            "aktifitas" => "QC meminta std",
            "tgl" => Carbon\Carbon::now(),
        ]);

        $data = DB::table('standar')->where('id_standar',$request->standar_id)->get();
        try{
            Mail::send('email', [
                "jumlah" => $request->jumlah_pesan,
                "standar_id" => $request->standar_id,
                "alasan" => $request->alasan,
                "info" => ('Terdapat request data standar baru'),
                'data'=>$data,],function($message)use($request)
            {
                $message->subject('Request Standar Baru');
                $message->from('app.mantan@nutrifood.co.id', 'MANTAN V2');
                $user = DB::table('users')->where('work_center','=','RND')->get();
                foreach($user as $user){
                    $data = $user->email;
                    $message->to($data);
                }
                $data = Auth::user()->email;
                $message->cc($data);
            });
            return back()->with('status','Berhasil Kirim Email');
        }
        catch (Exception $e){
        return response (['status' => false,'errors' => $e->getMessage()]);
        }
        return redirect()->back()->with('alert','Order berhasil terkirim');
    }

    public function order_kirim_semua(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }
        
        $inserts = [];
        $order_qc = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest')->where('stat','!=','order_unrequest_diterima')->get();
        foreach($order_qc as $o){
        $inserts [] = 
            [  'order_id' => $o->id_order,
                "standar_id" => $request->standar_id,
                "alasan" => $request->alasan,
                "jenis_perubahan" => 'order',
                "jumlah" => $request->jumlah_pesan,
                "keterangan" => "QC meminta std",
                'aktifitas' => "QC meminta std",
                "tgl" => Carbon\Carbon::now(),
            ];
        }
        
        DB::table('history')->insert($inserts);
        $order_qc2 = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest')->where('stat','!=','order_unrequest_diterima')->get();
        foreach($order_qc as $o){
            $updates [] = 
                [ 
                    "status" => "pesan",
                    "tgl_order" => Carbon\Carbon::now()
                ];
        }
        DB::table('order')->insert($updates);
          DB::table('standar')->where('id_standar',$request->standar_id)->update([
            "kondisi" => "order",
        ]);

        return redirect('/qc/order');
    }
       
    public function cari_history_order(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $history = DB::table('history')->join('pesan','history.order_id','=','order.id_order')
            ->join('standar','order.standar_id','=','standar.id_standar')
            ->join('users','order.pemohon_id','=','users.id')->when($request->dari_tanggal, function ($query) use ($request) {
                $dari_tanggal = $request->dari_tanggal;
                $ke_tanggal = $request->ke_tanggal;
                $tanggal = $dari_tanggal . $ke_tanggal;
                $query
            ->where('aktifitas', 'like', "%{$request->aktifitas}%")
            ->where('tgl', 'like', "%".$dari_tanggal."%");
            })->paginate($request->limit ?  $request->limit : 10);
        $history->appends($request->only('aktifitas','dari_tanggal'));
        return view('/qc/history_order',compact('history','standar','order_qc','hitungOrderSendiri','pesan1','pesan2','pesan3','pesan4','order_diterima_qc'));
    }
   
    public function history_order_hapus($id)
    {
        $history = DB::table('history')->where('id_history',$id)->delete();
        return redirect('/qc/history/order');
    }

    public function order_diterima()
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
    
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_bagian','order.bagian_pemohon','=','tb_bagian.id_bagian')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->where('email_pemohon',Auth::user()->email)
            ->where('stat','kirim')->orWhere('stat','kirim_unrequest')->orderBy('id_order','desc')
            ->get();
            // dd($orders);
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/qc/order_diterima',compact('orders','order_rnd','order_diterima_rnd','order_qc','hitungOrderSendiri','pesan1','pesan2','pesan3','pesan4','order_diterima_qc'));
    }

    public function order_diterima2()
    {
        if(Auth::user()->work_center == 'RND'){
            return redirect()->back();
        }
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('pemohon',auth::user()->email)->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         
        $standar = DB::table('standar')
            ->leftjoin('users','standar.peminta_id','=','users.id')->where('status_qc','!=','belum_dikirim')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('jenis_item','WIP')
            ->orderBy('nama_item','ASC')->get();
        return view('/qc/stok_standar',compact('standar','order_qc','hitungOrderSendiri','bagi','order_diterima_qc','pesan1','pesan2','pesan3','pesan4','order_diterima_rnd','order_rnd','orders','ok'));
    }

    public function terima_order(Request $request)
    {
        if(Auth::user()->work_center != 'QC'){
            return redirect()->back();
        }

        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->get();
        if($request->status == 'kirim_unrequest')
        {
            foreach($standar as $s)
            {
                if($request->alasan == 'Pembaruan Standar')
                {
                    // $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                    $stok_qc2 = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc2,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                if($request->alasan == 'aktif')
                {
                    $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                    $stok_qc2 = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc2,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
		 else if($request->alasan == 'hampirExpired')
                {
                    $stok_qc = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                else if($request->alasan == 'kadaluarsa')
                {
                    $stok_qc = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                else if($request->alasan == 'habis')
                {
                    $stok_qc = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                else if($request->alasan == 'Hampir Habis')
                {
                    // $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                    $stok_qc2 = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc2,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                else if($request->alasan == 'standar baru')
                {
                    $stok_qc = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }
                else if($request->alasan == 'standar improvement')
                {
                    $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                        'stok_qc' => $stok_qc,
                        'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                        'kondisi' => null,
                        'peminta_id' => null,
                        'tgl_terima' => Carbon\Carbon::now()
                    ]);
                }

                DB::table('order')->where('id_order',$request->id_order)->update([
                    'stat' => 'order_unrequest_diterima',
                    'penerima' => Auth::user()->nama,
                    'tgl_diterima' => Carbon\Carbon::now()
                ]);
                
                DB::table('history')->insert([
                    "standar_id" => $request->id_standar,
                    "users_id" => Auth::user()->id,
                    "alasan" => $request->alasan,
                    "jenis_perubahan" => 'baru',
                    "jumlah" => $request->jumlah_kirim,
                    "keterangan" =>  "QC menerima std",
                    "aktifitas" => "QC menerima std",
                    "tgl" =>  Carbon\Carbon::now(),
                ]);
                }
            return redirect()->back()->with('alert','Selamat order berhasil diterima');
        }
      
        else if($request->status == 'kirim')
            {
                foreach($standar as $s)
            {

            if($request->alasan == 'Pembaruan Standar')
            {
                $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            if($request->alasan == 'aktif')
            {
                $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
	     else if($request->alasan == 'hampirExpired')
             {
                    $stok_qc = $request->jumlah_kirim;
                    $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                    ]);
            }
            else if($request->alasan == 'kadaluarsa')
            {
                $stok_qc = $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            else if($request->alasan == 'habis')
            {
                $stok_qc = $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            else if($request->alasan == 'Hampir Habis')
            {
                $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            else if($request->alasan == 'standar baru')
            {
                $stok_qc = $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            else if($request->alasan == 'standar improvement')
            {
                $stok_qc = $s->stok_qc + $request->jumlah_kirim;
                $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
                    'stok_qc' => $stok_qc,
                    'tgl_kadaluarsa_qc' => $s->tgl_kadaluarsa_rnd,
                    'kondisi' => null,
                    'peminta_id' => null,
                    'tgl_terima' => Carbon\Carbon::now()
                ]);
            }
            DB::table('order')->where('id_order',$request->id_order)->update([
                'stat' => 'order_diterima',
                'penerima' => Auth::user()->nama,
                'tgl_diterima' => Carbon\Carbon::now()
            ]);
            
        DB::table('history')->insert([
            "standar_id" => $request->id_standar,
            "users_id" => Auth::user()->id,
            "alasan" => $request->alasan,
            "jenis_perubahan" => 'order',
            "jumlah" => $request->jumlah_kirim,
            "keterangan" =>  "QC menerima std",
            "aktifitas" => "QC menerima std",
            "tgl" =>  Carbon\Carbon::now(),
        ]);
        }

        DB::table('tb_notification')->insert([
            'id_user' => Auth::user()->id,
            'id_standar' => $request->id_standar,
            'subject' => 'telah diterima',
            "tgl" =>  Carbon\Carbon::now(),
        ]);
        
        return redirect()->back()->with('alert','Selamat order berhasil diterima');
        }
    
    }

//     public function getAddToCart(Request $request, $id){
//         $standar = CartQC::find($id);
//     }

//     public function order_keranjang($id)
//     {
//         $standar = DB::table('standar')->where('id_standar',$id)->get();
//         // $standar = Standar::get();
//         // $standar = \App\Users::where('id',$id)->first();
//         return view('/qc/order_keranjang',['standar' => $standar]);
//     }

//     public function proses_keranjang(Request $request)
//     {
//     //    if('standar_id' > 0 ){
//     //        return redirect('/qc/stok/standar');
//     //    }else{

//         $now = \Carbon\Carbon::now();
//         DB::table('keranjang_qc')->insert([
           
//             'users_id' => $request->users_id,
//             'standar_id' =>$request->standar_id,
//             'nama_item' => $request->nama_item,
//             'kode_oracle' => $request->kode_oracle,
//             'work_center' => $request->work_center,
//             'alasan' => $request->status,
//             'pemohon' => $request->pemohon,
//             'plant' => $request->plant,
//             'tgl_order' => $now,

//         ]);
//         return redirect('/qc/stok/standar');
//     // }
//     }

//     public function total()
//     {
//         $count = KeranjangQC::count();
        
//         return View::make('/qc/stok_standar')->with('count', $count);
//     }

//     public function stok_terpakai(Request $request)
//     {
//         DB::table('standar')->update([
//             'stok_qc' =>$request->terpakai
//         ]);
//         return redirect('/qc/stok/standar');
//     }
//     // Stok Standar ( AKHIR )
       
// //     public function keranjang_hapus($id)
// //     {
// //         $keranjang_qc = DB::table('keranjang_qc')->where('id_keranjang',$id);
// //        $keranjang_qc->delete();
// //         return redirect('/qc/keranjang')->with('message','Berhasil dihapus');
// //     }

// //     public function kirim_satu_keranjang($id)
// //     {
// //         // $id = DB::table('order')->insertGetId(
// //         //     ['keranjang_id' => $keranjang_qc->id_keranjang,
// //         //                 'nama_item' => $keranjang_qc->nama_item,
// //         //                 'kode_oracle' => $keranjang_qc->kode_oracle,
// //         //                 'jenis_item' => '',
// //         //                 'nomor' => '',
// //         //                 'jumlah' => 0,
// //         //                 'satuan' => 'gram',
// //         //                 'alasan' => $keranjang_qc->alasan,
// //         //                 'tgl_kirim' => Carbon\Carbon::now(),
// //         //                 'admin' => '',
// //         //                 'tgl_order' => Carbon\Carbon::now(),
// //         //                 'pemohon' => $keranjang_qc->pemohon,
// //         //                 'tgl_kadaluarsa_terbaru' =>  Carbon\Carbon::now(),
// //         //                 'pengirim' => '',
// //         //                 'plant' => $keranjang_qc->plant,
// //         //                 'pembuat' =>'',
// //         //             ]
// //         // );
// //         // dd($id);
// //         $insert = [];
// //         $keranjang_qc = Keranjang_QC::find($id);
// //        $insert = ['keranjang_id' => $id->id_keranjang,
// //                         'nama_item' => $id->nama_item,
// //                         'kode_oracle' => $id->kode_oracle,
// //                         'jenis_item' => '',
// //                         'nomor' => '',
// //                         'jumlah' => 0,
// //                         'satuan' => 'gram',
// //                         'alasan' => $id->alasan,
// //                         'tgl_kirim' => Carbon\Carbon::now(),
// //                         'admin' => '',
// //                         'tgl_order' => Carbon\Carbon::now(),
// //                         'pemohon' => $id->pemohon,
// //                         'tgl_kadaluarsa_terbaru' =>  Carbon\Carbon::now(),
// //                         'pengirim' => '',
// //                         'plant' => $id->plant,
// //                         'pembuat' =>'',
// //                     ];
// //        DB::table('order')->insert($insert);
// //        DB::table('keranjang_qc')->where('id_keranjang',$id)->delete();
// //        return redirect('/qc/keranjang');
// //     }

// //     public function kirim_semua_keranjang(Request $request)
// //     {
// //         $inserts = [];
// //                 $keranjang_qc = DB::table('keranjang_qc')->get();
// //                     foreach($keranjang_qc as $keranjang){
// //                     $inserts [] = 
// //                         [  'users_id' => $keranjang->users_id,
// //                         'standar_id' =>$keranjang->standar_id,
// //                         'nama_item' => $keranjang->nama_item,
// //                         'kode_oracle' => $keranjang->kode_oracle,
// //                         'jenis_item' => '',
// //                         'nomor' => '',
// //                         'alasan' => $keranjang->alasan,
// //                         'tgl_order' => Carbon\Carbon::now(),
// //                         'pemohon' => $keranjang->pemohon,
// //                         'plant' => $keranjang->plant,
// //                         'work_center' =>$keranjang->work_center,
// //                     ];   
// //                 }
// //             DB::table('order_qc')'hitungOrderSendiri',->insert($inserts);
// //             DB::table('keranjang_qc')->truncate();
// //          // Eloquent approach
// //         return redirect('/qc/keranjang');
// //     }

// //     public function cari_history_order(Request $request)
// //     {
// //         $keranjang_qc = Keranjang_QC::all();
// //         $order_qc = Order_QC::all();
// //         $order_qc = Order_QC::when($request->keyword,function ($query) use ($request) {
// //             $query->where('tgl_order', 'like', "%{$request->keyword}%");
// //         })->paginate($request->limit ?  $request->limit : 20);
// //         $order_qc->appends($request->only('keyword'));
// //         return view('/qc/history_order', compact('order_qc')'hitungOrderSendiri',,compact('keranjang_qc'));
// //     }

// //     public function hapus($id)
// //     {
// //        $order_diterima_qc = DB::tabl_qce('order_diterima_qc')->where('id_order',$id);
// //       $order_diterima_qc->delete();
// //         return redirect('/qc/order_diterima')->with('message','Berhasil dihapus');
// //     }

    // public function terpakai()
    // {
    //     $standar = Standar::when($request->ok,function ($query) use ($request) {
    //             $query->('stok' - )
    //     });

    // }
    
    //     DB::query()->Where(function ($query) use($checkbox) {
    //     for ($i = 0; $i < count($checkbox ); $i++){
    //           $query->orwhere('stat', 'like',  '%' . $checkbox [$i] .'%');
    //     }  
    // })->get();   
    
}
