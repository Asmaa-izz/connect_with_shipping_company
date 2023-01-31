@extends('dashboard.layouts.master')

@section('title', 'الاعدادات')


@section('content')
    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('page_now', 'الاعدادات')
    @endcomponent


    <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                            <p class="text-danger">{{$errors->first()}}</p>
                        @endif

                        <div class="card-title d-flex justify-content-between align-items-center my-3">
                            <h4>الاعدادات</h4>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_page" class="control-label">عنوان الصفحة الرئيسية:</label>
                                <input type="text" class="form-control" name="title_page" id="title_page"
                                       value="{{ $title_page }}">
                                @error('title_page')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_header" class="control-label">عنوان الرأس:</label>
                                <input type="text" class="form-control" name="title_header" id="title_header"
                                       value="{{ $title_header }}">
                                @error('title_header')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_main" class="control-label">عنوان الفقرة في الصفحة الرئيسية:</label>
                                <input type="text" class="form-control" name="title_main" id="title_main"
                                       value="{{ $title_main }}">
                                @error('title_main')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="text_main" class="control-label"> الفقرة في الصفحة الرئيسية:</label>
                                <input type="text" class="form-control" name="text_main" id="text_main"
                                       value="{{ $text_main }}">
                                @error('text_main')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="row">--}}
{{--                            <div class="form-group col-md-12">--}}
{{--                                <label for="color" class="control-label">اللون:</label>--}}
{{--                                <input type="text" class="form-control" name="color" id="color"--}}
{{--                                       value="{{ $color }}">--}}
{{--                                @error('color')--}}
{{--                                <small class="text-danger">{{ $message }}</small>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="logo" class="control-label">logo:</label>
                                <input type="file" class="form-control" name="logo" id="logo"
                                       value="{{ $logo }}">
                                @error('logo')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="img_home" class="control-label">الصورة في الصفحة الرئيسية:</label>
                                <input type="file" class="form-control" name="img_home" id="img_home"
                                       value="{{ $img_home }}">
                                @error('img_home')
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
