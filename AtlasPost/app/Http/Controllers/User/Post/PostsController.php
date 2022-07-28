<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostMainCategory;
use App\Models\ActionLogs\ActionLog;
use DB;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\PostFavorite;

class PostsController extends Controller
{

  protected function detailValidator(array $comment)
  {
    return Validator::make($comment, [
      'comment' => 'required|max:2500|string|',
    ]);
  }

  protected function detailCreate($post_id, $comment)
  {
    return PostComment::create([
      'user_id' => Auth::id(),
      'event_at' => Carbon::now('Asia/Tokyo'),
      'post_id' => $post_id,
      'comment' => $comment,
    ]);
  }

  protected function actionCreate($post_id)
  {
    return ActionLog::create([
      'user_id' => Auth::id(),
      'event_at' => Carbon::now('Asia/Tokyo'),
      'post_id' => $post_id,
    ]);
  }


  public function index(Request $request, $id, $file_name = "counter.txt")
  {
    if (file_exists($file_name)) {

      $handle = fopen($file_name, "r");
      $count = (int)fread($handle, 20) + 1;

      $handle = fopen($file_name, 'w');
      fwrite($handle, $count);

      fclose($handle);
    } else {
      $handle = fopen($file_name, "w+");

      $count = 1;

      fwrite($handle, $count);
      fclose($handle);
    }

    $posts = Post::with('PostSubCategory')->get();
    // dd($posts);
    $users = Post::with('user')->get();
    //  dd($users);
    $tables = PostMainCategory::with('subs')->get();

    $keyword = $request->keyword;
    if (!empty($keyword)) {
      $reviews = Post::withCount('likes')->Where('post', 'like', '%' . $keyword . '%')
        ->orWhere('title', 'like', '%' . $keyword . '%')
        ->orWhereHas('PostSubCategory', function ($query) use ($keyword) {
          $query->where('sub_category', $keyword);
        })->get();
      return view('posts.index', [
        'users'      => $users,
        'posts'      => $posts,
        'reviews'      => $reviews,
        'count'      => $count,
        'tables'      => $tables,
      ]);
    } elseif ($id != "counter.txt") {
      $reviews = Post::withCount('likes')->where('post_sub_category_id', $id)->orderBy('created_at', 'desc')->paginate(10);
    } else {
      $reviews = Post::withCount('likes')->orderBy('created_at', 'desc')->paginate(10);
    }
    return view('posts.index', [
      'users'      => $users,
      'posts'      => $posts,
      'reviews'      => $reviews,
      'count'      => $count,
      'tables'      => $tables,
    ]);
  }


  public function getLogout()
  {
    Auth::logout();
    return redirect()->route('login');
  }


  public function likesPost($file_name = "counter.txt")
  {

    if (file_exists($file_name)) {

      $handle = fopen($file_name, "r");
      $count = (int)fread($handle, 20);

      $handle = fopen($file_name, 'w');
      fwrite($handle, $count);

      fclose($handle);
    } else {
      $handle = fopen($file_name, "w+");

      $count = 1;

      fwrite($handle, $count);
      fclose($handle);
    }

    $posts = Post::with('PostSubCategory')->get();
    // dd($posts);
    $users = Post::with('user')->get();
    //  dd($users);
    $reviews = Post::withCount('likes')->orderBy('created_at', 'desc')->paginate(10);
    //  dd($reviews);

    return view('posts.likesPost', [
      'users'      => $users,
      'posts'      => $posts,
      'reviews'      => $reviews,
      'count'      => $count,
    ]);
  }


  public function myPost($file_name = "counter.txt")
  {

    if (file_exists($file_name)) {

      $handle = fopen($file_name, "r");
      $count = (int)fread($handle, 20);

      $handle = fopen($file_name, 'w');
      fwrite($handle, $count);

      fclose($handle);
    } else {
      $handle = fopen($file_name, "w+");

      $count = 1;

      fwrite($handle, $count);
      fclose($handle);
    }

    $posts = Post::with('PostSubCategory')->get();
    // dd($posts);
    $users = Post::with('user')->get();
    //  dd($users);
    $reviews = Post::withCount('likes')->orderBy('created_at', 'desc')->paginate(10);
    //  dd($reviews);

    return view('posts.myPost', [
      'users'      => $users,
      'posts'      => $posts,
      'reviews'      => $reviews,
      'count'      => $count,
    ]);
  }

  public function detailPost(Request $request, $id)
  {
    if ($request->isMethod('post')) {
      $comment = $request->input();
      $validator = $this->detailValidator($comment);

      if ($validator->fails()) {
        return back()
          ->withErrors($validator)
          ->withInput();
      } else {
        $post_id = $id;
        $comment = $request->input('comment');
        //dd($comment);
        $this->detailCreate($post_id, $comment);
        return redirect()->route('detail', ['id' => $id]);
      }
    }
    if (DB::table('action_logs')->where('post_id', $id)->where('user_id', Auth::id())->exists()) {
      $post_id = $id;
      $action = DB::table('action_logs')->where('post_id', $post_id)->count('user_id');
    } else {
      $post_id = $id;
      $this->actionCreate($post_id);
      $action = DB::table('action_logs')->where('post_id', $post_id)->count('user_id');
    }
    $posts = Post::with('PostSubCategory')->get();
    // dd($posts);
    $users = Post::with('user')->get();
    //  dd($users);
    $reviews = Post::withCount('likes')->where('id', $id)->get();
    // dd($reviews);

    $user = PostComment::with('user')->get();
    // dd($user);
    $likes = PostComment::withCount('commentLikes')->where('post_id', $id)->get();
    // dd($likes);

    return view('posts.detailPost', [
      'users'      => $users,
      'posts'      => $posts,
      'action'      => $action,
      'reviews'      => $reviews,
      'id'      => $id,
      'likes'      => $likes,
      'user'      =>  $user,
    ]);
  }

  public function commentPost(Request $request, $id)
  {
    if ($request->isMethod('post')) {
      $comment = $request->input();
      $validator = $this->detailValidator($comment);

      if ($validator->fails()) {
        return back()
          ->withErrors($validator)
          ->withInput();
      } else {
        $comments = $request->input('comment');
        \DB::table('post_comments')
          ->where('id', $id)
          ->update(
            ['comment' => $comments]
          );

        $post_id = PostComment::withCount('commentLikes')->where('id', $id)->pluck('post_id');
        // dd($post_id);
        $post = $post_id[0];
        // dd($post);
        return redirect()->route('detail', ['id' => $post]);
      }
    }
    $likes = PostComment::withCount('commentLikes')->where('id', $id)->get();
    // dd($likes);
    return view('posts.commentPost', [
      'likes'      => $likes,
      'id'      => $id,
    ]);
  }

  public function commentDelete($id)
  {
    \DB::table('post_comments')
      ->where('id', $id)
      ->delete();

    return redirect('/top');
  }
}
