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
                        <i class="ik ik-layout bg-green"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Tenant')}}</h5>
                            <span>{{ __('Update tenant information')}}</span>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
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
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('js/get-role.js') }}"></script>
    @endpush
@endsection
