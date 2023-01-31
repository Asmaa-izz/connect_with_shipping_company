@extends('dashboard.layouts.master')

@section('title', 'المحافظات')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/loading-spinner-overlay.css')}}">
@endsection

@section('content')

    @component('dashboard.commonComponents.breadcrumb')
        @slot('li_1', "الرئيسية")
        @slot('li_1_link', "/dashboard")
        @slot('li_2', "الشحن")
        @slot('li_2_link', "/dashboard/shipping")
        @slot('page_now', "المحافظات")
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center my-3">
                        <h4>جميع المحافظات</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#creat-city">
                            إضافة محافظة جديد
                        </button>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>الاسم</th>
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

    <div class="modal fade" id="creat-city" tabindex="-1" role="dialog" aria-labelledby="creatRoleLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creatRoleLabel">اضافة محافظة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-create" action="{{ route('cities.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name"  class="required form-label">اسم المحافظة </label>
                            <input type="text" class="form-control" id="name" name="name">
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

    <div class="modal fade" id="edit-city" tabindex="-1" role="dialog" aria-labelledby="creatRoleLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creatRoleLabel">تعديل محافظة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_edit"  class="required form-label">اسم المحافظة </label>
                            <input type="text" class="form-control" name="name" id="name_edit">
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                // processing: true,
                serverSide: true,
                ajax: "{{ route('cities.index') }}",
                columns: [
                    {"data": "name"},
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
                    fetch(`/dashboard/cities/${id}`, {
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

        $(document).on("click", ".edit-item", function () {
            let cityId = $(this).data('id');
            console.log(cityId)
            let cityName = $(this).data('name');
            $("#name_edit").val(cityName);
            $('#form-edit').attr('action', '/dashboard/cities/' + cityId);
        });
    </script>

@endsection
