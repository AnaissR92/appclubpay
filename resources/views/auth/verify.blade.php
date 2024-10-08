@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="box">
                    <h3 class="box-title">{{ __('auth.verify_email.title') }}</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">{{ __('auth.verify_email.success') }}</div>
                        @endif
                        <p>{{ __('auth.verify_email.notice') }}</p>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                            {{ __('auth.verify_email.another_req') }}
                        </a>
                        <form autocomplete="off" id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
