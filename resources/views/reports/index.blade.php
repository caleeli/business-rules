@extends('layouts.layout')

@section('sidebar')
    @include('layouts.sidebar', ['sidebar'=> Menu::get('sidebar_admin')])
@endsection

@section('content')
    <div class="container page-content" id="reports">
        <p class="lead">
        <h1>{{ __('Reports') }}</h1>

    </div>
@endsection

@section('js')

@endsection

