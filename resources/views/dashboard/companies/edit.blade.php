@extends('dashboard.layouts.master')

@section('title', "تعديل شركة شحن")

@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع شركات الشحن")
        @slot('li_2_link', "/dashboard/companies")
        @slot('page_now', "تعديل شركة شحن")
    @endcomponent

    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                            <p class="text-danger">{{$errors->first()}}</p>
                        @endif

                        <div class="card-title d-flex justify-content-between align-items-center my-3">
                            <h4>تعديل شركة الشحن</h4>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name" class="control-label required">اسم شركة الشحن:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم"
                                       value="{{ $company->name }}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

{{--                            --}}

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="button-send">
                                    تعديل
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
