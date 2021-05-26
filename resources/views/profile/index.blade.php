@extends('layouts.app')
@section('title_page')
    {{ $user->name }}
@endsection
@section('main_content')
  <user-profile :iduserlogin="{{$idUserLogin}}" :user="{{$user}}" :position="{{$position}}" :division="{{$division}}" :id="{{$id}}"></user-profile>
@endsection
