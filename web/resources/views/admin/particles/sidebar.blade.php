<div class="column is-2 is-sidebar-menu is-hidden-mobile">
    <aside class="menu">
        @foreach($menu as $group)
            <p class="menu-label">
                {{ $group['label'] }}
            </p>
            <ul class="menu-list">
                @foreach($group['child'] as $item)
                    <li>
                        <a href="{{ $item['link'] }}">{{ $item['label'] }}</a>
                        @if(isset($item['child']) && $item['child'])
                            <ul>
                                @foreach($item['child'] as $submenu)
                                    <li><a href="{{ $submenu['link'] }}">{{ $submenu['label'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    </aside>
</div>
