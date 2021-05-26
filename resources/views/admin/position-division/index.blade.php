@extends('layouts.app')
@section('title_page')
    {{ 'Manage Position Division' }}
@endsection
@section('main_content')
  <list-position-division-component :id_division='{{$id}}' ></list-position-division-component>
@endsection
