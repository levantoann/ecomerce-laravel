<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silder extends Model
{
    public $timestamps = false;
   protected $fillable = [ 
    "slider_name","slider_status","slider_image","slider_desc"
   ];
   protected $primaryKey = 'slider_id';
   protected $table = 'tbl_slider';
}
