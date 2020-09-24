@extends('layouts.admin')

@section('content')
    <div class="container is-fluid">
        <x-breadcrumbs></x-breadcrumbs>

        <div class="card">
            <div class="card-header">
                <div class="card-header-title">
                    Plugins
                </div>
                <div class="mt-2 mr-2">
                    <a class="button is-success is-small" href="{{ route('settings.plugins.create') }}">Install</a>
                </div>
            </div>

            <div class="card-content">
                <table class="table is-striped is-hoverable is-fullwidth">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Hash</th>
                        <th width="100" align="right">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->hash }}</td>
                        <td align="right">
                            @if($module->enabled)
                                <x-tag text="enabled" class="is-success"/>
                            @else
                                <x-tag text="Disabled" class="is-light"/>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
