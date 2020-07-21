<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Standar;
use App\Exports\StandarUexport;
use App\History;
use Carbon;

use Redirect;
use Mail;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\DB;
use App\Exports\StandarWIPExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class RNDController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function export_wip()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
         
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->where('freeze','N')->get(); 
        
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->where('freeze','N')->where('jenis_item_id','1')->paginate(10);
        
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/excel/data_wip',compact('standar','order_qc','order_diterima_qc','order_rnd','pesan1','pesan2','pesan3','pesan4','order_diterima_rnd'));
    }

    public function export_excel_wip()
    {
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
     
        return (new StandarWIPExport('1'))->download('WIP.xlsx',\Maatwebsite\Excel\Excel::XLSX);
       
    }

    public function export_excel_baku()
    {
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
     
        return (new StandarWIPExport('2'))->download('BahanBaku.xlsx',\Maatwebsite\Excel\Excel::XLSX);
    }

    public function json_freeze(){

        $standar = DB::table('standar')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->where('freeze','Y')->get();

        return Datatables::of($standar)
        ->addColumn('action', function ($standa) {
            return '
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Opsi <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    
                <li><a href="/rnd/data/standar/lihat/'.$standa->id_standar.'" class="dropdown-item" ><i class="fa fa-eye"></i> Lihat</a></li>
                  <li><a href="/rnd/standar/freeze/edit/'.$standa->id_standar.'" name="edit" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                <li><a href="/rnd/standar/unfreeze/'.$standa->id_standar.'" name="edit" class="dropdown-item"><i class="fa fa-bolt"></i> Unfreeze</a></li>
                </ul>
            </div>
                
            ';
        })->make(true);
            
    }

    public function freeze()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
     
        $standar = DB::table('standar')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->where('freeze','Y')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();  
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/rnd/standar_freeze',compact('standar','order_rnd','order_diterima_rnd','order_qc','order_diterima_qc','pesan1','pesan2','pesan3','pesan4'));
    }

    public function standar()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
         
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $standar = DB::table('standar')
            ->leftjoin('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->leftjoin('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('jenis_item_id','1')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->where('jenis_item_id','1')
            ->where('freeze','N')->orderBy('nama_item','ASC')->get(); 
        
        $standar = DB::table('standar')
            ->leftjoin('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->leftjoin('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->where('jenis_item_id','1')
            ->where('freeze','N')->where('jenis_item_id','1')->orderBy('nama_item','ASC')->get();
        
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();   
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/rnd/data_standar',compact('standar','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd','pesan1','pesan2','pesan3','pesan4'));
    }

    public function data_standar_hapus(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        DB::table('standar')->where('id_standar',$request->id_standar)->delete();
        $delete = "Data". " ". $request->nama_item. " ". "telah berhasil dihapus";
        return redirect()->back()->with('delete',$delete);
    }

    public function standar_edit($id)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_satuan = DB::table('tb_satuan')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->where('id_standar',$id)->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/rnd/data_standar_edit',compact('standar','tb_plant','tb_satuan','tb_sub_kategori','tb_jenis_item','order_qc','order_diterima_qc','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_rnd'));
    }

    public function standar_lihat($id)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('id_standar',$id)->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        return view('/rnd/data_standar_lihat',compact('standar','tb_plant','tb_sub_kategori','tb_jenis_item','order_qc','order_diterima_qc','order_rnd','pesan1','pesan2','pesan3','pesan4','order_diterima_rnd'));
    }

    public function standar_update(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        if($request->sub_kategori == "")
        { 
            DB::table('standar')->where('id_standar',$request->id_standar)->update([
                'nama_item' => $request->nama_item,
                'kode_formula' => $request->kode_formula,
                'kode_oracle' => $request->kode_oracle,
                'kode_revisi_formula' => $request->kode_revisi_formula,
                'nolot' => $request->nolot,
                'kategori_sub_id' => 1,
                'jenis_item_id' => $request->jenis_item,
                'lokasi' => $request->lokasi,
                'umur_simpan' => $request->umur_simpan,
                'plant_id' => $request->plant,
                'tgl_dibuat' => $request->tgl_dibuat,
                'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'serving_size' => $request->serving_size,
                'catatan_serving_size' => $request->catatan_serving_size,
                'stok_rnd' => $request->stok_rnd,
                'satuan_id' => $request->satuan,
                'pembuat' => $request->pembuat,
            ]);
        }
       
        else{
            DB::table('standar')->where('id_standar',$request->id_standar)->update([
                'nama_item' => $request->nama_item,
                'kode_formula' => $request->kode_formula,
                'kode_oracle' => $request->kode_oracle,
                'kode_revisi_formula' => $request->kode_revisi_formula,
                'nolot' => $request->nolot,
                'kategori_sub_id' => $request->sub_kategori,
                'jenis_item_id' => $request->jenis_item,
                'lokasi' => $request->lokasi,
                'umur_simpan' => $request->umur_simpan,
                'plant_id' => $request->plant,
                'tgl_dibuat' => $request->tgl_dibuat,
                'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'serving_size' => $request->serving_size,
                'catatan_serving_size' => $request->catatan_serving_size,
                'stok_rnd' => $request->stok_rnd,
                'satuan_id' => $request->satuan,
                'pembuat' => $request->pembuat,
            ]);
        }
       
        $nama_item = 'Data'. ' '. $request->nama_item. " ". 'Berhasil Diubah';
        if($request->jenis_item_id == '1')
        {
            return redirect('/rnd/data/standar')->with('message',$nama_item);
        }
        else
        {
            return redirect('/rnd/standar/baku')->with('message',$nama_item);
        }
    }

    public function bahan_baku_edit($id)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('id_standar',$id)->get();
        return view('/rnd/bahan_baku_edit',compact('standar','pesan1','pesan2','pesan3','pesan4','tb_plant','tb_sub_kategori','tb_jenis_item','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd'));
    }

    public function bahan_baku_update(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        DB::table('standar')->where('id_standar',$request->id_standar)->update([
            'nama_item' => $request->nama_item,
            'kode_formula' => $request->kode_formula,
            'kode_oracle' => $request->kode_oracle,
            'kode_revisi_formula' => $request->kode_revisi_formula,
            'nolot' => $request->nolot,
            'kategori_sub_id' => $request->sub_kategori,
            'jenis_item_id' => $request->jenis_item,
            'lokasi' => $request->lokasi,
            'umur_simpan' => $request->umur_simpan,
            'plant_id' => $request->plant,
            'tgl_dibuat' => $request->tgl_dibuat,
            'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
            'tempat_penyimpanan' => $request->tempat_penyimpanan,
            'serving_size' => $request->serving_size,
            'stok_rnd' => $request->stok_rnd,
            'satuan' => $request->satuan,
            'pembuat' => $request->pembuat,
        ]);

        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->get();
        $stok = [];
        foreach($standar as $sta)
        {
            
        DB::table('history')->insert([
            "order_id" => $request->null,
            "standar_id" => $request->id_standar,
            "users_id" => Auth::user()->id,
            'jenis_perubahan' => "update",
            "aktifitas" => "RD mengubah std",
            "alasan" => "kebutuhan",
            "jumlah" => $request->stok_rnd,
            "keterangan" => '-',
            "tgl" =>  Carbon\Carbon::now(),
        ]);

        }
        $nama_item = 'Data'. ' '. $request->nama_item. " ". 'Berhasil Diubah';
        return redirect('/rnd/standar/baku')->with('message',$nama_item);
    }

    public function cari_standar(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $standar2 = DB::table('standar')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->get();
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori', function ($join) {
                $join->on('standar.kategori_sub_id', '=', 'tb_sub_kategori.id_sub_kategori')
                ->where('jenis_item_id','1')
                ->where('freeze','N');
            })
          
        
            ->join('tb_plant', function ($join) {
               $join->on('standar.plant_id', '=', 'tb_plant.id_plant');
            })
            ->join('tb_satuan', function ($join) {
                $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
            })
            ->when($request->keyword,function ($query) use ($request) {
            $query
            ->where('nama_item', 'like', "%{$request->keyword}%")
            ->orWhere('kode_oracle', 'like', "%{$request->keyword}%");
            })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('keyword'),$standar2);
    
        return view('/rnd/data_standar', compact('standar','pesan1','pesan2','pesan3','pesan4','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd'));
    }

    public function cari_stok_wip(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
         }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->where('jenis_item_id','1')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('freeze','N')
            ->when($request->stok,function ($query) use ($request) {
            $query->where('status_rnd', 'like', "%{$request->stok}%");
        })->orderBy('nama_item','ASC')->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('stok'));
    
        return view('/rnd/data_standar',compact('standar','pesan1','pesan2','pesan3','pesan4','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd'));
     }

    // public function notifikasi()
    // {
    //     return view('/rnd/notifikasi');
    // }
   
    public function awal_kirim($id)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');

        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('id_standar',$id)->get();
        return view('/rnd/awal_kirim',compact('standar','pesan1','pesan2','pesan3','pesan4','tb_plant','tb_sub_kategori','tb_jenis_item','order_rnd','order_diterima_rnd'));
    }

    public function masuk_keranjang(Request $request)
    {
        $order = DB::table('order')->insert([
            'standar_id'=> $request->id_standar,
            'pemohon'=> null,
            'pengirim'=> Auth::user()->nama,
            'penerima'=> null,
            'stat' => 'keranjangrd',
            'alasan' => null,
            'jumlah_kirim' => null,
            'jumlah_pesan' => null,
            "tgl_order" => Carbon\Carbon::now(),
            "tgl_kirim" => null,
            "tgl_diterima" => null,
            
        ]);
        $info = "Data". " ". $request->nama_item. " ". "telah berhasil dimasukkan ke dalam keranjang";
        return redirect()->back()->with('keranjang',$info);
    }

    public function order()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $bagian =DB::table('tb_bagian')->get();
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->get()->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_bagian','order.bagian_pemohon','=','tb_bagian.id_bagian')
            ->where('stat','kirim')->orWhere('stat','pesan')->orWhere('stat','order_diterima')->orderBy('stat', 'asc')
            ->get();
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_bagian','order.bagian_pemohon','=','tb_bagian.id_bagian')
            ->where('stat','kirim')->orWhere('stat','pesan')->orderBy('stat', 'asc')
            ->get();
        $history = DB::table('history')->get();
        $users = DB::table('users')->get();
        return view('/rnd/order',compact('orders','bagian','order_qc','pesan1','pesan2','pesan3','pesan4','order_diterima_qc','pesan','order2','order_rnd','order_diterima_rnd','history','order_qc'));
    }
    

    public function order_unrequest_batal(Request $request)
    {
        DB::table('order')->where('id_order',$request->id_order)->delete();
        return redirect()->back()->with('alert','Berhasil Membatalkan Order');
    }

    public function cari_tanggal_order(Request $request)
    {
    
        $order_diterima = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->get()->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_bagian','order.bagian_pemohon','=','tb_bagian.id_bagian')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->orderBy('stat', 'asc')->when($request->dari_tanggal,function ($query) use ($request) {
            $dari_tanggal = $request->dari_tanggal;
            $ke_tanggal = $request->ke_tanggal;   
            $query->where('stat','!=','kirim_unrequest')
            ->where('stat','like',"%{$request->status}%")
            ->whereBetween('tgl_order',[$dari_tanggal,$ke_tanggal]);
            })->paginate($request->limit ?  $request->limit : 10);
        $orders->appends($request->only('stat','dari_tanggal','ke_tanggal'));
    
        return view('/rnd/order',compact('orders','pesan1','pesan2','pesan3','pesan4','pesan','order2','order_rnd','order_diterima_rnd','history'));
    }

    public function cari_tanggal_order_unrequest(Request $request)
    {
    
        $order_diterima = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->get()->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $orders = DB::table('order')
        ->leftjoin('standar','order.standar_id','=','standar.id_standar')
        ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->orderBy('stat', 'asc')->when($request->dari_tanggal,function ($query) use ($request) {
            $dari_tanggal = $request->dari_tanggal;
            $ke_tanggal = $request->ke_tanggal;   
            $query
            ->where('stat','like',"%{$request->status}%")
            ->whereBetween('tgl_order',[$dari_tanggal,$ke_tanggal]);
        })->paginate($request->limit ?  $request->limit : 10);
        $orders->appends($request->only('stat','dari_tanggal','ke_tanggal'));
    
        return view('/rnd/order_unrequest',compact('orders','pesan1','pesan2','pesan3','pesan4','pesan','order_qc','order_diterima_qc','order2','order_rnd','order_diterima_rnd','history'));
    }

    public function order_unrequest()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $hitungOrderSendiri = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->get()->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $orders = DB::table('order')->paginate(20);
        $standar = DB::table('standar')->get();
       
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest')->orWhere('stat','order_unrequest_diterima')
            ->orderBy('stat')
            ->get();
        
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get(); 
        $history = DB::table('history')->get();
        $users = DB::table('users')->get();
        return view('/rnd/order_unrequest',compact('orders','pesan1','pesan2','pesan3','pesan4','order_qc','order_diterima_qc','pemohon','history','pesan','order2','order_rnd','order_diterima_rnd'));
    }

    public function order_batal(Request $request)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
         }

         
        $data1= DB::table('order')->where('id_order', $request->id_order)->where('stat','pesan')->update([
            'stat' => 'keranjang',
            'tgl_order' => null
        ]);
        $data2= DB::table('standar')->where('id_standar', $request->id_standar)->update([
            'kondisi' => 'keranjang',
        ]);

            
        $data =DB::table('order')->where('id_order', $request->id_order)
        ->join('standar','standar.id_standar','=','order.standar_id')->get();
        try{
            Mail::send('emails.batalkan_order', [
                'nama' => $request->nama,
                'data'=>$data,
                'info'=>'Pembatalan order oleh RD, harap refresh halaman permintaan order pada aplikasi MANTAN V2',
            ],function($message)use($request)
            {
                $message->subject('Pembatalan Order Oleh RD');
                $message->from('app.mantan@nutrifood.co.id', 'MANTAN V2');
                $data = DB::table('order')->where('id_order',$request->id_order)->get();
                    foreach($data as $data){
                        $data1 = $data->email_pemohon;
                        //  dd($data1);
                        $message->to($data1);
                    }
            });
        }
        catch (Exception $e){
        return response (['status' => false,'errors' => $e->getMessage()]);
        }
        return redirect::back();
    }

    // public function order()
    // {
    //     if(Auth::user()->work_center != 'RND'){
    //         return redirect()->back();
    //      }
    //     $order = DB::table('order')
    //     ->join('standar','order.standar_id','=','standar.id_standar')
    //     ->join('users','order.pengirim_id','=','users.id')
    //     ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->where('stat','keranjang')->orWhere('stat','pesan')->orWhere('stat','kirim')
    //     ->get();
    //     return view('/rnd/order',['pesan' => $order],compact('users'));
    // }

    public function order_proses($id)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
         
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();    
        $orders = DB::table('order')->paginate(20);
        $standar = DB::table('standar')->get();
        $user = DB::table('users')
            ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->get();
        
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('id_order',$id)
            ->get();
      
        return view('/rnd/order_proses',compact('orders','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_rnd','standar'));
    }
  
    public function order_proses_unrequest($id)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
         
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');

        $orders = DB::table('order')->paginate(20);
        $standar = DB::table('standar')->get();
        $user = DB::table('users')
            ->join('tb_bagian','users.bagian_id','=','tb_bagian.id_bagian')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $orders = DB::table('order')
            ->leftjoin('standar','order.standar_id','=','standar.id_standar')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->leftjoin('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')->where('id_order',$id)
            ->get();
      
        return view('/rnd/order_proses_unrequest',compact('orders','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_rnd','standar'));
    }

    public function proses_order(Request $request)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
         
        $stokRND = DB::table('standar')->where('id_standar',$request->standar_id)->get();
        foreach($stokRND as $stok)
        {
             
            if($request->jumlah_kirim != "")
            {
                if($stok->stok_rnd < $request->jumlah_kirim)
                {
                    return redirect()->back()->with('kirim','Maaf stok Anda tidak mencukupi untuk melakukan pengiriman');
                }
                elseif($stok->status_rnd =='kadaluarsa'){
                    return redirect()->back()->with('kirim','Maaf stok Anda kadaluarsa sehingga tidak bisa melakukan pengiriman');
                }
                elseif($stok->status_rnd =='habis'){
                    return redirect()->back()->with('kirim','Maaf stok Anda habis sehingga tidak bisa melakukan pengiriman');
                }
                else{
                    $stok_rnd = $stok->stok_rnd - $request->jumlah_kirim;
                
                    $standar = DB::table('standar')->where('id_standar',$request->standar_id)->update([
                        'stok_rnd' => $stok_rnd,
                        'kondisi' => 'proses_kirim'
                    ]);
                    DB::table('order')->where('id_order',$request->order_id)->update([
                        "pengirim" => Auth::user()->nama,
                        "jumlah_kirim" => $request->jumlah_kirim,
                        "alasan" => $request->alasan,
                        "stat" => "kirim",
                        "tgl_kirim" => Carbon\Carbon::now()
                    ]);
                    return redirect('/rnd/order')->with('alert','Selamat pengiriman berhasil');
                }
            }
            
            if($request->jumlah_kirim == "")
            {
                $cek = $request->jumlah_kirim_serving * $request->serving_size;
                if($stok->stok_rnd < $cek)
                {
                    return redirect()->back()->with('kirim','Maaf stok Anda tidak mencukupi untuk melakukan pengiriman');
                }
                elseif($stok->status_rnd =='kadaluarsa'){
                    return redirect()->back()->with('kirim','Maaf stok Anda kadaluarsa sehingga tidak bisa melakukan pengiriman');
                }
                elseif($stok->status_rnd =='habis'){
                    return redirect()->back()->with('kirim','Maaf stok Anda habis sehingga tidak bisa melakukan pengiriman');
                }
                else{
                    $cek = $request->jumlah_kirim_serving * $request->serving_size;
                    $stok_rnd = $stok->stok_rnd - $cek;
                
                    $standar = DB::table('standar')->where('id_standar',$request->standar_id)->update([
                        'stok_rnd' => $stok_rnd,
                        'kondisi' => 'proses_kirim'
                    ]);
                    DB::table('order')->where('id_order',$request->order_id)->update([
                        "pengirim" => Auth::user()->nama,
                        "jumlah_kirim" => $cek,
                        "alasan" => $request->alasan,
                        "stat" => "kirim",
                        "tgl_kirim" => Carbon\Carbon::now()
                    ]);
                
                    return redirect('/rnd/order')->with('alert','Selamat pengiriman berhasil');
                }
            }
            
        }
    }

    public function proses_order_unrequest(Request $request)
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
         
        $stokRND = DB::table('standar')->select('stok_rnd','status_rnd')->where('id_standar',$request->standar_id)->get();
         
        foreach($stokRND as $stok)
        {
            if($request->jumlah_kirim_gram !="")
            {
                if($stok->stok_rnd < $request->jumlah_kirim_gram)
                {
                    return redirect()->back()->with('kirim','Maaf stok Anda tidak mencukupi untuk melakukan pengiriman');
                }
                elseif($stok->status_rnd =='kadaluarsa'){
                   return redirect()->back()->with('kirim','Maaf stok Anda kadaluarsa sehingga tidak bisa melakukan pengiriman');
                }
                elseif($stok->status_rnd =='habis'){
                   return redirect()->back()->with('kirim','Maaf stok Anda habis sehingga tidak bisa melakukan pengiriman');
                }
                else{
                    $stok_rnd = $stok->stok_rnd - $request->jumlah_kirim_gram;
                
                    $standar = DB::table('standar')->where('id_standar',$request->standar_id)->update([
                        'stok_rnd' => $stok_rnd
                    ]);
                    DB::table('order')->where('id_order',$request->order_id)->update([
                        "pemohon" => '-',
                        "pengirim" => Auth::user()->nama,
                       "jumlah_kirim" => $request->jumlah_kirim_gram,
                       "jumlah_pesan" => 0,
                       "alasan" => $request->alasan,
                       "stat" => "kirim_unrequest",
                       "tgl_kirim" => Carbon\Carbon::now(),
                       "tgl_order" => Carbon\Carbon::now()
                   ]);
                   return redirect('/rnd/order/unrequest')->with('alert','Selamat pengiriman berhasil');
                }
            }
            
            else if($request->jumlah_kirim_gram =="")
            {
                $cek = $request->jumlah_kirim_serving * $request->serving_size;
                if($stok->stok_rnd < $cek)
                {
                    return redirect()->back()->with('kirim','Maaf stok Anda tidak mencukupi untuk melakukan pengiriman');
                }
                elseif($stok->status_rnd =='kadaluarsa'){
                   return redirect()->back()->with('kirim','Maaf stok Anda kadaluarsa sehingga tidak bisa melakukan pengiriman');
                }
                elseif($stok->status_rnd =='habis'){
                   return redirect()->back()->with('kirim','Maaf stok Anda habis sehingga tidak bisa melakukan pengiriman');
                }
                else{
                  
                    $cek = $request->jumlah_kirim_serving * $request->serving_size;
                    $stok_rnd = $stok->stok_rnd - $cek;
                    $standar = DB::table('standar')->where('id_standar',$request->standar_id)->update([
                        'stok_rnd' => $stok_rnd
                    ]);
                    DB::table('order')->where('id_order',$request->order_id)->update([
                        "pemohon" => '-',
                        "pengirim" => Auth::user()->nama,
                        "jumlah_kirim" => $cek,
                        "jumlah_pesan" => 0,
                        "alasan" => $request->alasan,
                        "stat" => "kirim_unrequest",
                        "tgl_kirim" => Carbon\Carbon::now(),
                        "tgl_order" => Carbon\Carbon::now()
                   ]);
                   return redirect('/rnd/order/unrequest')->with('alert','Selamat pengiriman berhasil');
                }
            }
        }
    }

    public function order_terkirim_hapus($id)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        DB::table('order')->where('id_order',$id)->delete();
        return view('/order_unrequest');
    }

    public function lokasi()
    {
        if(Auth::user()->work_center != 'RND'){
            return redirect()->back();
        }
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();   
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->get();

        return view('/rnd/standar_lokasi',compact('standar','pesan1','pesan2','pesan3','pesan4','order_rnd','order_diterima_rnd'));
    }

    public function ubah_ke_freeze(Request $request)
    {
       
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $standar = DB::table('standar')->where('id_standar',$request->id_standar)->update([
            'freeze' => 'Y'
        ]);
        $info = "Data". " ". $request->nama_item. " ". "telah berhasil di freeze";
        return redirect()->back()->with('freeze', $info);
    }

    public function unfreeze($id)
    {
        $standar = DB::table('standar')->where('id_standar',$id)->update([
            'freeze' => 'N'
        ]);
        
        return redirect()->back()->with('alert',"Data standar telah berhasil di unfreeze");
    }

    public function standar_freeze_edit($id)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
       $hitungOrderSendiri = DB::table('order')->where('pemohon',Auth::user()->nama . "_". Auth::user()->work_center . "_". Auth::user()->plant. "_" . Auth::user()->email)->get()->where('stat','!=','batal')->where('stat','!=','kirim')->where('stat','!=','order_diterima')->where('stat','!=','selesai')->where('stat','!=','keranjangrd')->where('stat','!=','kirim_unrequest');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $tb_jenis_item = DB::table('tb_jenis_item')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $tb_satuan = DB::table('tb_satuan')->get();
        $tb_plant = DB::table('tb_plant')->get();
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')->where('id_standar',$id)->get();
        return view('/rnd/standar_freeze_edit',compact('standar','order_qc','pesan1','pesan2','pesan3','pesan4','tb_satuan','order_diterima_qc','tb_plant','tb_sub_kategori','tb_jenis_item','order_rnd','order_diterima_rnd'));
    }

    public function standar_freeze_update(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        if($request->sub_kategori == "")
        {
            DB::table('standar')->where('id_standar',$request->id_standar)->update([
                'nama_item' => $request->nama_item,
                'kode_formula' => $request->kode_formula,
                'kode_oracle' => $request->kode_oracle,
                'kode_revisi_formula' => $request->kode_revisi_formula,
                'nolot' =>$request->nolot,
                'kategori_sub_id' => 1,
                'jenis_item_id' => $request->jenis_item,
                'lokasi' => $request->lokasi,
                'umur_simpan' => $request->umur_simpan,
                'plant_id' => $request->plant,
                'tgl_dibuat' => $request->tgl_dibuat,
                'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'serving_size' => $request->serving_size,
                'stok_rnd' => $request->stok_rnd,
                'satuan_id' => $request->satuan,
                'pembuat' => $request->pembuat,
            ]);
        }
       
        else{
            DB::table('standar')->where('id_standar',$request->id_standar)->update([
                'nama_item' => $request->nama_item,
                'kode_formula' => $request->kode_formula,
                'kode_oracle' => $request->kode_oracle,
                'kode_revisi_formula' => $request->kode_revisi_formula,
                'nolot' => $request->nolot,
                'kategori_sub_id' => $request->sub_kategori,
                'jenis_item_id' => $request->jenis_item,
                'lokasi' => $request->lokasi,
                'umur_simpan' => $request->umur_simpan,
                'plant_id' => $request->plant,
                'tgl_dibuat' => $request->tgl_dibuat,
                'tgl_kadaluarsa_rnd' => $request->tgl_kadaluarsa_rnd,
                'tempat_penyimpanan' => $request->tempat_penyimpanan,
                'serving_size' => $request->serving_size,
                'stok_rnd' => $request->stok_rnd,
                'satuan_id' => $request->satuan,
                'pembuat' => $request->pembuat,
            ]);
        }
       
        $nama_item = 'Data'. ' '. $request->nama_item. " ". 'Berhasil Diubah';
        return redirect('/rnd/standar/freeze')->with('alert',$nama_item);
    }

    public function standar_baku()
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','pesan')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $tb_satuan = DB::table('tb_satuan')->get();
        $standar = DB::table('standar')
        ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
        ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
        ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
        ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
        ->where('jenis_item','Baku')
        ->orderBy('nama_item','asc')->get();
        
        return view('/rnd/standar_baku',compact('standar','pesan1','pesan2','pesan3','pesan4','order_qc','order_diterima_qc','tb_satuan','order_rnd','order_diterima_rnd'));
    }

    public function cari_standar_baku(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();
        
        $order = DB::table('order')->where('pemohon_id',auth::user()->id)->where('stat','keranjang')->orWhere('stat','pesan');
        
        $standar = DB::table('standar')
            ->join('tb_sub_kategori', function ($join) {
                $join->on('standar.kategori_sub_id', '=', 'tb_sub_kategori.id_sub_kategori')
                ->where('jenis_item_id','2')
                ->where('freeze','N');
            })
            ->join('tb_plant', function ($join) {
                $join->on('standar.plant_id', '=', 'tb_plant.id_plant');
            })
            ->join('tb_satuan', function ($join) {
                $join->on('standar.satuan_id', '=', 'tb_satuan.id_satuan');
            })
            ->when($request->keyword,function ($query) use ($request) {
                $query
                ->where('nama_item', 'like', "%{$request->keyword}%")
                ->orWhere('kode_oracle', 'like', "%{$request->keyword}%");
            })->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('keyword'));
   
        return view('/rnd/standar_baku', compact('standar','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd'));
    }

    public function cari_stok_baku(Request $request)
    {
        if(Auth::user()->work_center == 'QC'){
            return redirect()->back();
        }
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $order_qc = DB::table('order')->where('stat','order')->orWhere('stat','keranjang');
        $order_diterima_qc = DB::table('order')->where('stat','kirim')->orWhere('stat','kirim_unrequest')->get();

        $standar = DB::table('standar')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('jenis_item_id','2')->where('freeze','N')->when($request->stok,function ($query) use ($request) {
            $query->where('status_rnd', 'like', "%{$request->stok}%");
            })->paginate($request->limit ?  $request->limit : 10);
        $standar->appends($request->only('stok'));
   
        return view('/rnd/standar_baku',compact('standar','order_qc','order_diterima_qc','order_rnd','order_diterima_rnd'));
    }

    // public function postImport()
    // {
    //     Excel::load(Input::file('standar'),function($reader){
    //         $reader->each(function($sheet){
    //             Customer::firstOrCreate($sheet->toArray());
    //         });
    //     });
    //     return back();
    // }

    // public function deleteAll()
    // {
    //     DB::table('standar')->delete();
    //     return back();
    // }

    public function history()
    {
       if(Auth::user()->work_center != 'RND'){
           return redirect()->back();
       }
       $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
       $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
       $hitung = DB::table('history')
            ->leftjoin('standar','history.standar_id','=','standar.id_standar')
            ->leftjoin('users','history.users_id','=','users.id')->orderBy('id_history','desc')
            ->get();
       $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
       $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
       $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
       $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();    
       $history = DB::table('history')
            ->leftjoin('standar','history.standar_id','=','standar.id_standar')
            ->leftjoin('users','history.users_id','=','users.id')->orderBy('id_history','desc')
            ->get();
       return view('/rnd/history')->with([
        'order_diterima_rnd' => $order_diterima_rnd,
        'order_rnd' => $order_rnd,
        'pesan1' => $pesan1,
        'pesan2' => $pesan2,
        'pesan3' => $pesan3,
        'pesan4' => $pesan4,
        'hitung' => $hitung,
        'history' => $history
       ]);
    }

    // public function show(Request $request,$id)
    //     {
    //         $blog = TbBlog::find($id);
    //         return view('site.show',compact('blog'))->renderSections()['content'];
    //     }

    public function cari_tanggal(Request $request)
    {
    
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        $history = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
            ->leftjoin('users','history.users_id','=','users.id')->when($request->dari_tanggal,function ($query) use ($request) {
                $dari_tanggal = $request->dari_tanggal;
                $ke_tanggal = $request->ke_tanggal;   
                $query->where('aktifitas','like',"%{$request->aktifitas}%")
            ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
            })->paginate($request->limit ?  $request->limit : 3);
        $history->appends($request->only('aktifitas','dari_tanggal','ke_tanggal'));
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $hitungJumlah = DB::table('history')->leftjoin('standar','history.standar_id','=','standar.id_standar')
            ->leftjoin('users','history.users_id','=','users.id')->when($request->dari_tanggal,function ($query) use ($request) {
            $dari_tanggal = $request->dari_tanggal;
            $ke_tanggal = $request->ke_tanggal;   
            $query->where('aktifitas','like',"%{$request->aktifitas}%")
            ->whereBetween('tgl',[$dari_tanggal,$ke_tanggal]);
        });
        return view('/rnd/history', compact('history','order_qc','pesan1','pesan2','pesan3','pesan4','order_diterima_qc','standar','order_rnd','order_diterima_rnd','hitungJumlah'));

    }
    
    public function cetaklabel(){
        $standar = DB::table('standar')
            ->leftjoin('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->leftjoin('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->leftjoin('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')->where('jenis_item_id','1')
            ->where('freeze','N')->where('jenis_item_id','1')->orderBy('nama_item','ASC')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        return view('rnd.cetak_label')->with([
            'standar' => $standar,
            'order_rnd' => $order_rnd,
            'pesan1' => $pesan1,
            'pesan2' => $pesan2,
            'pesan3' => $pesan3,
            'pesan4' => $pesan4,
            'order_diterima_rnd' => $order_diterima_rnd,
            'tb_sub_kategori' => $tb_sub_kategori
        ]);
    }

    public function cetaklabelBB(){
        $standar = DB::table('standar')
            ->join('tb_sub_kategori','standar.kategori_sub_id','=','tb_sub_kategori.id_sub_kategori')
            ->join('tb_jenis_item','standar.jenis_item_id','=','tb_jenis_item.id_jenis_item')
            ->join('tb_plant','standar.plant_id','=','tb_plant.id_plant')
            ->join('tb_satuan','standar.satuan_id','=','tb_satuan.id_satuan')
            ->where('freeze','N')->where('jenis_item','Baku')
            ->orderBy('nama_item','asc')->get();
        $pesan4 = DB::table('tb_notification')->where('subject','=','menambah stok bahan baku')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan1 = DB::table('tb_notification')->where('subject','=','QC memakai std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan2 = DB::table('tb_notification')->where('subject','=','QC Memesan std')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $pesan3 = DB::table('tb_notification')->where('subject','=','telah diterima')->join('users','users.id','=','tb_notification.id_user')->join('standar','standar.id_standar','=','tb_notification.id_standar')->get();
        $tb_sub_kategori = DB::table('tb_sub_kategori')->get();
        $order_diterima_rnd = DB::table('order')->where('stat','pesan')->orWhere('stat','kirim');
        $order_rnd = DB::table('order')->where('stat','keranjangrd')->orWhere('stat','kirim_unrequest');
        return view('rnd.cetak_label_baku')->with([
            'standar' => $standar,
            'order_rnd' => $order_rnd,
            'pesan1' => $pesan1,
            'pesan2' => $pesan2,
            'pesan3' => $pesan3,
            'pesan4' => $pesan4,
            'order_diterima_rnd' => $order_diterima_rnd,
            'tb_sub_kategori' => $tb_sub_kategori
        ]);
    }
}