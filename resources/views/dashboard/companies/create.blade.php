@extends('dashboard.layouts.master')

@section('title', "إضافة شركة شحن جديد")

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endsection

@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع شركات الشحن")
        @slot('li_2_link', "/dashboard/companies")
        @slot('page_now', "إضافة شركة شحن جديد")
    @endcomponent

    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                            <p class="text-danger">{{$errors->first()}}</p>
                        @endif

                        <div class="card-title d-flex justify-content-between align-items-center my-3">
                            <h4>إضافة  شركة شحن جديد</h4>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">ب
                                <label for="name" class="control-label required">اسم شركة الشحن:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم"
                                       value="{{old('name')}}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="city" class="control-label required">المحافظة :</label>
                                    <select class="select2 form-control" required
                                            data-placeholder="اختر " name="city_id" id="city">
                                        <option></option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="area" class="control-label required">المناطق المتاحة :</label>
                                    <select class="select2 form-control" required multiple="multiple"
                                            data-placeholder="اختر " name="areas[]" id="area">
                                    </select>
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
        $('#area').select2();

        $(document).on("change", "#city", function () {
            let city = $(this).val();
            $('#area').select2({
                ajax: {
                    url: `/dashboard/cities/${city}/areas`,
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
                    multiple: true,
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
