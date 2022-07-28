<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostCommentFavorite extends Model
{
    protected $table = 'post_comment_favorites';

    protected $fillable = [
        'user_id',
        'post_comment_id',
    ];

    public function user()
    {   //usersテーブルとのリレーションを定義するuserメソッド
        return $this->belongsTo('App\Models\Users\User');
    }

    public function comment()
    {   //postsテーブルとのリレーションを定義するpostメソッド
        return $this->belongsTo('App\Models\Posts\PostComment');
    }
}
