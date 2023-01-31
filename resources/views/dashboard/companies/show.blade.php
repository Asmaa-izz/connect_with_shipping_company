@extends('dashboard.layouts.master')

@section('title', $company->name)


@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع شركات الشحن")
        @slot('li_2_link', "/dashboard/companies")
        @slot('page_now', $company->name)
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title m-3"><strong>{{ $company->name }}</strong></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush">
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>


@endsection
