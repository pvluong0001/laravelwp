@extends($crud->getLayout())

@section('content')
    @php
        $columns = $crud->getColumns();
    @endphp
    <div class="card">
        <input type="hidden" name="csrf_token" value="{{csrf_token()}}">
        <input type="hidden" name="config_path" value="{{ route($crud->getRouteNamePrefix() . '.config') }}">
        <input type="hidden" name="data_path" value="{{ route($crud->getRouteNamePrefix() . '.search') }}">
        <input type="hidden" name="search_path" value="{{ route($crud->getRouteNamePrefix() . '.search') }}">
        <div class="card-header">
            <div class="card-header-title">
                <div class="title is-4">
                    {{ $crud->getTitle() }}
                </div>
            </div>
        </div>
        <div class="card-content">
            @include('crud::' . $crud->getAssets())
{{--            @if($crud->getAssets())--}}
{{--                --}}
{{--            @else--}}
{{--                <table class="table is-bordered is-fullwidth">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        @foreach($crud->getColumns() as $column)--}}
{{--                            <th class="is-capitalized">{{ $column['label'] ?? $column['name'] }}</th>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody id="render-box"></tbody>--}}
{{--                </table>--}}
{{--            @endif--}}
        </div>
    </div>
@endsection

{{--@push('after_scripts')--}}
{{--    @if($crud->getAssets())--}}
{{--        <script src="{{asset('js/list.js')}}"></script>--}}
{{--    @else--}}
{{--        <script src="{{asset('js/list-standard.js')}}"></script>--}}
{{--        <script>--}}
{{--            ListStandardPlugin.fetchData();--}}
{{--        </script>--}}
{{--    @endif--}}
{{--@endpush--}}
