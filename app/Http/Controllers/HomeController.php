<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;
use Illuminate\Validation\Rule;
use Hash;
use Validator;
use DataTables;
use Carbon;
use App\Order;
use Redirect;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function perbaikan(){
        return view('maintenace');
    }
    
    public function json_history_pakai(){

        $standars = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->get();

        return Datatables::of($standars)
            ->addColumn('action', function ($standar) {
                return '<a href="/history/pakai/detail/'.$standar->id_standar.'"class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat </a>';
            })->make(true);
            
    }
 
    public function history_pakai()
    {
        $history = DB::table('history')
        ->join('standar','history.standar_id','=','standar.id_standar')
        ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
        ->join('users','history.users_id','=','users.id')->orderBy('id_history','desc')
        ->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
        $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
                 $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $history = DB::table('history')
        ->join('standar','history.standar_id','=','standar.id_standar')->get();
        $history = DB::table('history')
        ->join('standar','history.standar_id','=','standar.id_standar')->paginate(10);
        
        return view('/history_pakai',compact('history','pesan1','pesan2','pesan3','pesan4','history','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order_diterima_qc','historys','pengirim','pen','hitung'));
    }
    

    public function history_detail_pakai($id)
    {
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $standar = DB::table('standar')->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_standar',$id)->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
       $hitungJumlah = DB::table('history')
       ->leftjoin('standar','history.standar_id','=','standar.id_standar')
        ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
       ->leftjoin('users','history.users_id','=','users.id')->get();
    
       $ambilSatu = DB::table('history')
       ->where('aktifitas','QC memakai std')
       ->OrWhere('aktifitas','QC membuang stok bahan baku')
       ->OrWhere('aktifitas','QC menambah stok bahan baku')
        ->join('standar', function ($join) use($id){
            $join->on('history.standar_id', '=', 'standar.id_standar')
            ->where('standar_id',$id);
        })
        ->join('tb_satuan', function ($join) {
            $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
        })
        ->join('users', function ($join) {
            $join->on('history.users_id', '=', 'users.id');
        })
       ->first();

       if($ambilSatu == "")
       {
        return view('/history_pakai_detail_kosong',compact('history','pesan1','pesan2','pesan3','pesan4','ambilSatu','hitungSemua','ambilId','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','order_diterima_qc','standar','QCMemakai','RDMengirim','QCMeminta'));
       }
      
       else
       {

        $hitungSemua = DB::table('history')
        ->where('aktifitas','QC memakai std')
        ->OrWhere('aktifitas','QC membuang stok bahan baku')
        ->OrWhere('aktifitas','QC menambah stok bahan baku')
         ->join('standar', function ($join) use($id){
             $join->on('history.standar_id', '=', 'standar.id_standar')
             ->where('standar_id',$id);
         })
         ->join('tb_satuan', function ($join) {
             $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
         })
         ->join('users', function ($join) {
             $join->on('history.users_id', '=', 'users.id');
         })
         ->get();
        $history = DB::table('history')
        ->where('aktifitas','QC memakai std')
        ->OrWhere('aktifitas','QC membuang stok bahan baku')
        ->OrWhere('aktifitas','QC menambah stok bahan baku')
         ->join('standar', function ($join) use($id){
             $join->on('history.standar_id', '=', 'standar.id_standar')
             ->where('standar_id',$id);
         })
         ->join('tb_satuan', function ($join) {
             $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
         })
         ->join('users', function ($join) {
             $join->on('history.users_id', '=', 'users.id');
         })->orderBy('id_history','DESC')
         ->get();
         
         $history = DB::table('history')
         ->where('aktifitas','QC memakai std')
         ->OrWhere('aktifitas','QC membuang stok bahan baku')
         ->OrWhere('aktifitas','QC menambah stok bahan baku')
          ->join('standar', function ($join) use($id) {
              $join->on('history.standar_id', '=', 'standar.id_standar')
              ->where('standar_id',$id);
          })
          ->join('tb_satuan', function ($join) {
             $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
         })
          ->join('users', function ($join) {
              $join->on('history.users_id', '=', 'users.id');
          })->orderBy('id_history','DESC')
          ->paginate(10);
 
         return view('/history_pakai_detail',compact('history','pesan1','pesan2','pesan3','pesan4','ambilSatu','hitungSemua','ambilId','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','order_diterima_qc','standar','QCMemakai','RDMengirim','QCMeminta'));
       }


  }

  
  

  public function cari_tanggal_detail(Request $request)
  {
  
    $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
    $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    

    $hitungJumlah = DB::table('history')->where('standar_id',$request->id_standar)
    ->join('standar', function ($join) use ($request){
            $join->on('history.standar_id', '=', 'standar.id_standar');
    })
    ->join('tb_satuan', function ($join) {
        $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
    })
    ->join('users', function ($join) {
            $join->on('history.users_id', '=', 'users.id');
    })->when($request->dari_tanggal,function ($query) use ($request) {
            $dari_tanggal = $request->dari_tanggal;
            $ke_tanggal = $request->ke_tanggal;   
            $query
            ->where('aktifitas','like',"%{$request->aktifitas}%")
        ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
    })->get();
     
    
    $ambilSatu =  DB::table('history')->where('standar_id',$request->id_standar)->first();
  
  
  $history = DB::table('history')->where('standar_id',$request->id_standar)
   ->join('standar', function ($join) use ($request){
       $join->on('history.standar_id', '=', 'standar.id_standar');
   })
   ->join('tb_satuan', function ($join) {
    $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
})
   ->join('users', function ($join) {
       $join->on('history.users_id', '=', 'users.id');
   })->when($request->dari_tanggal,function ($query) use ($request) {
     $dari_tanggal = $request->dari_tanggal;
     $ke_tanggal = $request->ke_tanggal;   
     $query
     ->where('aktifitas','like',"%{$request->aktifitas}%")
     ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
    })->paginate($request->limit ?  $request->limit : 10);
    $history->appends($request->only('id_standar','aktifitas','dari_tanggal','ke_tanggal'),$ambilSatu,$hitungJumlah);

       $standar = DB::table('standar')->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_standar',$request->id)->get();
  
      return view('/history_pakai_detail', compact('orders','pesan1','pesan2','pesan3','pesan4','ambilSatu','hitungJumlah','historys','history','standar','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order2','order_diterima_rnd','order_rnd','order_diterima_qc','hitungJumlah','standar','hitungJumlah','QCMemakai','RDMengirim','QCMeminta'));

  }



  public function history_detail($id)
  {
      $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
      $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
      $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
      $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
      $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
      $standar = DB::table('standar')->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_standar',$id)->get();
      
     $ambilSatu = DB::table('order')->where('standar_id',$id)->select('standar_id')->first();
     $orders = DB::table('order')->where('standar_id',$id)
     ->join('standar','order.standar_id','=','standar.id_standar')
     ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
     ->join('tb_bagian','order.bagian_pemohon','=','tb_bagian.id_bagian')
     ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
     ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
     ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
     ->where('pemohon','!=',NULL)->where('pengirim','!=',NULL)->where('penerima','!=',NULL)
     ->where('alasan','!=',NULL)->where('jumlah_kirim','!=',NULL)->where('jumlah_pesan','!=',NULL)
     ->where('tgl_order','!=',NULL)->where('tgl_kirim','!=',NULL)->where('tgl_diterima','!=',NULL)
     ->where('stat','!=','keranjang')->where('stat','!=','keranjang_rd')->orderBy('id_order','DESC')->get();

     $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
     
     $hitungSemua = DB::table('order')->where('pemohon','!=',NULL)->where('pengirim','!=',NULL)->where('penerima','!=',NULL)
     ->where('alasan','!=',NULL)->where('jumlah_kirim','!=',NULL)->where('jumlah_pesan','!=',NULL)
     ->where('tgl_order','!=',NULL)->where('tgl_kirim','!=',NULL)->where('tgl_diterima','!=',NULL)
     ->where('stat','!=','keranjang')->where('stat','!=','keranjang_rd')
     ->join('standar', function ($join) use($id){
         $join->on('order.standar_id', '=', 'standar.id_standar')
         ->where('standar_id',$id);
     })
     ->get();
     
     $hitungJumlah = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
     ->leftjoin('users','history.users_id','=','users.id')->get();


      return view('/history_detail',compact('orders','ambilSatu','pesan1','pesan2','pesan3','pesan4','hitungSemua','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','order_diterima_qc','standar','QCMemakai','RDMengirim','QCMeminta'));
}


  
  
public function cari_tanggal(Request $request)
{

  $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
   $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
  $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
  $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
   $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
  $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
  $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
  $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
  $ambilSatu = DB::table('order')->where('standar_id',$request->id_standar)->select('standar_id')->get();

$orders = DB::table('order')
 ->join('standar', function ($join) use ($request){
     $join->on('order.standar_id', '=', 'standar.id_standar')->where('id_standar',$request->id_standar);
 })
 ->join('tb_satuan', function ($join) use ($request){
    $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan')->where('id_standar',$request->id_standar);
})
  ->when($request->dari_tanggal,function ($query) use ($request) {
   $dari_tanggal = $request->dari_tanggal;
   $ke_tanggal = $request->ke_tanggal;   
   if($request->aktifitas=='tgl_kirim')
   $query
   ->whereBetween('tgl_kirim',[$dari_tanggal,$ke_tanggal]);
   else if($request->aktifitas=='tgl_order')
   $query
   ->whereBetween('tgl_order',[$dari_tanggal,$ke_tanggal]);
   else if($request->aktifitas=='tgl_diterima')
   $query
   ->whereBetween('tgl_diterima',[$dari_tanggal,$ke_tanggal]);
  })->paginate($request->limit ?  $request->limit : 1);
  $orders->appends($request->only('id_standar','aktifitas','dari_tanggal','ke_tanggal') );
  

  $hitungJumlah = DB::table('order')->where('standar_id',$request->id_standar)
  ->join('standar', function ($join) use ($request){
      $join->on('order.standar_id', '=', 'standar.id_standar');
  })
   ->when($request->dari_tanggal,function ($query) use ($request) {
    $dari_tanggal = $request->dari_tanggal;
    $ke_tanggal = $request->ke_tanggal;   
    if($request->aktifitas=='tgl_kirim')
    $query
    ->whereBetween('tgl_kirim',[$dari_tanggal,$ke_tanggal]);
    else if($request->aktifitas=='tgl_order')
    $query
    ->whereBetween('tgl_order',[$dari_tanggal,$ke_tanggal]);
    else if($request->aktifitas=='tgl_diterima')
    $query
    ->whereBetween('tgl_diterima',[$dari_tanggal,$ke_tanggal]);
   })->get();

    return view('/history_detail', compact('orders','ambilSatu','hitungJumlah','pesan1','pesan2','pesan3','pesan4','historys','history','standar','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order2','order_diterima_rnd','order_rnd','order_diterima_qc','hitungJumlah','standar','hitungJumlah','QCMemakai','RDMengirim','QCMeminta'));

}

  
  public function history_detail_pakai_standar($id)
  {
      $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
      $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
       $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
      $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
      $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
      $standar = DB::table('standar')->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_standar',$id)->get();
      $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
     $hitungJumlah = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
     ->leftjoin('users','history.users_id','=','users.id')->get();
  
     $history = DB::table('history')
     ->where('id_history',$id)
      ->join('standar', function ($join) use($id){
          $join->on('history.standar_id', '=', 'standar.id_standar');
      })
      ->join('users', function ($join) {
          $join->on('history.users_id', '=', 'users.id');
      })
      ->get();

      return view('/detail_history_pakai_standar',compact('history','pesan1','pesan2','pesan3','pesan4','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','order_diterima_qc','standar','QCMemakai','RDMengirim','QCMeminta'));
}


    public function tes()
    {
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
       $users = Order::all();
       $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
       return view('tes',compact('users','pesan1','pesan2','pesan3','pesan4','standar','tb_sub_kategori','tb_plant','hitungOrderSendiri','order_qc','order_diterima_qc','order_diterima','order_diterima_rnd','order_rnd'));
    }

    public function tes2()
    {

        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $users = User::all();
       return view('tes2',compact('users','standar','tb_sub_kategori','tb_plant','hitungOrderSendiri','order_qc','order_diterima_qc','order_diterima','order_diterima_rnd','order_rnd'));
    }

    public function input_wip_baru()
    { 
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
         }
         $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
         
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $tb_plant = DB::table('tb_plant')->where('status','aktif')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->where('status','aktif')->get();
        $tb_satuan = DB::table('tb_satuan')->where('status','aktif')->get();
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->get();
       
        return view('/rnd/input_wip_baru',compact('standar','pesan1','pesan2','pesan3','pesan4','tb_sub_kategori','tb_satuan','tb_plant','hitungOrderSendiri','order_qc','order_diterima_qc','order_diterima','order_diterima_rnd','order_rnd'));
    }

    
    public function input_wip_baru_store(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
         }
        DB::table('standar')->insert([
              'users_id' => $request->users_id,
              'kategori_sub_id' => 21,
              'plant_id' => $request->plant,
              'jenis_item_id' => 1,
              'catatan_serving_size' => $request->catatan,
              'satuan_id' => $request->satuan,
              'nama_item' => $request->nama_item,
              'kode_formula' => $request->kode_formula,
              'kode_oracle' => $request->kode_oracle,
              'lokasi' => $request->lokasi,
              'stok_qc' => NULL,
              'stok_rnd' => $request->stok_rnd,
              'umur_simpan' => $request->umur_simpan,
              'stok_rnd' => $request->stok_rnd,
              'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
              'tgl_dibuat' => $request->tgl_dibuat,
              'tgl_terima' => null,
              'nolot' => null,
              'serving_size' => $request->serving_size,
              'tempat_penyimpanan' => $request->tempat_penyimpanan,
              'kode_revisi_formula' => $request->kode_revisi_formula,
              'pembuat' => $request->pembuat,
              'keterangan_standar' => $request->keterangan,
              'freeze' => 'N'
          ]);
          
          DB::table('standar')->update([
              'stok_rnd' => $request->stok_rnd
          ]);

                // $standar = DB::table('standar')->where('id_standar', \DB::raw("(select max(`id_standar`) from standar)"))->get();

                
                // foreach($standar as $s)
                // {
                //     $s->id_standar;
                            
                //     DB::table('history')->insert([
                //         "order_id" =>NULL,
                //         'standar_id' => $s->id_standar,
                //         'users_id' => Auth::user()->id,
                //         "jenis_perubahan" => "baru",
                //         "aktifitas" => "RD membuat std baru",
                //         "alasan" => "standar baru",
                //         "jumlah" => $request->stok_rnd,
                //         "tgl" => Carbon\Carbon::now(),
                //         "Keterangan" => "RD membuat std baru",
                //     ]);
                // }

            return redirect()->back()->with('message','Input WIP baru berhasil !');
    }

    public function hapusnotif(){
        $notif = DB::table('tb_notification')->delete();

        return redirect::back();
    }


    public function input_bahan_baku_baru()
    { 
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
         }
         $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    
         $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
          $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
         $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
                 $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $tb_plant = DB::table('tb_plant')->where('status','aktif')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->where('status','aktif')->get();
        $tb_satuan = DB::table('tb_satuan')->where('status','aktif')->get();
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->get();
       
        return view('/rnd/input_bahan_baku_baru',compact('standar','pesan1','pesan2','pesan3','pesan4','tb_sub_kategori','tb_satuan','tb_plant','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order_diterima_qc'));
    }

    
    public function input_bahan_baku_baru_store(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
         }
        
        DB::table('standar')->insert([
              'users_id' => $request->users_id,
              'kategori_sub_id' => $request->sub_kategori,
              'plant_id' => $request->plant,
              'jenis_item_id' => 2,
              'catatan_serving_size' => $request->catatan,
              'satuan_id' =>$request->satuan,
              'nama_item' => $request->nama_item,
              'kode_formula' => $request->kode_formula,
              'kode_oracle' => $request->kode_oracle,
              'lokasi' => $request->lokasi,
              'stok_qc' => NULL,
              'stok_rnd' => $request->stok_rnd,
              'umur_simpan' => $request->umur_simpan,
              'stok_rnd' => $request->stok_rnd,
              'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
              'tgl_dibuat' => $request->tgl_dibuat,
              'tgl_terima' => null, 
              'nolot' => $request->nolot,
              'serving_size' => $request->serving_size,
              'tempat_penyimpanan' => $request->tempat_penyimpanan,
              'kode_revisi_formula' => $request->kode_revisi_formula,
              'pembuat' => $request->pembuat,
              'keterangan_standar' => $request->keterangan,
              'freeze' => 'N'
          ]);

          DB::table('standar')->update([
            'stok_rnd' => $request->stok_rnd
        ]);
          
            //     $standar = DB::table('standar')->where('id_standar', \DB::raw("(select max(`id_standar`) from standar)"))->get();
            // foreach($standar as $s)
            // {
            //     $s->id_standar;
                        
            //     DB::table('history')->insert([
            //         "order_id" =>NULL,
            //         'standar_id' => $s->id_standar,
            //         'users_id' => Auth::user()->id,
            //         "jenis_perubahan" => "baru",
            //         "aktifitas" => "RD membuat std baru",
            //         "alasan" => "standar baru",
            //         "jumlah" => $request->stok_rnd,
            //         "tgl" => Carbon\Carbon::now(),
            //         "Keterangan" => "RD membuat std baru",
            //     ]);
            // }

            return redirect()->back()->with('message','Input bahan baku baru berhasil !');
    }


    public function index()
    {
    $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
    $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
    $bagian = DB::table('tb_bagian')->get();
    $app = DB::table('users')->where('konfirmasi','=','N')->count();
    $users = DB::table('users')->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('id',auth::user()->id)->get();
    return view('home',compact('users','app','pesan1','pesan2','pesan3','pesan4','pesan4','hitungOrderSendiri','pesan1','order_qc','order_diterima','order_diterima_rnd','order_rnd','order_diterima_qc','bagian'));
    }

    public function update_profile(Request $request)
    {
                
        $this->validate($request, [
           
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $users = DB::table('users')->where('id',$request->id)->get();
        foreach($users as $u){
        if($u->username != $request->username)
        {

            $validator = Validator::make($request->all(), [
        
                'username' => ['required','string',Rule::unique('users')->ignore(Auth::id(), 'id')]]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->with('alert', 'Maaf permintaan Anda gagal, Username yang Anda masukkan sudah terpakai');
                }
                else {
                   
                    $user = DB::table('users')->where('id',$request->id)->update([
                        'username' => $request->username,
                    ]);
                    return redirect()->back()
                            ->with('alert', 'Selamat profile Anda berhasil diubah');
                }
    
         }
            
   
        }
       
        $links = session()->has('links') ? session('links') : [];
        $currentLink = request()->path(); // Getting current URI like 'category/books/'
        array_unshift($links, $currentLink); // Putting it in the beginning of links array
        session(['links' => $links]); // Saving links array to the session
        $user = DB::table('users')->where('id',$request->id)->get();
        foreach($user as $u){
            
        if($u->email != $request->email)
        {
            $validator = Validator::make($request->all(), [
        
            'email' => ['required','email',Rule::unique('users')->ignore(Auth::id(), 'id')]]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->with('alert', 'Maaf permintaan Anda gagal, alamat email yang Anda masukkan sudah terpakai');
            }
            else if (Hash::check($request->password,$u->password )) {
                $user = DB::table('users')->where('id',$request->id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'username' => $request->username,
                ]);
                return redirect()->back()
                        ->with('alert', 'Selamat profile Anda berhasil diubah');
            }
            
        }
        else if (Hash::check($request->password,$u->password )) {
            $user = DB::table('users')->where('id',$request->id)->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
            ]);
            return redirect()->back()
                    ->with('alert', 'Selamat profile Anda berhasil diubah');
        }
        else{
            return redirect()
            ->back()->with('alert','Maaf profile Anda gagal diubah, password yang Anda masukkan salah');
        }
        
    }

      
            
    }

  
    public function ubah_password(Request $request)
    {
        $user = DB::table('users')->where('id',$request->id_user)->get();
            
        foreach($user as $u)
        {
            if (Hash::check($request->password_lama,$u->password )) {
                $user = DB::table('users')->where('id',$request->id_user)->update([
                    'password' => bcrypt($request->password),
                ]);
                return redirect()
                ->back()->with('alert','Selamat password Anda berhasil diubah');
            }
            else{
                return redirect()
                ->back()->with('alert','Maaf password gagal diubah, password yang Anda masukkan salah');
            }
         
        }
       
            
    }

    public function json_history(){

        $standars = DB::table('history')
        ->join('standar','history.standar_id','=','standar.id_standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->where('aktifitas','=','QC meminta std')->get();

        return Datatables::of($standars)
            ->addColumn('action', function ($standar) {
                return '<a href="/history/detail/'.$standar->id_standar.'"class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat </a>';
            })->make(true);
            
    }
 
    public function history()
    {
        $history = DB::table('history')
        ->join('standar','history.standar_id','=','standar.id_standar')
        ->join('users','history.users_id','=','users.id')->orderBy('id_history','desc')
        ->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        
        return view('/history',compact('history','pesan1','pesan2','pesan3','pesan4','standar','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order_diterima_qc','historys','pengirim','pen','hitung'));
    }
    
    
  public function cari_history(Request $request)
  {
        $order_diterima = DB::table('order')->where('stat','order')->orWhere('stat','kirim');
         $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
       $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
       $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
       $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
                $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
       $history = DB::table('history')
       ->join('standar','history.standar_id','=','standar.id_standar')
       ->join('users','history.users_id','=','users.id')->orderBy('id_history','desc')
       ->get();
       
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
       $history = DB::table('history')
       ->leftjoin('standar','history.standar_id','=','standar.id_standar')
       ->leftjoin('users','history.users_id','=','users.id')
       ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->when($request->dari_tanggal,function ($query) use ($request) {
          $dari_tanggal = $request->dari_tanggal;
          $ke_tanggal = $request->ke_tanggal;   
          $query
          ->where('aktifitas','like',"%{$request->aktifitas}%")
          ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
       })->paginate($request->limit ?  $request->limit : 10);
       $history->appends($request->only('aktifitas','dari_tanggal','ke_tanggal'));
       $standar = DB::table('standar')->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_standar',$request->id)->get();
  
      return view('/history', compact('history','pesan1','pesan2','pesan3','pesan4','hitungJumlah','standar','hitungOrderSendiri','order_qc','order_diterima','order_diterima_rnd','order_rnd','order_diterima_qc','hitungJumlah','standar','QCMemakai','RDMengirim','QCMeminta'));
  
  
  }
 
   
    public function json_kategori(){

        $kategori = DB::table('tb_sub_kategori')->get();

        return Datatables::of($kategori)
            ->addColumn('action', function ($kat) {
            if($kat->status == 'aktif')
            {
                return '<a href="/rnd/kategori/nonaktif/'.$kat->id_sub_kategori.'" onclick="javascript:return confirm(\'Anda yakin?\');" class="btn btn-sm btn-primary">Non Aktifkan</a>
                ';
               
            }
           
            else
            {
                return '<a href="/rnd/kategori/aktif/'.$kat->id_sub_kategori.'" onclick="javascript:return confirm(\'Anda yakin?\');" class="btn btn-sm btn-primary">Aktifkan</a>
                ';
                
            }
           
        })->make(true);
    }

public function kategori()
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    // menghitung di sidebar hampir di semua view ada
   
    $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();

    $kategori = DB::table('tb_sub_kategori')->get();
    $kategori = DB::table('tb_sub_kategori')->paginate(10);
    
    return view('/rnd/kategori',compact('kategori','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','pesan1','pesan2','pesan3','pesan4','order_diterima_qc'));
}
 
public function tambah_kategori(Request $request)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
     $kategori = DB::table('tb_sub_kategori')->where('nama_kategori', $request->nama_kategori)->first();
     if(!$kategori)
     {
        DB::table('tb_sub_kategori')->insert([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect()->back()->with('alert',"Data berhasil ditambahkan");
     }
     else
     {
        return redirect()->back()->with('gagal',"Maaf terjadi kesalahan, Data yang Anda inputkan sudah terdaftar");
     }
}


 
public function nonaktifkategori($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_sub_kategori')->where('id_sub_kategori',$id)->update([
        'status'=> 'non-aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di non-aktifkan");
}


public function aktifkategori($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_sub_kategori')->where('id_sub_kategori',$id)->update([
        'status'=> 'aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di aktifkan");
}

 
public function hapus_kategori($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    DB::table('tb_sub_kategori')->where('id_sub_kategori',$id)->delete();
    return redirect()->back()->with('alert',"Data berhasil dihapus");
}


public function json_plant(){

    $plant = DB::table('tb_plant')->get();

    return Datatables::of($plant)
        ->addColumn('action', function ($pla) {

            if($pla->status == 'aktif')
            {
                return '
                <a href="/rnd/plant/nonaktif/'.$pla->id_plant.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi non-aktif ?\');" class="btn btn-sm btn-primary"> Non aktifkan</a>
                ';
            }
           
            else
            {
                return '
                <a href="/rnd/plant/aktif/'.$pla->id_plant.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi Aktif\');" class="btn btn-sm btn-primary"> Aktifkan </a>
                ';
            }
            
        })->make(true);
}
public function plant()
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    // menghitung di sidebar hampir di semua view ada
   
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();

    $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $plant = DB::table('tb_plant')->get();
    $plant = DB::table('tb_plant')->paginate(10);
    
    return view('/rnd/plant',compact('plant','hitungOrderSendiri','order_qc','order_diterima_rnd','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_qc'));
}
 
public function tambah_plant(Request $request)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }

     $plant = DB::table('tb_plant')->where('plant', $request->plant)->first();
     if(!$plant)
     {
        DB::table('tb_plant')->insert([
            'plant' => $request->plant
        ]);
        return redirect()->back()->with('alert',"Data berhasil ditambahkan");
     }
     else
     {
        return redirect()->back()->with('gagal',"Maaf terjadi kesalahan, Data yang Anda inputkan sudah terdaftar");
     }
}

 
public function nonaktifplant($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_plant')->where('id_plant',$id)->update([
        'status'=> 'non-aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di non-aktifkan");
}


public function aktifplant($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_plant')->where('id_plant',$id)->update([
        'status'=> 'aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di aktifkan");
}

public function json_satuan(){

    $satuan = DB::table('tb_satuan')->get();

    return Datatables::of($satuan)
        ->addColumn('action', function ($sat) {

            if($sat->status == 'aktif')
            {
                return '
                <a href="/rnd/satuan/nonaktif/'.$sat->id_satuan.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi non-aktif ?\');" class="btn btn-sm btn-primary"> Non aktifkan</a>
                ';
            }
           
            else
            {
                return '
                <a href="/rnd/satuan/aktif/'.$sat->id_satuan.'" onclick="javascript:return confirm(\'Anda yakin ingin mengubah menjadi Aktif\');" class="btn btn-sm btn-primary"> Aktifkan </a>
                ';
            }

        })->make(true);
}
public function satuan()
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
    // menghitung di sidebar hampir di semua view ada
   
    $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
    $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
     $hitungOrderSendiri = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
    $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
    $order_diterima_qc = DB::table('order')->where('email_pemohon',Auth::user()->email)->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();

    $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
    $satuan = DB::table('tb_satuan')->get();
    $satuan = DB::table('tb_satuan')->paginate(10);
    
    return view('/rnd/satuan',compact('satuan','hitungOrderSendiri','order_qc','order_diterima_rnd','order_rnd','pesan1','pesan2','pesan3','pesan4','order_diterima_qc'));
}
 
public function tambah_satuan(Request $request)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }

     $satuan = DB::table('tb_satuan')->where('satuan', $request->satuan)->first();
     if(!$satuan)
     {
        DB::table('tb_satuan')->insert([
            'satuan' => $request->satuan
        ]);
        return redirect()->back()->with('alert',"Data berhasil ditambahkan");
     }
     else
     {
        return redirect()->back()->with('gagal',"Maaf terjadi kesalahan, Data yang Anda inputkan sudah terdaftar");
     }
}

public function nonaktifsatuan($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_satuan')->where('id_satuan',$id)->update([
        'status'=> 'non-aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di non-aktifkan");
}


public function aktifsatuan($id)
{
    if(Auth::user()->work_center == 'QC'){
        return redirect()->back();
     }
       
    DB::table('tb_satuan')->where('id_satuan',$id)->update([
        'status'=> 'aktif'
    ]);
    return redirect()->back()->with('alert',"Data berhasil di aktifkan");
}



}
