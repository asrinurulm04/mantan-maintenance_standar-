<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Validation\Rule;
use Hash;
use Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    
    
  public function json_bagian(){

    $bagian = DB::table('tb_bagian')->get();

    return Datatables::of($bagian)
        ->addColumn('action', function ($bag) {
            if($bag->status == 'aktif')
            {
                return '
                <a href="/admin/bagian/nonaktif/'.$bag->id_bagian.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi non-aktif ?\');" class="btn btn-sm btn-primary"> Non aktifkan</a>
                ';
            }
           
            else
            {
                return '
                <a href="/admin/bagian/aktif/'.$bag->id_bagian.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi Aktif\');" class="btn btn-sm btn-primary"> Aktifkan </a>
                ';
            }
           
        })->make(true);
}
public function bagian()
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    // menghitung di sidebar hampir di semua view ada
   
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
    $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();

    $bagian = DB::table('tb_bagian')->get();
    $bagian = DB::table('tb_bagian')->paginate(10);
    
    return view('/admin/bagian',compact('bagian','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','order_diterima_qc'));
}
 
public function tambah_bagian(Request $request)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
     $bagian = DB::table('tb_bagian')->where('bagian', $request->bagian)->first();
     if(!$bagian)
     {
        DB::table('tb_bagian')->insert([
            'bagian' => $request->bagian
        ]);
        return redirect()->back()->with('alert',"Data berhasil ditambahkan");
     }
     else
     {
        return redirect()->back()->with('gagal',"Maaf terjadi kesalahan, Data yang Anda inputkan sudah terdaftar");
     }
}

 
public function ubah_menjadi_non_aktif($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    DB::table('tb_bagian')->where('id_bagian',$id)->update([
        'status'=> 'non-aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di non-aktifkan");
}
public function ubah_menjadi_aktif($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    DB::table('tb_bagian')->where('id_bagian',$id)->update([
        'status'=> 'aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di aktifkan");
}
    
    public function json(){

        $auth = Auth::user()->id;
        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('konfirmasi','Y')->where('id','!=',$auth)->get();

        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="/edit/users/profile/'.$user->id.'"class="btn btn-sm btn-primary">Lihat </a>
                <a href="/user/hapus/'.$user->id.'" onclick="javascript:return confirm(\'Anda yakin?\');" class="btn btn-sm btn-primary"> Hapus</a>
                ';
            })
          
            ->make(true);

        return Datatables::of(DB::table('users')->where('konfirmasi','Y')->where('id','!=',$auth)->get())->make(true);
    }

    public function user_aktif()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }

        // Variable untuk menghitung jumlah order Di Sidebar
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
        $order_diterima_rnd = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');

        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('konfirmasi','Y')->get();
        
        $user = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->first();
        return view('/admin/data_user',compact('users','user','order_qc','order_diterima_qc','order_diterima_rnd','order_rnd'));
    }

    public function profile()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','keranjang')->orWhere('stat','order');
          // 
        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('id',auth::user()->id)->get();
        
        return view('/admin/profile',compact('users','order','order2'));
    }

    public function user_belum_aktif()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
          $order_diterima_rnd = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
          $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
          // 

        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('konfirmasi','N')->get();
        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('konfirmasi','N')->paginate(10);
        return view('/admin/user_belum_aktif',compact('users','order_qc','order_diterima_qc','order_diterima_rnd','order_rnd'));
    }

    public function hapususer(Request $request,$id)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }
        DB::table('users')->where('id',$id)->delete();
        return redirect('/user')->with('hapus','Pengguna berhasil dihapus');
    }

    public function edit_users_profile($id)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }
        // Variable untuk menghitung jumlah order Di Sidebar QC
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
        $order_diterima_rnd = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        // 
        $bagian = DB::table('tb_bagian')->get();
        $work_center = DB::table('users')->get();
        
        $user = DB::table('users')->select('work_center')->get();
        $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('id',$id)->get();
        return view('/admin/edit_users_profile',compact('users','work_center','user','bagian','order_qc','order_diterima_qc','order_diterima_rnd','order_rnd'));
        
    }

    public function update_users_profile(Request $request)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
        $users = DB::table('users')->where('id',$request->id)->get();
        foreach($users as $us)
        {
            if($us->email != $request->email)
            {
                $validator = Validator::make($request->all(), [
            
                    'email' => ['required','email',Rule::unique('users')->ignore(Auth::id(), 'id')]]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->with('alert', 'Maaf permintaan Anda gagal, alamat email yang Anda masukkan sudah terpakai');
                }
                $users = DB::table('users')->where('id',$request->id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'username' => $request->username,
                    'work_center' => $request->work_center,
                    'bagian_id' => $request->bagian,
                    'plant' => $request->plant,
                ]);
            }
            else{
                $users = DB::table('users')->where('id',$request->id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'username' => $request->username,
                    'work_center' => $request->work_center,
                    'bagian_id' => $request->bagian,
                    'plant' => $request->plant,
                ]);
            }
        }
        return redirect()->back()->with('alert','Selamat profile Anda berhasil diubah');     

                                                                                                                                                                                                                                                   
    }


    public function standar_lokasi()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
        $order_diterima_rnd = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->get();
        return view('/admin/standar_lokasi',['standar'=>$standar]);
    }


    public function stok_rnd()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
        // Variable untuk menghitung jumlah order Di Sidebar QC
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
        $order_diterima_rnd = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        // 
        $standar = DB::table('standar')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->where('freeze','N')->get();
        $standar = DB::table('standar')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->where('freeze','N')->paginate(10);
        return view('/admin/stok_rnd',compact('standar','order','order2'));
    }

    public function standarhapus($id)
    {
        $standar = DB::table('standar')->where('id_standar',$id)->delete();
        return redirect()->back()->with('alert','Data Standar telah berhasil dihapus');
    }
    
    public function standar_edit($id)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','keranjang')->orWhere('stat','order');
          // 
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('id_standar',$id)->get();
        return view('/admin/data_standar_edit',['standar' => $standar],compact('tb_plant','tb_sub_kategori','tb_jenis_item','order','order2'));
    }

    public function standar_update(Request $request)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
        DB::table('standar')->where('id_standar',$request->id_standar)->update([
            'nama_item' => $request->nama_item,
            'kode_formula' => $request->kode_formula,
            'kode_revisi_formula' => $request->kode_revisi_formula,
            'nolot' => $request->nolot,
            'kategori_sub_id' => $request->sub_kategori,
            'jenis_item_id' => $request->jenis_item,
            'lokasi' => $request->lokasi,
            'umur_simpan' => $request->umur_simpan,
            'plant_id' => $request->plant,
            'tgl_dibuat' => $request->tgl_dibuat,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'tempat_penyimpanan' => $request->tempat_penyimpanan,
            'serving_size' => $request->serving_size,
            'stok_rnd' => $request->stok_rnd,
            'pembuat' => $request->pembuat,
            'keterangan' => $request->keterangan,
        ]);
        return redirect('/data/standar');
    }


    public function ubah_freeze(Request $request)
    {
       
        
        DB::table('standar')->where('id_standar',$request->id_standar)->update([
            'freeze' => 'Y'
        ]);
        $info = "Data". " ". $request->nama_item. " ". "telah berhasil di freeze";
    }


  
    public function datafreeze()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','keranjang')->orWhere('stat','order');
          // 
        
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('freeze','Y')->get();
        return view('/admin/standar_freeze',compact('standar','order','order2'));
    }

    public function konfirmasi(Request $request)
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }

         $users =  DB::table('users')->where('id',$request->id)->update([
            'konfirmasi' => 'Y'
        ]);

        try{
            Mail::send('emails.konfirmasi_user', ['nama' => $request->nama], function ($message) use ($request)
            {
                $message->subject('konfirmasi akun');
                $message->from('donotreply@gmail.com', 'Kiddy');
                $message->to($request->email);
            });
            return back()->with('alert-success','Berhasil Kirim Email');
        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

    }

    public function order_qc()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }

        $orders = DB::table('order')
        ->join('standar','order.standar_id','=','standar.id_standar')
        ->join('users','order.pemohon_id','=','users.id')
        ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('stat','keranjang')->orWhere('stat','order')->paginate(20);

        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order')->get();

        $standar = DB::table('standar')->get();
        $user = DB::table('users')
        ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->get();
        $orders = DB::table('order')
        ->join('standar','order.standar_id','=','standar.id_standar')
        ->join('users','order.pemohon_id','=','users.id')
        ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('stat','keranjang')->orWhere('stat','order')
        ->get();

        
        return view('/admin/order_qc',compact('order','order2','orders'));
    }

    
    public function order_diterima_qc()
     {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
        }
        
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
        $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','!=','kirim')->where('stat','!=','batal')->where('stat','!=','order_diterima')->where('stat','!=','keranjang_rd');

        $orders = DB::table('order')
        ->join('standar','order.standar_id','=','standar.id_standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('stat','kirim')
        ->get();
         return view('/admin/order_diterima_qc',compact('orders','order','order2'));
     }
     

     public function order_rnd()
     {
         if(Auth::user()->work_center != 'ADMIN'){
             return redirect()->back();
          }
          
            // Variable untuk menghitung jumlah order Di Sidebar QC
       
     $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
     $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','!=','kirim')->where('stat','!=','order_diterima');
        // 
         $orders = DB::table('order')->where('stat','order')->orWhere('stat','kirim')->orWhere('stat','keranjangrd');
         $order_qc = DB::table('order')->paginate(20);
         $standar = DB::table('standar')->get();
        
 
         $pengirim = DB::table('order')
         ->leftjoin('standar','order.standar_id','=','standar.id_standar')
         ->leftjoin('users','order.pengirim_id','=','users.id')
         ->leftjoin('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('stat','kirim')
         ->get();
 
         foreach($pengirim as $peng )
         {
             
         }
 
         $order_qc = DB::table('order')
         ->leftjoin('standar','order.standar_id','=','standar.id_standar')
         ->leftjoin('users','order.pemohon_id','=','users.id')
         ->leftjoin('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('stat','keranjangrd')->orWhere('stat','kirim')->orWhere('stat','order')
         ->get();
         $history = DB::table('history')->get();
         $users = DB::table('users')->get();
         return view('/admin/order_rnd',compact('orders','order','order2','peng'));
     }
 

    public function notifikasi()
    {
        return view('/admin/notifikasi');
    }
    public function stok_qc_wip()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
          // 

        $standar = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('status_qc','!=', '')
        ->orderBy('id_standar','desc')->where('jenis_item_id','1')->get();
        $standar = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('status_qc','!=', '')
        ->orderBy('id_standar','desc')->where('jenis_item_id','1')
        ->paginate(10);
        return view('/admin/stok_qc_wip',compact('standar','order','order2'));
    }

    public function stok_qc_bahan_baku()
    {
        if(Auth::user()->work_center != 'ADMIN'){
            return redirect()->back();
         }
          // Variable untuk menghitung jumlah order Di Sidebar QC
          $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
          $order_qc = DB::table('order')->where('stat','keranjang')->orWhere('stat','order');
          // 
         
        $standar = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('status_qc','!=', '')
        ->orderBy('id_standar','desc')->where('jenis_item_id','2')->get();
        $standar = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('status_qc','!=', '')->where('jenis_item_id','2')
        ->orderBy('id_standar','desc')
        ->paginate(10);
        return view('/admin/stok_qc_bahan_baku',compact('standar','order','order2'));
    }
   
   

    public function history()
    {
       if(Auth::user()->work_center != 'ADMIN'){
           return redirect()->back();
       }
      
     $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
     $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','!=','kirim')->where('stat','!=','order_diterima');
       
        $hitung = DB::table('history')
        ->leftjoin('standar','history.standar_id','=','standar.id_standar')
        ->leftjoin('users','history.users_id','=','users.id')->orderBy('id_history','desc')
        ->get();

       $history = DB::table('history')
       ->leftjoin('standar','history.standar_id','=','standar.id_standar')
       ->leftjoin('users','history.users_id','=','users.id')->orderBy('id_history','desc')
       ->get();
       $history = DB::table('history')
       ->leftjoin('standar','history.standar_id','=','standar.id_standar')
       ->leftjoin('users','history.users_id','=','users.id')->orderBy('id_history','desc')->paginate(6);
       return view('/admin/history',compact('history','order','order2','historys','pengirim','pen','hitung'));
    }

   
     
public function cari_tanggal(Request $request)
{
    if(Auth::user()->work_center != 'ADMIN'){
        return redirect()->back();
     }
   
     $order_diterima_qc = DB::table('order')->where('stat','kirim')->get();
     $order_qc = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','!=','kirim')->where('stat','!=','order_diterima');
     
     $history = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
     ->leftjoin('users','history.users_id','=','users.id')->when($request->dari_tanggal,function ($query) use ($request) {
        $dari_tanggal = $request->dari_tanggal;
        $ke_tanggal = $request->ke_tanggal;   
        $query->where('aktifitas','like',"%{$request->aktifitas}%")
        ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
     })->paginate($request->limit ?  $request->limit : 6);
     $history->appends($request->only('aktifitas','dari_tanggal','ke_tanggal'));

     $hitungJumlah = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
     ->leftjoin('users','history.users_id','=','users.id')->when($request->dari_tanggal,function ($query) use ($request) {
        $dari_tanggal = $request->dari_tanggal;
        $ke_tanggal = $request->ke_tanggal;   
        $query->where('aktifitas','like',"%{$request->aktifitas}%")
        ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
     });


    return view('/admin/history', compact('history','standar','order','order2','hitungJumlah'));


}


}


