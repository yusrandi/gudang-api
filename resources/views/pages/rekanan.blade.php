@extends('layouts.main')
@section('title', 'Data Vendor')
@section('content')


    <div class="container-fluid">

        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-credit-card bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Data Vendor / Rekanan') }}</h5>
                            {{-- <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit') }}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ __('Data Master') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Data Vendor / Rekanan') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @livewire('wirerekanan')

    </div>

@endsection
