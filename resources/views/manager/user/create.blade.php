@extends('layouts.app')
@section('title_page')
    {{ 'Add user to division' }}
@endsection
@section('main_content')
    <create-user :id="{{$idManager}}"></create-user>
@endsection
