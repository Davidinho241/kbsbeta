@extends('layouts.main')
@section('title', $tenant->api_key)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h5>{{ __('Settings')}}</h5>
                            <span>{{ __('Manage tenant')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Tenant')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($tenant->api_key, 'titles')}}
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                @for ($i = 0; $i < 2; $i++)
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>
                                            @switch($i)
                                                @case(0)
                                                {{ __('Services')}}
                                                @break

                                                @default
                                                {{ __('Accounts')}}
                                            @endswitch
                                        </h6>
                                        <h2>
                                            @switch($i)
                                                @case(0)
                                                {{count($tenant['services'])}}
                                                @break

                                                @default
                                                {{count($tenant['customers'])}}
                                            @endswitch
                                        </h2>
                                    </div>
                                    <div class="icon">
                                        @switch($i)
                                            @case(0)
                                            <i class="ik ik-server"></i>
                                            @break

                                            @default
                                            <i class="ik ik-users"></i>
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </di>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Add service')}}</h3></div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('create-service') }}" >
                            @csrf
                            <input type="hidden" name="tenant_id" id="tenant_id" value="{{$tenant->id}}">
                            <input type="hidden" name="tenant_id" id="tenant_uuid" value="{{$tenant->uuid}}">
                            <div class="form-group">
                                <label for="name">{{ __('Name')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="" placeholder="Name" required>
                                <div class="help-block with-errors"></div>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="type">{{ __('Type')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="" placeholder="Type" required>
                                <div class="help-block with-errors"></div>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="event">{{ __('Event')}}</label>
                                        <textarea class="form-control" id="event" name="event" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                            <button class="btn btn-light">{{ __('Cancel')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Add customer')}}</h3></div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('tenant-update') }}" >
                            @csrf
                            <input type="hidden" name="id" value="{{$tenant->id}}">
                            <div class="form-group">
                                <label for="api_key">{{ __('Api key')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('api_key') is-invalid @enderror" id="api_key" name="api_key" value="{{ clean($tenant->api_key, 'titles')}}" placeholder="Api Key" required>
                                <div class="help-block with-errors"></div>

                                @error('api_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="api_secret">{{ __('Api secret')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('api_secret') is-invalid @enderror" id="api_secret" name="api_secret" value="{{ clean($tenant->api_secret, 'titles')}}" placeholder="Api secret" required>
                                <div class="help-block with-errors"></div>

                                @error('api_secret')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="external_key">{{ __('External key')}}</label>
                                        <input type="text" class="form-control" id="external_key" name="external_key" value="{{ clean($tenant->external_key, 'titles')}}" placeholder="00000000-0000-0000-0000-000000000000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_salt">{{ __('Api salt')}}</label>
                                        <input type="text" class="form-control" id="api_salt" name="api_salt" value="{{ clean($tenant->api_salt, 'titles')}}" placeholder="Api salt" >
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                            <button class="btn btn-light">{{ __('Cancel')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header"><h3>{{ __('Services')}}</h3></div>
                    <div class="card-body">
                        <table id="services_table" class="table">
                            <thead>
                            <tr>
                                <th>{{ __('UUID')}}</th>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('Type')}}</th>
                                <th>{{ __('Created by')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
{{--            <div class="col-md-12">--}}
{{--                <div class="card p-3">--}}
{{--                    <div class="card-header"><h3>{{ __('Customers')}}</h3></div>--}}
{{--                    <div class="card-body">--}}
{{--                        <table id="customer_table" class="table">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>{{ __('UUID')}}</th>--}}
{{--                                <th>{{ __('Name')}}</th>--}}
{{--                                <th>{{ __('Email')}}</th>--}}
{{--                                <th>{{ __('Currency')}}</th>--}}
{{--                                <th>{{ __('Created by')}}</th>--}}
{{--                                <th>{{ __('Action')}}</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form class="forms-sample modal-body" method="POST" action="{{ route('update-service') }}" >
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editServiceModalLabel">{{ __('Edit service')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="tenant_id" id="tenant_id" value="{{$tenant->id}}">
                            <input type="hidden" name="id" id="service_id" value="">
                            <div class="form-group">
                                <label for="edit_name">{{ __('Name')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" value="" placeholder="Name" required>
                                <div class="help-block with-errors"></div>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="edit_type">{{ __('Type')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" id="edit_type" name="type" value="" placeholder="Type" required>
                                <div class="help-block with-errors"></div>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="edit_event">{{ __('Event')}}</label>
                                        <textarea class="form-control" id="edit_event" name="event" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Close')}}</button>
                            <button type="submit" class="btn btn-primary mr-2">{{ __('Save changes')}}</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('js/service.js') }}"></script>
    @endpush
@endsection
