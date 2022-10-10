<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected  $table = 'countries';

    protected $fillable =['iso','iso3','iso_numeric','country_name','capital','continent_code','currency_code'];

}