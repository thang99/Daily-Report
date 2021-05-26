@extends('layouts.app')
@section('title_page')
    {{ 'Manage Report' }}
@endsection
@section('main_content')
    <list-report :id="{{$id}}"></list-report>
@endsection
