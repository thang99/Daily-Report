@extends('layouts.app')
@section('title_page')
     Reports-Division
@endsection
@section('main_content')
    <show-report-division :id="{{$id}}"></show-report-division>
@endsection
