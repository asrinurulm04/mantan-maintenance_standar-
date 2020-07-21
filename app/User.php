<?php

namespace App;
use App\Notifications\MailResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'id','bagian_id','nama','email', 'username', 'password','work_center','konfirmasi','plant',
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }
    public function bagian() {
        return $this->hasMany("App\Bagian", "id_bagian");
    }

    public function user() {
        return $this->hasOne("App\User", "id");
    }

    public function order()
    {
        return $this->belongsTo('App\Order','pemohon_id','id_order');
    }
  

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
