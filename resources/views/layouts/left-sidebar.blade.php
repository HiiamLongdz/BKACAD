<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="mdi mdi-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">

            <a href="index.html" class="logo"><img src="{{ asset('assets/images/logo_2.png') }}" height="20"
                    alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="dripicons-home"></i>
                        <span> Dashboard <span class="badge badge-success badge-pill float-right">3</span></span>
                    </a>
                </li>
                @role('admin')
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-briefcase"></i> <span> Quản
                            Trị Viên </span> <span class="menu-arrow float-right"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('view_role_permission') }}">Thông Tin Quyền Chức Vụ</a></li>
                        <li><a href="{{ route('add_staff') }}">Thêm Nhân Viên</a></li>
                        <li><a href="{{ route('list_staff') }}">Danh Sách Nhân Viên</a></li>
                    </ul>
                </li>
                @endrole

                @role('ministry|admin')
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-archive"></i> <span> Giáo Vụ
                        </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('add_lecturer') }}">Thêm Giảng Viên</a></li>
                        <li><a href="{{ route('create_subject') }}">Thêm Môn</a></li>
                        <li><a href="{{ route('list_subject') }}">Danh Sách Môn</a></li>
                        <li><a href="{{ route('create_major') }}">Thêm Ngành</a></li>
                        <li><a href="{{ route('list_major') }}">Danh Sách Ngành</a></li>

                        <li><a href="{{ route('create_course') }}">Thêm Khóa</a></li>
                        <li><a href="{{ route('list_course') }}">Danh Sách Khóa</a></li>
                        {{-- <li><a href="{{ route('danh_sach_nhan_vien') }}">Danh Sách
                                Nhân Viên</a></li> --}}
                    </ul>
                </li>
                @endrole

                @role('lecturer')
                <li>
                    <a href="{{ route('attend') }}" class="waves-effect"><i class="dripicons-calendar"></i><span> Điểm
                            Danh
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('attendance_history') }}" class="waves-effect"><i
                            class="dripicons-calendar"></i><span> Lịch Sử Điểm Danh
                        </span></a>
                </li>
            @else
                <li>
                    <a href="{{ route('attend_over') }}" class="waves-effect"><i class="dripicons-calendar"></i><span>
                            Điểm Danh Ngoài Giờ
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('attendance_history') }}" class="waves-effect"><i
                            class="dripicons-calendar"></i><span> Lịch Sử Điểm Danh
                        </span></a>
                </li>
                @endrole

                @role('admin|ministry')
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-document"></i><span> Quản Lí
                            Sinh Viên
                        </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('import_student') }}">Nhập Sinh
                                Viên</a></li>
                        <li><a href="{{ route('list_student') }}">Danh Sách Sinh Viên</a></li>

                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-graph-bar"></i><span> Phân
                            Công
                        </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('assign') }}">Phân Công</a></li>
                        <li><a href="{{ route('assignment_detail') }}">Chi Tiết Phân Công</a></li>
                    </ul>
                </li>
                @endrole
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
