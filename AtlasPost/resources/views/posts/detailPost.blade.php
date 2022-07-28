@extends('layouts.set')

@include('layouts.post_detail')

@section('content')
<table class='detailPosts'>
  @foreach($reviews as $items)
  <tr>
    <td class='detail'>
      {{$items->user->username}}さん
      {{$items->created_at}}
      <div class="count">
        {{$action}}View
      </div>
    </td>
    <td class='detail'>
      <div class="detail-min">
        <p class="detailTitle" style="font-size: 18px; display: inline-block;">
          {{$items->title}}
        </p>
        <a href="/post_edit/{{$items->id}}" class="edit">編集</a>
      </div>
    </td>
    <td class='detail'>
      <p class="detailPost" style="margin-bottom: 10px;">
        {{$items->post}}
      </p>
    </td>
    <td class='detail'>
      <div class="sub_category">
        {{$items->PostSubCategory->sub_category}}
      </div>
      <div class="detail-max">
        コメント数{{$items->getCountAmount($items->id)}}
        @if (!$items->isLikedBy(Auth::user()))
        <i class="fa-solid fa-heart like-toggle" data-post_id="{{ $items->id }}"></i>
        <span class="like-counter">{{$items->likes_count}}</span>
        @else
        <i class="fa-solid fa-heart heart like-toggle liked" data-post_id="{{ $items->id }}"></i>
        <span class="like-counter">{{$items->likes_count}}</span>
      </div>
    </td>
    @endif
  </tr>
  @endforeach
</table>
<table class='commentPosts'>
  @foreach($likes as $items)
  <tr class="commentPost">
    <td class='detail'>
      {{$items->user->username}}さん
      {{$items->created_at}}
      <a href="/post_comment/{{$items->id}}" class="edit-comment">編集</a>
    </td>
    <td class='detail'>
      {{$items->comment}}
    </td>
    <td class="favorite">
      @if (!$items->isLikedBy(Auth::user()))
      <i class="fa-solid fa-heart likes-toggle" data-post_comment_id="{{ $items->id }}"></i>
      <span class="like-counter">{{$items->comment_likes_count}}</span>
      @else
      <i class="fa-solid fa-heart heart likes-toggle liked" data-post_comment_id="{{ $items->id }}"></i>
      <span class="like-counter">{{$items->comment_likes_count}}</span>
    </td>
    @endif
    @endforeach
  </tr>

  {!! Form::open(['url' => '/post_detail'.$id]) !!}

  <td class='detail'>
    @if ($errors->has('comment'))
    <li>{{$errors->first('comment')}}</li>
    @endif
    {{ Form::textarea('comment',null,['class' => 'comment-text','placeholder' => 'コチラからコメントできます','rows' => '3']) }}
  </td>
  <td class='detail'>
    {{ Form::submit('コメント',['class' => 'btn btn-primary', 'style' => 'margin-left: 370px;']) }}
  </td>
  {!! Form::close() !!}
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endsection
