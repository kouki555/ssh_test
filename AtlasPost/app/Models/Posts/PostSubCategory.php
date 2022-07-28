<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;

class PostSubCategory extends Model
{
    protected $table = 'post_sub_categories';

    protected $fillable = [
        'post_main_category_id',
        'sub_category',
    ];

    //timestamps利用しない
    public $timestamps = false;

    //primaryKeyの変更
    protected $primaryKey = "id";

    //hasMany設定
    public function posts()
    {
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function main()
    {
        return $this->belongsTo('App\Models\Posts\PostMainCategory');
    }

    // 対象のサブカテゴリーがあるかないか
    public function judgment($post_sub_category_id)
    {
        return Post::where('post_sub_category_id', $post_sub_category_id)->first() !== null;
    }
}
