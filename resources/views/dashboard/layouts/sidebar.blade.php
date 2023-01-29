<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">القائمة</li>

                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>

                @can('access_employee')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span>الموظفين</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('employees.index') }}">جميع الموظفين</a></li>
                            @can('create_employee')
                                <li><a href="{{ route('employees.create') }}">إضافة موظف جديد</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('setting')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span>الاعدادات</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('setting')
                            <li><a href="{{ route('settings.index') }}">الاعدادات</a></li>
                            @endcan
                            @can('roles')
                            <li><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
