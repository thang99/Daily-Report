@extends('layouts.app')
@section('title_page')
    {{ 'Detail Report'  }}
@endsection
@section('main_content')
    <show-detail-report :report="{{$report}}"></show-detail-report>
@endsection
