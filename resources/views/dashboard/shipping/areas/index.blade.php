@extends('dashboard.layouts.master')

@section('title', 'المناطق')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/loading-spinner-overlay.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endsection


@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "الشحن")
        @slot('li_2_link', "/dashboard/shipping")
        @slot('page_now', "المناطق")
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center my-3">
                        <h4>جميع المناطق</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#creat-area">
                            إضافة منطقة جديد
                        </button>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>المحافظة</th>
                            <th>شركة الشحن</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="creat-area" tabindex="-1" role="dialog" aria-labelledby="creatRoleLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creatRoleLabel">اضافة منطقة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-create" action="{{ route('areas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="control-label required">اسم المنطقة: </label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="control-label required">المحافظة :</label>
                            <select class="select2 form-control" required
                                    data-placeholder="اختر " name="city" id="city">
                                <option></option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('form-create').submit();">اضافة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-area" tabindex="-1" role="dialog" aria-labelledby="creatRoleLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creatRoleLabel">تعديل منطقة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_edit" class="control-label required">اسم المنطقة </label>
                            <input type="text" class="form-control" name="name" id="name_edit" required>
                        </div>

                        <div class="mb-3">
                            <label for="city_edit" class="required form-label">المحافظة :</label>
                            <select class="select2 form-control" required
                                    data-placeholder="اختر المرشد" name="city" id="city_edit">
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">تعديل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@section('script')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                // processing: true,
                serverSide: true,
                ajax: "{{ route('areas.index') }}",
                columns: [
                    {"data": "name"},
                    {"data": "city"},
                    {"data": "company"},
                    {"data": "action"},
                ],
            });
        });


        function deleteItem(id) {
            Swal.fire({
                title: 'هل أنت متأكد من عملية الحذف ؟',
                text: "تنبيه , لا يمكن استعادة البيانات",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم , احذف!',
                cancelButtonText: 'إلفاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("div.spanner").addClass("show");
                    $("div.overlay").addClass("show");
                    fetch(`/dashboard/areas/${id}`, {
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        method: "delete",
                    })
                        .then(response => location = window.location)
                        .catch(error => console.log("error : " + error));
                }
            })

        }

        $('#city').select2();
        $('#city_edit').select2();

        $(document).on("click", ".edit-item", function () {
            let areaId = $(this).data('id');
            let areaName = $(this).data('name');
            let cityId = $(this).data('city');
            $("#name_edit").val(areaName);
            $('#form-edit').attr('action', '/dashboard/areas/' + areaId);

            $('#city_edit').val(cityId).trigger('change');
        });



    </script>

@endsection
