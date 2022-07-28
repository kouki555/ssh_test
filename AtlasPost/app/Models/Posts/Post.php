<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\PostFavorite;
use App\Models\Posts\PostComment;
use DB;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'post_sub_category_id',
        'delete_user_id',
        'update_user_id',
        'title',
        'post',
        'event_at',
    ];

    //timestamps利用しない
    public $timestamps = false;


    //hasMany設定
    public function PostSubCategory()
    {
        return $this->belongsTo('App\Models\Posts\PostSubCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Posts\PostFavorite');
    }


    //後でViewで使う、いいねされているかを判定するメソッド。
    public function isLikedBy($user): bool
    {
        return PostFavorite::where('user_id', $user->id)->where('post_id', $this->id)->first() !== null;
    }
    // コメント数
    public function getCountAmount($post_id)
    {
        return PostComment::where('post_id', $post_id)->count();
    }
    // View
    public function getCountAction($post_id)
    {
        return DB::table('action_logs')->where('post_id', $post_id)->count('user_id');
    }
}
