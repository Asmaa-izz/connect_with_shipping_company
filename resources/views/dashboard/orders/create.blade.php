@extends('dashboard.layouts.master')

@section('title', "إضافة طلب جديد")

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endsection

@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع طلبات")
        @slot('li_2_link', "/dashboard/orders")
        @slot('page_now', "إضافة طلب جديد")
    @endcomponent

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                            <p class="text-danger">{{$errors->first()}}</p>
                        @endif

                        <div class="card-title d-flex justify-content-between align-items-center my-3">
                            <h4>إضافة طلب جديد</h4>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="number" class="control-label required">رقم الطلب:</label>
                                <input type="text" class="form-control" name="number" id="number"
                                       placeholder="أدخل رقم الطلب"
                                       value="{{old('number') ?? $number}}" required>
                                @error('number')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="customer_name" class="control-label required">اسم العميل:</label>
                                <input type="text" class="form-control" name="customer_name" id="customer_name"
                                       placeholder="أدخل اسم العميل"
                                       value="{{old('customer_name')}}" required>
                                @error('customer_name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="customer_phone" class="control-label required">هاتف العميل:</label>
                                <input type="text" class="form-control" name="customer_phone" id="customer_phone"
                                       placeholder="أدخل هاتف العميل"
                                       value="{{old('customer_phone')}}" required>
                                @error('customer_phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="customer_phone_other" class="control-label required">رقم هاتف أخر:</label>
                                <input type="text" class="form-control" name="customer_phone_other"
                                       id="customer_phone_other" placeholder="أدخل رقم هاتف أخر"
                                       value="{{old('customer_phone_other')}}" required>
                                @error('customer_phone_other')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="city" class="control-label required">المحافظة :</label>
                                <select class="select2 form-control" required
                                        data-placeholder="اختر " name="city_id" id="city">
                                    <option></option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="area" class="control-label required">المنطقة :</label>
                                <select class="select2 form-control" required
                                        data-placeholder="اختر " name="area_id" id="area">
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="neighborhood" class="control-label required">الحي :</label>
                                <select class="select2 form-control" required
                                        data-placeholder="اختر " name="neighborhood_id" id="neighborhood">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="amount" class="control-label required">المبلغ:</label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                       placeholder="أدخل المبلغ"
                                       value="{{old('amount')}}" required>
                                @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="product_details" class="control-label required"> التفاصيل:</label>
                                <textarea class="form-control" id="product_details" rows="2"
                                          name="product_details">{{old('product_details')}}</textarea>
                                @error('product_details')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="button-send">
                                    حفظ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('script')
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <script>
        $('#city').select2();
        $(document).on("change", "#city", function () {
            let city = $(this).val();
            $('#area').select2({
                ajax: {
                    url: `/dashboard/cities/${city}`,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        console.log(data.data)
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
            });
        });

        $(document).on("change", "#area", function () {
            let area = $(this).val();
            $('#neighborhood').select2({
                ajax: {
                    url: `/dashboard/areas/${area}`,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        console.log(data.data)
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
            });
        });
    </script>
@endsection
