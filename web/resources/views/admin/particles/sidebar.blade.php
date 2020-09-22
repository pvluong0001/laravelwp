<div class="column is-2 is-sidebar-menu is-hidden-mobile">
    <aside class="menu">
        <p class="menu-label">
            General
        </p>
        <ul class="menu-list">
            <li><a href="{{route('home')}}">Dashboard</a></li>
            <li><a>Customers</a></li>
        </ul>
        <p class="menu-label">
            Administration
        </p>
        <ul class="menu-list">
            <li><a>Team Settings</a></li>
            <li><a href="{{route('settings.plugins.index')}}">Plugins</a></li>
            <li>
                <a class="is-active">Settings</a>
                <ul>
                    <li><a href="{{route('settings.menu')}}">Menus</a></li>
{{--                    <li><a>Plugins</a></li>--}}
{{--                    <li><a>Add a member</a></li>--}}
                </ul>
            </li>
{{--            <li><a>Invitations</a></li>--}}
{{--            <li><a>Cloud Storage Environment Settings</a></li>--}}
{{--            <li><a>Authentication</a></li>--}}
        </ul>
        <p class="menu-label">
            Transactions
        </p>
        <ul class="menu-list">
            <li><a>Payments</a></li>
            <li><a>Transfers</a></li>
            <li><a>Balance</a></li>
        </ul>
    </aside>
</div>
