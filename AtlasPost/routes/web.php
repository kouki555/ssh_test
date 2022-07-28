<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//ログアウト中のページ
Route::get('/login', 'Auth\Login\LoginController@login')->name('login');
Route::post('/login', 'Auth\Login\LoginController@login');

Route::get('/register', 'Auth\Register\RegisterController@register');
Route::post('/register', 'Auth\Register\RegisterController@register');

Route::get('/added', 'Auth\Register\RegisterController@added');
Route::post('/added', 'Auth\Register\RegisterController@added');


//ログイン中のページ
Route::get('/top/{id}', 'User\Post\PostsController@index');
Route::get('/top', 'User\Post\PostsController@index')->name('posts.index');
Route::post('/top', 'User\Post\PostsController@index')->name('posts.index');

Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/category', 'Admin\Post\PostMainCategoriesController@category')->name('posts.category');
    Route::post('/category', 'Admin\Post\PostMainCategoriesController@category');
    Route::get('/{id}/mainDelete', 'Admin\Post\PostMainCategoriesController@mainDelete');
    Route::get('/{id}/subDelete', 'Admin\Post\PostMainCategoriesController@subDelete');
});

Route::get('/post_new', 'Admin\Post\PostsController@post');
Route::post('/post_new', 'Admin\Post\PostsController@post');

Route::post('/like', 'User\Post\PostFavoritesController@like');
Route::post('/likes', 'User\Post\PostCommentFavoritesController@likes');

Route::get('/post_likes', 'User\Post\PostsController@likesPost');

Route::get('/mypost', 'User\Post\PostsController@myPost');

Route::get('/post_detail/{id}', 'User\Post\PostsController@detailPost')->name('detail');
Route::post('/post_detail{id}', 'User\Post\PostsController@detailPost');

Route::get('/post_edit/{id}', 'Admin\Post\PostsController@editPost');
Route::post('/post_edit{id}', 'Admin\Post\PostsController@editPost');
Route::get('/{id}/editDelete', 'Admin\Post\PostsController@editDelete');

Route::get('/post_comment/{id}', 'User\Post\PostsController@commentPost');
Route::post('/post_comment{id}', 'User\Post\PostsController@commentPost');
Route::get('/{id}/commentDelete', 'User\Post\PostsController@commentDelete');

Route::get('/logout', 'User\Post\PostsController@getLogout')->name('logout');
