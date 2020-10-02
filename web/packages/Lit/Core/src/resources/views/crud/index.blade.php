@extends($crud->getLayout())

@section('content')
    @php
        $columns = $crud->getColumns();
    @endphp
    <div class="card">
        <input type="hidden" name="csrf_token" value="{{csrf_token()}}">
        <input type="hidden" name="config_path" value="{{ route($crud->getRouteNamePrefix() . '.config') }}">
        <input type="hidden" name="data_path" value="{{ route($crud->getRouteNamePrefix() . '.search') }}">
        <div class="card-header">
            <div class="card-header-title">
                <div class="title is-4">
                    {{ $crud->getTitle() }}
                </div>
            </div>
        </div>
        <div class="card-content" id="list">
            <list-component/>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{asset('js/list.js')}}"></script>
@endpush
