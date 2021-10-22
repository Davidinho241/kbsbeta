@extends('layouts.main')
@section('title', 'Categories')
@section('content')
    <!-- push external head elements to head -->
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-list bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Categories')}}</h5>
                            <span>{{__('Add, remove or edit product categories')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Categories')}}</a>
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
            <div class="col-md-12">
                <div class="mb-2 clearfix">
                    <a class="btn pt-0 pl-0 d-md-none d-lg-none" data-toggle="collapse" href="#displayOptions" role="button" aria-expanded="true" aria-controls="displayOptions">
                        {{ __('Display Options')}}
                        <i class="ik ik-chevron-down align-middle"></i>
                    </a>
                    <div class="collapse d-md-block display-options" id="displayOptions">
                        <span class="mr-3 d-inline-block float-md-left dispaly-option-buttons">
                            <a href="#" class="mr-1 view-thumb ">
                                <i class="ik ik-list view-icon"></i>
                            </a>
                            <a href="#" class="mr-1 view-grid active">
                                <i class="ik ik-grid view-icon"></i>
                            </a>
                        </span>
                        <div class="d-block d-md-inline-block">
                            <div class="btn-group float-md-left mr-1 mb-1">
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('
                                    Order By')}}
                                    <i class="ik ik-chevron-down mr-0 align-middle"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">{{ __('DESC')}}</a>
                                    <a class="dropdown-item" href="#">{{ __('ASC')}}</a>
                                </div>
                            </div>
                            <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                <form action="">
                                    <input type="text" class="form-control" placeholder="Search.." required>
                                    <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
                                    <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="adv-search-wrap dropdown-menu dropdown-menu-right" aria-labelledby="adv_wrap_toggler">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Category Title">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Category Code">
                                        </div>
                                        <button class="btn btn-theme">{{ __('Search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="float-md-right">
                            <span class="text-muted text-small mr-2">{{ __('Displaying 1-10 of 210 items')}} </span>
                            <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                20
                                <i class="ik ik-chevron-down mr-0 align-middle"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">10</a>
                                <a class="dropdown-item" href="#">20</a>
                                <a class="dropdown-item" href="#">30</a>
                                <a class="dropdown-item" href="#">50</a>
                                <a class="dropdown-item" href="#">100</a>
                            </div>
                            <button class="btn btn-outline-primary btn-rounded-20" href="#categoryAdd" data-toggle="modal" data-target="#categoryAdd">
                                Add Category
                            </button>
                        </div>
                    </div>
                </div>
                <div class="separator mb-20"></div>

                <div class="row layout-wrap" id="layout-wrap">
                    @foreach($categories as $category)
                        <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 list-item list-item-grid">
                            <div class="card d-flex flex-row mb-3">
                                <a class="d-flex card-img" href="#categoryView" data-toggle="modal" data-target="#categoryView">
                                    <img src="{{asset('img/portfolio-3.jpg')}}" alt="Donec sit amet est at sem iaculis aliquam." class="list-thumbnail responsive border-0">
                                    <span class="badge badge-pill badge-success position-absolute badge-top-left">{{count($category['products'])}} products</span>
                                </a>
                                <div class="d-flex flex-grow-1 min-width-zero card-content">
                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center mb-0">
                                        <a class="mb-1 list-item-heading  truncate w-40 w-xs-100" href="#categoryView" data-toggle="modal" data-target="#categoryView">
                                            <b>
                                                {{__($category->label)}}
                                            </b>
                                        </a>
                                        <p class="mb-1 text-muted text-small date w-25 w-xs-100">
                                            {{__($category->description)}}
                                        </p>
                                    </div>
                                </div>
                                <div class="list-actions table-actions">
                                    <a href="#categoryView" data-toggle="modal" data-target="#categoryView" data-id="{{$category->id}}" data-label="{{$category->label}}" data-description="{{$category->description}}" ><i class="ik ik-edit-2"></i></a>
                                    <a href="{{url('/category/delete/'.$category->id)}}" class="list-delete"><i class="ik ik-trash-2"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- category add modal-->
    <div class="modal fade edit-layout-modal pr-0 " id="categoryAdd" tabindex="-1" role="dialog" aria-labelledby="categoryAddLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryAddLabel">{{ __('Add Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" method="POST" action="{{ route('create-category') }}" >
                        @csrf
                        <div class="form-group">
                            <label class="d-block" for="label">{{__('Category label')}}</label>
                            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" id="label" placeholder="Enter Category Title">
                            <div class="help-block with-errors"></div>

                            @error('label')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description')}}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4"></textarea>
                            <div class="help-block with-errors"></div>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- category edit modal -->
    <div class="modal fade edit-layout-modal pr-0 " id="categoryView" tabindex="-1" role="dialog" aria-labelledby="categoryViewLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryViewLabel">{{ __('Edit Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" method="POST" action="{{ route('update-category') }}" >
                        @csrf
                        <input type="hidden" name="id" id="editId" value="">
                        <div class="form-group">
                            <label class="d-block" for="editLabel">{{__('Category label')}}</label>
                            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" id="editLabel" value="" placeholder="Enter Category Title">
                            <div class="help-block with-errors"></div>

                            @error('label')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" for="editDescription">{{ __('Description')}}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="editDescription" name="description" rows="4"></textarea>
                            <div class="help-block with-errors"></div>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
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
