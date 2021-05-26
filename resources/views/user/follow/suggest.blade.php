@extends('layouts.app')
@section('title_page')
    {{ "Suggests" }}
@endsection
@section('main_content')
    <h1 class="text-center">Suggest Followers</h1>
    <br>
    <suggest-user-component :id="{{Auth::user()->id}}"></suggest-user-component>
@endsection
