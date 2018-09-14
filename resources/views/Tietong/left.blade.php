<!-- 左边导航菜单 -->
<div class="nav">
    <ul>

        @if($user['young_account_number'] == 'admins')
            <li @if($route[0] == 'tietong-master')class="choice"@endif>
                <a href="/tietong-master">
                    {{--<span class="icon_easel nav-icon"></span>--}}
                    <span class="nav-text">管理员列表</span>
                </a>
            </li>

            <li @if(($route[0] == 'tietong-area') || ($route[0] == 'tietong-hall'))class="choice"@endif>
                <a href="/tietong-area">
                    {{--<span class="icon_easel nav-icon"></span>--}}
                    <span class="nav-text">分中心列表</span>
                </a>
            </li>

            {{--<li @if($route[0] == 'tietong-companies')class="choice"@endif>
                <a href="/tietong-hall">
                    --}}{{--<span class="icon_easel nav-icon"></span>--}}{{--
                    <span class="nav-text">公司列表</span>
                </a>
            </li>--}}
        @endif
        <li @if($route[0] == 'tietong-man')class="choice"@endif>
            <a href="/tietong-man">
                {{--<span class="icon_easel nav-icon"></span>--}}
                <span class="nav-text">员工列表</span>
            </a>
        </li>
    </ul>
</div>