@extends('layouts.app')
@section('title_page')
    {{ 'Edit position of user in division' }}
@endsection
@section('main_content')
    <edit-user :id="{{$idManager}}" :user="{{$user}}"></edit-user>
@endsection
