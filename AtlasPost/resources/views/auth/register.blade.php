@extends('layouts.logout')

@section('content')

<table class="topTable">
  <tr class="loginTable">

    {!! Form::open(['url' => '/register']) !!}

    <td>
      <p class='h1'>ユーザー登録</p>
    </td>

    <td>
      <div class='label'>{{ Form::label('ユーザー名') }}
        @if ($errors->has('username'))
        <li>{{$errors->first('username')}}</li>
        @endif
        {{ Form::text('username',null,['class' => 'input']) }}
      </div>
    </td>

    <td>
      <div class='label'>{{ Form::label('メールアドレス') }}
        @if ($errors->has('email'))
        <li>{{$errors->first('email')}}</li>
        @endif
        {{ Form::text('email',null,['class' => 'input']) }}
      </div>
    </td>

    <td>
      <div class='label'>{{ Form::label('パスワード') }}
        @if ($errors->has('password'))
        <li>{{$errors->first('password')}}</li>
        @endif
        {{ Form::password('password',['class' => 'input']) }}
      </div>
    </td>

    <td>
      <div class='label'>{{ Form::label('パスワード確認') }}
        @if ($errors->has('password_confirmation'))
        <li>{{$errors->first('password_confirmation')}}</li>
        @endif
        {{ Form::password('password_confirmation',['class' => 'input']) }}
      </div>
    </td>

    <td>
      <div class='button'>{{ Form::submit('登録',['class'=>'btn']) }}</div>
    </td>

    {!! Form::close() !!}

  </tr>
</table>

@endsection
