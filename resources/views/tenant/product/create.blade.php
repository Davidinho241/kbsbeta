@extends('layouts.main')
@section('title', 'Add Product')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{__('Add Product')}}</h5>
                            <span>{{__('Add new product in inventory')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{__('Tenant')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{__('Service')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{__('Add Product')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('create-product') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="label">{{__('Label')}}<span class="text-red">*</span></label>
                                        <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="" placeholder="Enter product label" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('label')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="external_key">{{__('External key')}}<span class="text-red">*</span></label>
                                        <input id="external_key" type="text" class="form-control @error('external_key') is-invalid @enderror" name="external_key" value="" placeholder="Enter external key" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('external_key')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description')}} <span class="text-red">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required></textarea>
                                        <div class="help-block with-errors"></div>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Categories <span class="text-red">*</span></label>
                                        <div class="border-checkbox-section ml-3">
                                            @foreach($categories as $category)
                                                <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                    <input class="border-checkbox" type="checkbox" id="'category'.{{$category->id}}" value="{{$category->id}}" name="categories[]">
                                                    <label class="border-checkbox-label" for="'category'.{{$category->id}}">{{$category->label}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_id">Service attach<span class="text-red">*</span></label>
                                        <select name="service_id" class="form-control" id="service_id">
                                            <option>{{__('select a service ...')}}</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="page-header">
                                <div class="row align-items-end">
                                    <div class="col-lg-8">
                                        <div class="page-header-title">
                                            <i class="ik ik-airplay bg-blue"></i>
                                            <div class="d-inline">
                                                <h5>{{__('Product plan')}}</h5>
                                                <span>{{__('Attach plan to the product')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="duration">{{__('Duration')}}<span class="text-red">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="duration_length" type="number" class="form-control @error('duration_length') is-invalid @enderror" name="duration_length" value="" placeholder="30" required="">
                                                <div class="help-block with-errors"></div>

                                                @error('duration_length')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select name="duration_phase" class="form-control" id="duration_phase">
                                                    <option value="DAYS">{{__('select duration phase ...')}}</option>
                                                    <option value="DAYS">DAYS</option>
                                                    <option value="MONTH">MONTH</option>
                                                    <option value="YEARS">YEARS</option>
                                                    <option value="UNLIMITED">UNLIMITED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">{{__('Price')}}<span class="text-red">*</span></label>
                                        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="" placeholder="10.00 XAF" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="billing_period">{{__('Billing period')}}<span class="text-red">*</span></label>
                                        <input id="billing_period" type="text" class="form-control @error('billing_period') is-invalid @enderror" name="billing_period" value="" placeholder="Enter billing period" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('billing_period')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type<span class="text-red">*</span></label>
                                        <select name="type" class="form-control" id="type">
                                            <option>{{__('select plan type ...')}}</option>
                                            <option value="TRIAL">TRIAL</option>
                                            <option value="EVERGREEN">EVERGREEN</option>
                                            <option value="ONETIME">ONETIME</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
