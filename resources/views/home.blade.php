@extends('layouts.app')

@section('title_page')
    {{ "Home" }}
@endsection
@section('main_content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="ri-home-4-line mr-1 float-left"></i>Home</a>
            </li>
        </ol>
    </nav>
    <div class="clearfix"></div>

    <div class="mb-4 p-3 bg-primary-light">

        <div class="row">
            <div class="col-md-1">
                <div class="text-center">
                    <img src="images/users/{{auth()->user()->avatar}}" class="rounded-circle "
                         alt="{{auth()->user()->name}}"
                         width="100px" height="100px">
                </div>
            </div>
            <div class="col-md-11">
                <div class="p-3">
                    <h4>Hello {{auth()->user()->name}}</h4>
                    <br>
                    <h5 class="text-primary font-weight-bold">Welcome to Daily Report</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @role('admin')
        <widget-admin-division></widget-admin-division>
        <widget-admin-position></widget-admin-position>
        <widget-admin-report-count></widget-admin-report-count>
        <widget-admin-user-count></widget-admin-user-count>
        <widget-admin-user></widget-admin-user>
        <widget-admin-report></widget-admin-report>
        @endrole
        @hasanyrole('user')
        <widget-user-report-count :id="{{auth()->user()->id}}"></widget-user-report-count>
        <widget-user-report :id="{{auth()->user()->id}}"></widget-user-report>
{{--        <widget-report-division ></widget-report-division>--}}
        @endhasanyrole

    </div>

@endsection
