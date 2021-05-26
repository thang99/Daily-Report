@extends('layouts.app')
@section('title_page')
    {{ 'Reports-'.auth()->user()->name }}
@endsection
@section('main_content')
    <list-report-user-component :id="{{$id}}"></list-report-user-component>
@endsection
