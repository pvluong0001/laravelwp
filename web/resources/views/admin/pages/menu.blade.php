@extends('layouts.admin')

@push('after_scripts')
    <script src="{{asset('library/js/jquery-3.5.1.min.js')}}"></script>
@endpush

@section('content')
    <div class="container is-fluid">
        <x-breadcrumbs></x-breadcrumbs>

        <div class="card">
            <div class="card-header">
                <div class="card-header-title title is-4">
                    Menu settings
                </div>
            </div>
        </div>
    </div>
@endsection
