<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductModel extends Model
{
    public $timestamps = false;
    protected $fillable = [ 
     "meta_keywords","category_name","slug_category_product","category_desc","category_status","category_parent","category_order"
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';
 
    public function product(){
        return $this->hasMany(Product::class); // Dùng 'category_id' thay vì 'product_id'
    }
}
