<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
   protected $fillable = [ 
    "post_title","post_desc","post_content","post_meta_desc","post_meta_keyword","post_status","post_image","post_slug"
   ];
   protected $primaryKey = 'post_id';
   protected $table = 'tbl_posts';
   public function cate_post()
    {
        return $this->belongsTo(CategoryPostModel::class, 'cate_post_id', 'cate_post_id');
    }
}
