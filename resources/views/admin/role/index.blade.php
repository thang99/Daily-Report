@extends('layouts.app')
@section('main_content')
    @if(session('msg'))
        <span class="text-success">{{session('msg')}}</span>
    @endif
    <br>
    <a href="{{route('roles.store')}}" class="btn btn-primary">Insert Role</a>
@endsection
