@extends('layouts.main')
@section('title', 'Plans')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-airplay bg-green"></i>
                        <div class="d-inline">
                            <h5>{{ __('Plans')}}</h5>
                            <span>{{ __('List of all plans')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Plans')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
                @include('include.message')
            <!-- end message area-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-responsive">
                            <table id="simpletable"
                                   class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>{{ __('ID')}}</th>
                                    <th>{{ __('Type')}}</th>
                                    <th>{{ __('Billing period')}}</th>
                                    <th>{{ __('Price')}}</th>
                                    <th>{{ __('Duration')}}</th>
                                    <th>{{ __('Product name')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->id}}</td>
                                            <td>{{ $plan->type}}</td>
                                            <td>{{ $plan->billing_period}}</td>
                                            <td>{{ $plan->price}}</td>
                                            <td>{{ $plan->duration}}</td>
                                            <td>{{ $plan->product->label}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Language - Comma Decimal Place table end -->
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
    @endpush
@endsection
