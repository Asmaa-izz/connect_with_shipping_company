@extends('dashboard.layouts.master')

@section('title', $order->name)


@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع الطلبات")
        @slot('li_2_link', "/dashboard/orders")
        @slot('page_now', $order->name)
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title m-3"><strong>{{ $order->name }}</strong></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>البريد الالكتورني :</strong> <span>{{ $order->email }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>


@endsection
