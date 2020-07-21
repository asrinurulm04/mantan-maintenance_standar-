<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{

    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    public function form()
    {
        $tb_bagian = DB::table('tb_bagian')->where('status','aktif')->get();
        $tb_plant = DB::table('tb_plant')->where('status','aktif')->get();
        $users = DB::table('users')->join('tb_bagian','users.id','=','tb_bagian.id_bagian')->get();
        return view('signup',compact('users','tb_bagian','tb_plant'));
    }

    public function signup(Request $request)
    {
        // validate request data
        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'work_center' => ['required', 'string'],
            'bagian' => ['required'],
            'plant' => ['required'],
        ]);


        // save into table 
        $user = User::create([
            'bagian_id' => $request['bagian'] ,
            'nama' => $request['nama'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => bcrypt($request->password),
            'work_center' => $request['work_center'] ,
            'plant' => $request['plant'] ,
        ]);
        return redirect('/login')->with('alert','Pendaftaraan berhasil, tunggu akun Anda dikonfirmasi.');

    }
    public function success()
    {
        return view('/auth/success');
    }
}
