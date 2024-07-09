@extends('frontend.landing_page.app')
@section('title', __('system.terms_and_conditions.terms_and_conditions'))
@section('content')
    <div class="mb-5">
        <h1>{{ __('system.terms_and_conditions.terms_and_conditions') }}</h1>
        <h4>{{ __('system.terms_and_conditions.description') }}</h4>
    </div>
    {!! $termsAndCondition->local_description !!}
@endsection
