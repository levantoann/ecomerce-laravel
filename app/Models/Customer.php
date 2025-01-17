<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;
    protected $fillable = [ 
     "customer_id","customer_email","customer_phone","customer_password","customer_picture","customer_name","customer_token"
    ];
    protected $primaryKey = 'customer_id';
    protected $table = 'tbl_customers';

    
}
