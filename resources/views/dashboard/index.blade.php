@extends('dashboard.layouts.master')

@section('title') لوحة التحكم @endsection

@section('content')

@component('dashboard.commonComponents.breadcrumb')
@slot('page_now', "الرئيسية")
@endcomponent



@endsection
