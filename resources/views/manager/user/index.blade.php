@extends('layouts.app')
@section('title_page')
    {{ 'Manage User' }}
@endsection
@section('main_content')
    <list-user :id="{{$idManager}}"></list-user>
@endsection
