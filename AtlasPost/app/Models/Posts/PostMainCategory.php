<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostMainCategory extends Model
{
    protected $table = 'post_main_categories';

    protected $fillable = [
        'main_category',
    ];

    //timestamps利用しない
    public $timestamps = false;

    //primaryKeyの変更
    protected $primaryKey = "id";

    //hasMany設定
    public function subs()
    {
        return $this->hasMany('App\Models\Posts\PostSubCategory');
    }
}
