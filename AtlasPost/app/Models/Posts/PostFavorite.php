<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostFavorite extends Model
{
    protected $table = 'post_favorites';

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user()
    {   //usersテーブルとのリレーションを定義するuserメソッド
        return $this->belongsTo('App\Models\Users\User');
    }

    public function post()
    {   //postsテーブルとのリレーションを定義するpostメソッド
        return $this->belongsTo('App\Models\Posts\Post');
    }

}
