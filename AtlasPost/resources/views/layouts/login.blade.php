<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
    <!-- <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }} "> -->
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>

<body>
    <header>
        @yield('post')
        @yield('category')
        @yield('post_new')
        @yield('post_detail')
        @yield('post_edit')
        @yield('post_comment')
        @yield('mypost')
        @yield('post_likes')
    </header>
    <div id="row">
        <div id="container">
            @yield('content')
        </div>
        <div id="side-bar">
            <table class="topTable">
                <tr>
                    <td class="side">
                        @can('admin')
                        <a href="/category" class="a-category">カテゴリーを追加</a>
                        @endcan
                    </td>
                    <td class="side">
                        <a href="/post_new" class="a-side">投稿</a>
                    </td>
                    <td class="side">
                        <form action="/top" method="post">
                            {{ csrf_field()}}
                            {{method_field('get')}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword">
                                <button type="submit" class="btn btn-primary">検索</button>
                            </div>
                        </form>
                    </td>
                    <td class="side">
                        <a href="/post_likes" class="a-side">いいねした投稿</a>
                    </td>
                    <td class="side">
                        <a href="/mypost" class="a-side">自分の投稿</a>
                    </td>
                    <td class="category">
                        <div class="title">
                            <p>カテゴリー</p>
                        </div>
                        @foreach($tables as $items)
                        <div class="mainCategory">
                            {{$items->main_category}}
                        </div>
                        @foreach($items->subs as $subs)
                        <div class="subCategory">
                            <a href="/top/{{$subs->id}}" style="display: flex;color: black;">{{$subs->sub_category}}</a>
                        </div>
                        @endforeach
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/commentLike.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/like.js') }}"></script>
</body>

</html>
