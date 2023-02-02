@extends('dashboard.layouts.master')

@section('title', "تعديل شركة شحن")

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endsection

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

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="city" class="control-label required">المحافظة :</label>
                                    <select class="select2 form-control" required
                                            data-placeholder="اختر " name="city_id" id="city">
                                        <option></option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{ $cityId == $city->id ? 'selected' : null}}>{{$city->name}}</option>
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

@section('script')
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <script>

        let array = @json($areas);
        array.forEach( item => {
            let $optionArea = $("<option selected></option>").val(item.id).text(item.name);
            $('#area').append($optionArea).trigger('change')
        })

        $('#city').select2();
        let city = '{{ $cityId }}';
        let companyId = '{{ $company->id }}';

        $('#area').select2({
            ajax: {
                url: `/dashboard/cities/${city}?hasCompany=true&companyId=${companyId}`,
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

        $(document).on("change", "#city", function () {
            let city = $(this).val();
            $('#area').select2({
                ajax: {
                    url: `/dashboard/cities/${city}?hasCompany=true&companyId=${companyId}`,
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
