<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $table = 'post_comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'delete_user_id',
        'update_user_id',
        'comment',
        'event_at',
    ];

    public function commentLikes()
    {
        return $this->hasMany('App\Models\Posts\PostCommentFavorite');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    //後でViewで使う、いいねされているかを判定するメソッド。
    public function isLikedBy($user): bool
    {
        return PostCommentFavorite::where('user_id', $user->id)->where('post_comment_id', $this->id)->first() !== null;
    }
    // コメント数
    public function getCountAmount($post_id)
    {
        return PostComment::where('post_id', $post_id)->count();
    }
}
