@extends('layouts.app')
@section('title_page')
    {{ "Edit Profile" }}
@endsection
@section('main_content')
  <edit-profile :user="{{$user}}"></edit-profile>
@endsection
