@extends('layouts.main')
@section('title', 'Add Tenant')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layout bg-green"></i>
                        <div class="d-inline">
                            <h5>{{ __('Add Tenant')}}</h5>
                            <span>{{ __('Create new tenant')}}</span>
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
                                <a href="#">{{ __('Add Tenant')}}</a>
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
                        <form class="forms-sample" method="POST" action="{{ route('create-tenant') }}" >
                            @csrf
                            <div class="form-group">
                                <label for="api_key">{{ __('Api key')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('api_key') is-invalid @enderror" id="api_key" name="api_key" value="" placeholder="Api Key" required>
                                <div class="help-block with-errors"></div>

                                @error('api_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="api_secret">{{ __('Api secret')}}<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('api_secret') is-invalid @enderror" id="api_secret" name="api_secret" value="" placeholder="Api secret" required>
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
                                        <input type="text" class="form-control" id="external_key" name="external_key" value="" placeholder="00000000-0000-0000-0000-000000000000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_salt">{{ __('Api salt')}}</label>
                                        <input type="text" class="form-control" id="api_salt" name="api_salt" value="" placeholder="Api salt" >
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
@endsection
