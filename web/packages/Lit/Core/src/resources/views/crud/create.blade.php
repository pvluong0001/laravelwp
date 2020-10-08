@extends($crud->getLayout())

@section('content')
    @if($gridTemplate = $crud->getLayoutCreateGridTemplate())
        <style>
        .content-container {
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template: {!! $gridTemplate !!};
            grid-gap: 20px;
            margin-bottom: 20px;
        }

        .grid > div {
            border: 1px solid #c2c2c2;
        }
        </style>
    @endif

    <div class="content-container mr-2">
        <form action="{{ route($crud->getRouteNamePrefix() . '.store') }}" method="POST">
            @csrf
            <div class="title is-4">
                Title Sample
            </div>

            <div class="grid">
                @if($grid = $crud->getLayoutCreateGrid())
                    @php
                        $fields = $crud->getFields();
                    @endphp
                    @foreach($grid as $gridArea => $item)
                        <div class="card" style="grid-area: {{ $gridArea }}">
                            <div class="card-header has-background-grey-dark">
                                <div class="card-header-title has-text-white">
                                    {{ $item['title'] ?? $gridArea }}
                                </div>
                            </div>
                            <div class="card-content">
                                @foreach(($fields[$gridArea] ?? []) as $field)
                                    <div class="field">
                                        <label class="label is-capitalized">{{ $field['label'] ?? $field['name'] }}</label>
                                        <div class="control">
                                            <input type="email" name="{{ $field['name'] }}" class="input">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card mb-4">
                        <div class="card-header has-background-grey-dark">
                            <div class="card-header-title has-text-white">
                                {{ $crud->getTitle() }}
                            </div>
                        </div>
                        <div class="card-content">
                            @foreach($crud->getFields() as $field)
                                @include('crud::fields.' . ($field['type'] ?? 'text'))

                                @error($field['name'])
                                <div class="has-text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="has-text-right">
                <a href="{{ route($crud->getRouteNamePrefix() . '.index') }}" class="button">Cancel</a>
                <button class="button is-success">Create</button>
            </div>
        </form>
    </div>
@endsection
