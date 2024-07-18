@extends('layouts.app')
@section('title', __('system.dashboard.menu'))
@section('content')
<div id="pos">
    <home-component></home-component>
</div>
@vite('resources/js/pos.js')
@endsection

@section('styles')
@vite('resources/sass/pos.scss')
@endsection