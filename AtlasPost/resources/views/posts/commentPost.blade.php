@extends('layouts.set')

@include('layouts.post_comment')

@section('content')
<table class="newPost">
  <tr>
    {!! Form::open(['url' => '/post_comment'.$id]) !!}

    @foreach($likes as $items)
    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('コメント') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('comment'))
        <li>{{$errors->first('comment')}}</li>
        @endif
        {{ Form::textarea('comment', $items->comment,['rows' => '3']) }}
      </div>
      <div class="new">
        {{ Form::submit('更新',['class' => 'register2']) }}
      </div>
      <div class="new">
        <a class="register3" href="/{{$items->id}}/commentDelete" onclick="return confirm('このレコードを削除します。よろしいでしょうか？')">削除</a>
      </div>
    </td>
    @endforeach

    {!! Form::close() !!}
  </tr>
</table>

@endsection
