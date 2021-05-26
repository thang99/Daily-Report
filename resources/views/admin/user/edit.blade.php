@extends('layouts.app')
@section('title_page')
    {{ 'Edit User' }}
@endsection
@section('main_content')
  <form-edit-user-component :id_user='{{$id}}'></form-edit-user-component>
@endsection
