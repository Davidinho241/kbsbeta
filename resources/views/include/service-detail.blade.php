<!-- push external head elements to head -->
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-package bg-green"></i>
                    <div class="d-inline">
                        <h5>{{ __('Service details')}}</h5>
                        <span>{{ __('manage products, categories and plans of a service')}}</span>
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
                            <a href="#">{{ __('Tenant')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Service')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('uuid')}}</a>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- start message area-->
                @include('include.message')
            <!-- end message area-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-header"><h3>{{ __('Products')}}</h3></div>
                <div class="card-body">
                    <table id="product_table" class="table">
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
    </div>
</div>
