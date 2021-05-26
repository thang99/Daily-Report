@extends('layouts.app')
@section('title_page')
    {{ "Friends" }}
@endsection
@section('main_content')
    <h1 class="text-center">Followers</h1>
    <br>
    <list-user-follow-component :id="{{Auth::user()->id}}"></list-user-follow-component>
@endsection
