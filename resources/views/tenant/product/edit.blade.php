@extends('layouts.main')
@section('title', 'Edit Product')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{__('Edit Product')}}</h5>
                            <span>{{__('Edit your product')}}</span>
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
                                <a href="#">{{__('Edit Product')}}</a>
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
                        <form class="forms-sample" method="POST" action="{{ route('update-product') }}">
                            @csrf
                            <input id="id" name="id" value="{{$product->id}}" hidden>
                            <input id="service_id" name="service_id" value="{{$product->service_id}}" hidden>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="label">{{__('Label')}}<span class="text-red">*</span></label>
                                        <input id="label" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{$product->label}}" placeholder="Enter product label" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('label')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="external_key">{{__('External key')}}<span class="text-red">*</span></label>
                                        <input id="external_key" type="text" class="form-control @error('external_key') is-invalid @enderror" name="external_key" value="{{$product->external_key}}" placeholder="Enter external key" required="">
                                        <div class="help-block with-errors"></div>

                                        @error('external_key')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description')}} <span class="text-red">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{$product->description}}</textarea>
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
                                                    <input class="border-checkbox" type="checkbox" id="'category'.{{$category->id}}" value="{{$category->id}}" name="categories[]" @if($product['categories']->contains($category)) checked @endif>
                                                    <label class="border-checkbox-label" for="'category'.{{$category->id}}">{{$category->label}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_id">Service attach<span class="text-red">*</span></label>
                                        <select name="service_id" class="form-control" id="service_id">
                                            <option value="{{$product['service']->id}}">{{$product['service']->name}}</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}" @if($service->id == $product['service']->id) hidden @endif>{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
