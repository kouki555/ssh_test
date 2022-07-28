<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts\PostFavorite;
use App\Models\Posts\Post;

class PostFavoritesController extends Controller
{


public function like(Request $request)
{
    $user_id = Auth::user()->id; //1.ログインユーザーのid取得
    $post_id = $request->post_id; //2.投稿idの取得
    $already_liked = PostFavorite::where('user_id', $user_id)->where('post_id', $post_id)->first(); //3.

    if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
        $like = new PostFavorite; //4.PostFavoriteクラスのインスタンスを作成
        $like->post_id = $post_id; //PostFavoriteインスタンスにpost_id,user_idをセット
        $like->user_id = $user_id;
        $like->save();
    } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
        PostFavorite::where('post_id', $post_id)->where('user_id', $user_id)->delete();
    }
    //5.この投稿の最新の総いいね数を取得
    $review_likes_count = Post::withCount('likes')->findOrFail($post_id)->likes_count;
    $param = [
        'review_likes_count' => $review_likes_count,
    ];
    return response()->json($param); //6.JSONデータをjQueryに返す
}


}
