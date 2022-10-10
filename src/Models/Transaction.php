<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected  $table = 'transactions';

    protected $fillable =['account_id','amount','user_id','country_id','created_at','updated_at'];


    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

}