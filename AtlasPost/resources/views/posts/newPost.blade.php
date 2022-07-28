@extends('layouts.set')

@include('layouts.post_new')

@section('content')
<table class="newPost">
  <tr>
    {!! Form::open(['url' => '/post_new']) !!}

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
          @foreach($sub_category as $item)
          <option value="{{ $item->id }}">
            {{ $item->sub_category }}
          </option>
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
        {{ Form::text('title',null,['class' => 'add-input']) }}
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
        {{ Form::textarea('post',null,['class' => 'post-input']) }}
      </div>
      <div class="new">
        {{ Form::submit('投稿',['class' => 'register2']) }}
      </div>
    </td>

    {!! Form::close() !!}
  </tr>
</table>

@endsection
