@if(config('global.admin.showBreadcrumbs') && $breadcrumbs = config('global.admin.breadcrumbs'))
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            @foreach($breadcrumbs as $item)
            <li><a href="{{$item['href'] ?? '#'}}">{{$item['label']}}</a></li>
            @endforeach
        </ul>
    </div>
@endif
