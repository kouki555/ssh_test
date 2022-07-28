@extends('layouts.set')

@include('layouts.post_edit')

@section('content')
<table class="newPost">
  <tr>

    {!! Form::open(['url' => '/post_edit'.$id]) !!}

    @foreach($reviews as $items)
    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('サブカテゴリー') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('subcategory'))
        <li>{{$errors->first('subcategory')}}</li>
        @endif
        <select name='subcategory' class="add-input">
          @foreach($sub as $item)
          <option value="{{ $item->id }}" selected>{{ $item->sub_category }}</option>
          @endforeach
        </select>
      </div>
    </td>
    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('タイトル') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('title'))
        <li>{{$errors->first('title')}}</li>
        @endif
        {{ Form::text('title', $items->title,['class' => 'add-input']) }}
      </div>
    </td>
    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('投稿内容') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('post'))
        <li>{{$errors->first('post')}}</li>
        @endif
        {{ Form::textarea('post',$items->post,['class' => 'post-input']) }}
      </div>
      <div class="new">
        {{ Form::submit('更新',['class' => 'register2']) }}
      </div>
      <div class="new">
        <a class="register3" href="/{{$items->id}}/editDelete" onclick="return confirm('このレコードを削除します。よろしいでしょうか？')">削除</a>
      </div>
    </td>
    @endforeach

    {!! Form::close() !!}
  </tr>
</table>
@endsection
