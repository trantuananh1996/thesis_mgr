<li>
    <a href="{{asset('/')}}">
        <i class="fa fa-dashboard"></i>
        <span>Trang chủ</span>
    </a>
</li>
@can('SA_roles_permissions')
<li>
    <a href="{{asset('/roles-permissions')}}">
        <i class="fa fa-users"></i>
        <span>Phân quyền - chức năng</span>
    </a>
</li>
@endcan

@can('general_manage')
<li class="sub-menu">
    <a>
        <i class="fa fa-cog"></i>
        <span>Thiết lập chung</span>
    </a>
    <ul class="sub">
        @can('term_manage')
        <li><a href="{{route('terms')}}"><i class="fa fa-flag"></i>Các đợt đăng ký</a></li>
        @endcan

    </ul>
</li>

<li class="sub-menu">
    <a>
        <i class="fa fa-laptop"></i>
        <span>Quản lý danh mục</span>
    </a>
    <ul class="sub">
        <li>
            <a href="{{route('unit.index')}}">
                <i class="fa fa-home"></i> Đơn vị
            </a>
        </li>

        <li>
            <a href="{{route('field.index')}}">
                <i class="fa fa-book"></i> Lĩnh vực
            </a>
        </li>

        @can('cohorts_programs')
        <li>
            <a href="{{asset('/cohorts-programs')}}">
                <i class="fa fa-sitemap"></i> Khóa học - Chương trình học
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan

@can('users_manage')
    <li class="sub-menu">
        <a>
            <i class="fa fa-users"></i>
            <span>Quản lý người dùng</span>
        </a>
        <ul class="sub">
            <li><a href="{{route('teachers')}}"><i class="fa fa-user-md"></i> Giảng viên </a></li>
            <li><a href="{{route('students')}}"><i class="fa fa-male"></i> Sinh viên </a></li>
        </ul>
    </li>
@endcan

<li>
    <a href="{{asset('/topics')}}">
        <i class="fa fa-columns"></i> <span>Đề tài khóa luận</span>
    </a>
</li>