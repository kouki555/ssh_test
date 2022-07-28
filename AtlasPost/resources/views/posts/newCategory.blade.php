@extends('layouts.set')

@include('layouts.category')

@section('content')
<table class="addition">
  <tr>
    {!! Form::open(['url' => '/category']) !!}

    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('新規メインカテゴリー') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('main_category'))
        <li>{{$errors->first('main_category')}}</li>
        @endif
        {{ Form::text('main_category',null,['class' => 'add-input']) }}
      </div>
      <div class="new">
        {{ Form::submit('登録',array('name' => 'register1','class' => 'register')) }}
      </div>
    </td>
    <td class="add">
      <div class="new">
        <p class="label">
          {{ Form::label('メインカテゴリー') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('category'))
        <li>{{$errors->first('category')}}</li>
        @endif
        <select name='category' class="add-input">
          @foreach($main as $item)
          <option value="{{ $item->id }}">
            {{ $item->main_category }}
          </option>
          @endforeach
        </select>
      </div>
      <div class="new">
        <p class="label">
          {{ Form::label('新規サブカテゴリー') }}
        </p>
      </div>
      <div class="new">
        @if ($errors->has('sub_category'))
        <li>{{$errors->first('sub_category')}}</li>
        @endif
        {{ Form::text('sub_category',null,['class' => 'add-input']) }}
      </div>
      <div class="new">
        {{ Form::submit('登録',array('name' => 'register2','class' => 'register')) }}
      </div>
    </td>
    {!! Form::close() !!}
    <td class="add2">
      <div class="new">
        <p class="label">カテゴリー一覧</p>
      </div>
      @foreach($tables as $items)
      <div class="mainCategory">
        {{$items->main_category}}
        @if($items->subs->isEmpty())
        <a class="dele" href="/{{$items->id}}/mainDelete" onclick="return confirm('このレコードを削除します。よろしいでしょうか？')">削除</a>
        @endif
      </div>
      @foreach($items->subs as $subs)
      <div class="subCategory">
        {{$subs->sub_category}}
        @if(!$subs->judgment($subs->id))
        <a class="dele" href="/{{$subs->id}}/subDelete" onclick="return confirm('このレコードを削除します。よろしいでしょうか？')">削除</a>
        @endif
      </div>
      @endforeach
      @endforeach
    </td>
  </tr>
</table>
@endsection
