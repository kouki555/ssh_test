<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as PostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Posts\PostMainCategory;
use App\Models\Posts\PostSubCategory;

class PostMainCategoriesController extends Controller
{


    protected function mainValidator(array $main)
    {
        return Validator::make($main, [
            'main_category' => 'required|max:100|string|unique:post_main_categories',
        ]);
    }

    protected function subValidator(array $sub)
    {
        return Validator::make($sub, [
            'post_main_category_id' => 'required|exists:post_main_categories,id',
            'sub_category' => 'required|max:100|string|unique:post_sub_categories',
        ]);
    }


    protected function mainCreate($main)
    {
        return PostMainCategory::create([
            'main_category' => $main,
        ]);
    }

    protected function subCreate($sub, $category_id)
    {
        return PostSubCategory::create([
            'post_main_category_id' => $category_id,
            'sub_category' => $sub,
        ]);
    }

    public function category(Request $request)
    {
        if ($request->isMethod('post')) {
            $main = $request->input();
            $sub = $request->input();

            if (PostRequest::input('register1')) {
                $validator = $this->mainValidator($main);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $main = $request->input('main_category');
                    //dd($main);
                    $this->mainCreate($main);
                    return redirect('/category');
                }
            } elseif (PostRequest::input('register2')) {
                $validator = $this->subValidator($sub);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $sub = $request->input('sub_category', 'post_main_categories');
                    $category_id = PostRequest::input('category');
                    //    dd($category_id);
                    $this->subCreate($sub, $category_id);
                    return redirect('/category');
                }
            }
        }
        $main = \DB::table('post_main_categories')->get();
        $tables = PostMainCategory::with('subs')->get();
        // dd($posts);
        return view('posts.newCategory', [
            'main'      => $main,
            'tables'     => $tables,
        ]);
    }

    public function mainDelete($id)
    {
        \DB::table('post_main_categories')
            ->where('id', $id)
            ->delete();

        return redirect()->route('posts.category');
    }

    public function subDelete($id)
    {
        \DB::table('post_sub_categories')
            ->where('id', $id)
            ->delete();

        return redirect()->route('posts.category');
    }
}
