@extends('layouts.logout')

@section('content')

<table class="topTable">
  <tr class="loginTable">

    {!! Form::open() !!}

    <td>
      <p class='h1'>ログイン</p>
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
      <div class='button'>{{ Form::submit('ログイン',['class'=>'btn']) }}</div>
    </td>

    <td>
      <p class='h1'><a href="/register" style="color:#595959;">新規ユーザー登録は<span style="color:#4A86E8;">こちら</span></a></p>
    </td>

    {!! Form::close() !!}

  </tr>
</table>

@endsection
