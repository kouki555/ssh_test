<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts\PostCommentFavorite;
use App\Models\Posts\PostComment;

class PostCommentFavoritesController extends Controller
{
    public function likes(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $post_comment_id = $request->post_comment_id; //2.コメントidの取得
        $already_liked = PostCommentFavorite::where('user_id', $user_id)->where('post_comment_id', $post_comment_id)->first(); //3.

        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $like = new PostCommentFavorite; //4.PostCommentFavoriteクラスのインスタンスを作成
            $like->post_comment_id = $post_comment_id; //PostCommentFavoriteインスタンスにpost_comment_id,user_idをセット
            $like->user_id = $user_id;
            $like->save();
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            PostCommentFavorite::where('post_comment_id', $post_comment_id)->where('user_id', $user_id)->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $review_comment_likes_count = PostComment::withCount('commentLikes')->findOrFail($post_comment_id)->comment_likes_count;
        $param = [
            'review_comment_likes_count' => $review_comment_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
}
