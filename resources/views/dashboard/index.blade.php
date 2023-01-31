@extends('dashboard.layouts.master')

@section('title') لوحة التحكم @endsection

@section('content')

@component('dashboard.commonComponents.breadcrumb')
@slot('page_now', "الرئيسية")
@endcomponent
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card bg-soft-primary">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">{{ $employees_count }}</h3>
                                <span>عدد الموظفين</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card bg-soft-info">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">{{ $orders_count }}</h3>
                                <span>عدد الطلبات</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card bg-soft-warning">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">{{ $companies_count }}</h3>
                                <span>عدد شركات الشحن</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
