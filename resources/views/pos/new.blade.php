@extends('layouts.app')
@section('title', __('system.dashboard.menu'))
@section('content')
<div id="pos">
    <new-page></new-page>
</div>
@vite('resources/js/pos.js')
@endsection

@section('styles')
@vite('resources/sass/pos.scss')
@endsection