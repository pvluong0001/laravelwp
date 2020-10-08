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
            @if($crud->canAccessRoute('create'))
                <div class="has-text-right mb-3">
                    <a href="{{ route($crud->getRouteNamePrefix() . '.create') }}" class="button is-success is-small">Create</a>
                </div>
            @endif
            @include('crud::' . $crud->getAssets())
        </div>
    </div>
@endsection
