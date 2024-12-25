<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;
   protected $fillable = [ 
    "shipping_name","shipping_address","shipping_phone","shipping_notes","shipping_email","shipping_method"
   ];
   protected $primaryKey = 'shipping_id';
   protected $table = 'tbl_shipping';
}
