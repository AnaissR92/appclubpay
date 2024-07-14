@extends('layouts.app')
@section('title', __('system.qr_code.menu'))
@push('page_css')
    <style>
        .section-to-print {
            margin-bottom: 30px;
        }

        @media only screen and (min-width: 320px) and (max-width: 700px) {
            label[for="profile_image"] {
                display: block;
            }
        }

        @media print {
            body * {
                visibility: hidden;
                margin: 0px 30px;
            }

            .section-to-print,
            .section-to-print * {
                visibility: visible;
            }

            .section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="tab-content">

                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <h4 class="card-title">{{ __('system.qr_code.menu') }}</h4>
                                <div class="page-title-box pb-0 d-sm-flex">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a>
                                            </li>
                                            <li class="breadcrumb-item active">{{ __('system.qr_code.menu') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6">
                                {!! QrCode::size(350)->generate(route('frontend.restaurant', $restaurant->slug))!!}
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <a href="{{$download_path}}" download="{{$download_name}}" class="btn btn-primary">
                                    {{trans('system.fields.download_qr')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
