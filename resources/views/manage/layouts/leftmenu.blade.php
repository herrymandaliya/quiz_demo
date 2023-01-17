<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{!! (isset($menu_dashboard) && $menu_dashboard) ? 'active' : '' !!}">
                    <a href="{{ url_admin('dashboard') }}">
                        <i class="la la-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(isset(auth('admin')->user()->user_id))
                <li class="{!! (isset($menu_designations) && $menu_designations) ? 'active' : '' !!}">
                    <a href="{{ url_admin('quiz') }}">
                        <i class="la la-user"></i>
                        <span>Quiz</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
