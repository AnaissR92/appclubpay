@extends('frontend.landing_page.app')
@section('title', __('system.privacy_policy.privacy_policy'))
@section('content')
    <div class="mb-5">
        <h1>{{ __('system.privacy_policy.privacy_policy') }}</h1>
        <h4>{{ __('system.privacy_policy.description') }}</h4>
    </div>
    {!! $privacyPolicy->local_description !!}
@endsection
