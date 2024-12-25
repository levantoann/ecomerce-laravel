<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
    public $timestamps = false;
   protected $fillable = [ 
    "product_name","product_slug","category_id","brand_id","product_desc","product_content","product_price","product_image",
    "product_status","product_tags"
   ];
   protected $primaryKey = 'product_id';
   protected $table = 'tbl_product';

   public function comment(){
    return $this->hasMany(Comment::class, 'comment_product_id');
}
public function category(){
    return $this->belongsTo(CategoryProductModel::class, 'category_id');
}
}
