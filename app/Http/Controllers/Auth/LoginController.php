<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function username()
    {
    return 'username';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function cekuser()
    // {
    //     @if(Auth::user()->work_center =='ADMIN')
    //     redirect('/admin/data/standar')
                           
    //                     @elseif(Auth::user()->work_center == 'RND')
                           
    //     redirect('/rnd/data/standar')
    //                     @elseif(Auth::user()->work_center == 'QC')
                           
    //     redirect('/qc/stok/standar')
    //                     @endif
    // }

}
