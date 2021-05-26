@extends('layouts.app')
@section('title_page')
    {{ 'Manage User Division' }}
@endsection
@section('main_content')
  <list-user-division-component :id_user="{{$id_user}}"></list-user-division-component>
@endsection
