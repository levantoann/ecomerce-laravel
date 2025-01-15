<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialCustomers extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'provider_user_id','provider','provider_user_email','user'
    ];

    protected $primaryKey = 'user_id';
    protected $table = 'tbl_social_customers';
    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'user', 'customer_id');
    }
}
