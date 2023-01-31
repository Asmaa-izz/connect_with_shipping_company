@extends('dashboard.layouts.master')

@section('title', "تعديل موظف")

@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "جميع الموظفين")
        @slot('li_2_link', "/dashboard/employees")
        @slot('page_now', "تعديل موظف")
    @endcomponent

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
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
                            <h4>تعديل موظف</h4>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name" class="control-label required">اسم الموظف:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="أدخل الاسم"
                                       value="{{ $employee->name }}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="email" class="control-label required">البريد الإلكتروني:</label>
                                <input type="email" class="form-control bg-light" name="email" id="email"
                                       placeholder="أدخل البريد الإلكتروني"
                                       value="{{ $employee->email  }}" disabled>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="password">تغيير كلمة المرور:</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="أدخل كلمة المرور"
                                       value="">
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
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
