@extends('layouts.app')
@section('title_page')
    {{ 'Manage Users' }}
@endsection
@section('main_content')
  <list-user-component :id_user="{{$id_user}}"></list-user-component>
@endsection
