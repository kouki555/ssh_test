<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Posts\Post;
use App\Models\Posts\PostSubCategory;
use Request as PostRequest;

class PostsController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'post_sub_category_id' => 'required|exists:post_sub_categories',
            'title' => 'required|max:100|string|',
            'post' => 'required|max:5000|string|',
        ]);
    }

    protected function create($post_sub_category_id, $title, $post)
    {
        return Post::create([
            'user_id' => Auth::id(),
            'event_at' => Carbon::now('Asia/Tokyo'),
            'post_sub_category_id' => $post_sub_category_id,
            'title' => $title,
            'post' => $post,
        ]);
    }

    public function post(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            $validator = $this->validator($data);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $post = $request->input('post');
                $title = $request->input('title');
                $post_sub_category_id = PostRequest::input('subcategory');
                //dd($main);
                $this->create($post_sub_category_id, $title, $post);
                $posts = \DB::table('posts')->get();
                $sub_category = $request->input('subcategory');
                return redirect('/top')->with([
                    'posts' => $posts,
                    'sub_category' => $sub_category,
                ]);
            }
        }
        $sub_category = \DB::table('post_sub_categories')->get();
        return view('posts.newPost', [
            'sub_category'      => $sub_category,
        ]);
    }

    public function editPost(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            $validator = $this->validator($data);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $post = $request->input('post');
                \DB::table('posts')
                    ->where('id', $id)
                    ->update(
                        ['post' => $post]
                    );

                $title = $request->input('title');
                \DB::table('posts')
                    ->where('id', $id)
                    ->update(
                        ['title' => $title]
                    );

                $post_sub_category_id = PostRequest::input('subcategory');
                \DB::table('posts')
                    ->where('id', $id)
                    ->update(
                        ['post_sub_category_id' => $post_sub_category_id]
                    );
                return redirect()->route('detail', ['id' => $id]);
            }
        }
        $posts = Post::with('PostSubCategory')->get();
        // dd($posts);
        $users = Post::with('user')->get();
        //  dd($users);
        $reviews = Post::withCount('likes')->where('id', $id)->get();
        //  dd($reviews);
        $sub = \DB::table('post_sub_categories')->get();
        // dd($sub);
        return view('posts.editPost', [
            'users'      => $users,
            'posts'      => $posts,
            'reviews'      => $reviews,
            'id'      => $id,
            'sub'      => $sub,
        ]);
    }

    public function editDelete($id)
    {
        \DB::table('posts')
            ->where('id', $id)
            ->delete();

        return redirect('/top');
    }
}
