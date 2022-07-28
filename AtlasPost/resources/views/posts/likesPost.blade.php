@extends('layouts.set')

@include('layouts.post_likes')

@section('content')
<table class='posts'>
  @foreach($reviews as $items)
  @if ($items->isLikedBy(Auth::user()))
  <tr class='post'>
    <td class='tops'>
      <div class='top'>
        {{$items->user->username}}さん
        {{$items->created_at}}
        {{$count}}View
      </div>
      <div class='top'>
        {{$items->title}}
      </div>
      <div class='top'>
        <div class="sub_category">
          {{$items->PostSubCategory->sub_category}}
        </div>
        コメント数{{$items->getCountAmount($items->id)}}
        @if (!$items->isLikedBy(Auth::user()))
        <i class="fa-solid fa-heart like-toggle" data-post_id="{{ $items->id }}"></i>
        <span class="like-counter">{{$items->likes_count}}</span>
        @else
        <i class="fa-solid fa-heart heart like-toggle liked" data-post_id="{{ $items->id }}"></i>
        <span class="like-counter">{{$items->likes_count}}</span>
        @endif
        @endif
      </div>
    </td>
  </tr>
  @endforeach
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endsection
