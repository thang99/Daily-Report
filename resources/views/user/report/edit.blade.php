@extends('layouts.app')
@section('title_page')
    {{ 'Edit Report'  }}
@endsection
@section('main_content')

    <form-edit-report-component :report="{{$report}}"></form-edit-report-component>
@endsection
