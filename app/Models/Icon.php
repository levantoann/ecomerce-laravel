<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    public $timestamps = false;
    protected $fillable = [ 
     "name","image",'link'
    ];
    protected $primaryKey = 'id_icons';
    protected $table = 'tbl_icons';
 
}
