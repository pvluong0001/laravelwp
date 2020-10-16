@extends('layouts.admin')

@section('content')
    <div class="container is-fluid">
        <x-breadcrumbs></x-breadcrumbs>

        <div class="card">
            <div class="card-header">
                <div class="card-header-title title is-4">
                    Menu settings
                </div>
            </div>
            <div class="card-content">
                <iframe src="/laravel-filemanager" style="width: 100%; height: 700px; overflow: hidden;"></iframe>
            </div>
        </div>
    </div>
@endsection
