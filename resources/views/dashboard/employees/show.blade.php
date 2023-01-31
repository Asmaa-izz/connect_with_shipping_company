@extends('dashboard.layouts.master')

@section('title', $employee->name)


@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع الموظفين")
        @slot('li_2_link', "/dashboard/employees")
        @slot('page_now', $employee->name)
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title m-3"><strong>{{ $employee->name }}</strong></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>البريد الالكتورني :</strong> <span>{{ $employee->email }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>عدد الطلبات المدخلة :</strong> <span>{{ $orders_count }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>


@endsection
