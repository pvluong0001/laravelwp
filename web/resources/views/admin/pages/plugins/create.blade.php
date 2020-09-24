@extends('layouts.admin')

@section('content')
    <div class="container is-fluid">
        <x-breadcrumbs></x-breadcrumbs>

        <div class="card">
            <div class="card-header">
                <div class="card-header-title">
                    Create plugins
                </div>
                <div class="mt-2 mr-2">
                    <a class="pointer" href="{{ route('settings.plugins.index') }}"><i class="fas fa-angle-double-left"></i></a>
                </div>
            </div>
            <div class="card-content">
                <div class="subtitle is-4">Upload your settings:</div>
                <form action="{{route('settings.plugins.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="file-js-example" class="file has-name">
                        <label class="file-label">
                            <input class="file-input" type="file" name="file" required accept=".zip">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Choose a file…
                                </span>
                            </span>
                            <span class="file-name">
                                No file uploaded
                            </span>
                        </label>
                        <button class="button is-success ml-4">Save</button>
                    </div>
                </form>
                <div class="subtitle is-4 mt-4">Store</div>
                <div class="subtitle is-4 mt-4">Installed</div>
                <div class="columns is-multiline is-mobile is-variable is-5">
                    @foreach($modules as $module)
                    <div class="column is-4">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-4">{{ $module->name }}</p>
                                        <p class="subtitle is-6">@johnsmith</p>
                                    </div>
                                </div>

                                <div class="content">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                                    <a href="#">#css</a> <a href="#">#responsive</a>
                                    <br>
                                    <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                                </div>

                                <div class="has-text-right">
                                    <x-button text="Remove" size="is-small" class="is-danger"/>
                                    <x-button text="Activated" size="is-small" class="is-success"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script>
        const fileInput = document.querySelector('#file-js-example input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
                const fileName = document.querySelector('#file-js-example .file-name');
                fileName.textContent = fileInput.files[0].name;
            }
        }

        // const socket = new WebSocket('ws://localhost:1357');
        //
        // socket.onopen = function(event) {
        //     console.log('WebSocket is connected.');
        // };
        //
        // socket.onerror = error => {
        //     console.log(error)
        // }
        //
        // socket.onmessage = event => {
        //     console.log(event.data, '~~~~~~~~')
        // }
    </script>
@endpush
