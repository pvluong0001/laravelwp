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

    <div class="content-container">
        <div class="title is-4">
            Title Sample
        </div>

        <div class="grid">
            @if($grid = $crud->getLayoutCreateGrid())
                @php
                    $columns = $crud->getColumns();
                @endphp
                @foreach($grid as $gridArea => $item)
                    <div class="card area1" style="grid-area: {{ $gridArea }}">
                        <div class="card-header has-background-info-light">
                            <div class="card-header-title">
                                {{ $item['title'] ?? $gridArea }}
                            </div>
                        </div>
                        <div class="card-content">
                            @foreach(($columns[$gridArea] ?? []) as $column)
                                <div class="field">
                                    <label class="label">{{ $column['label'] ?? $column['name'] }}</label>
                                    <div class="control">
                                        <input type="email" name="{{ $column['name'] }}" class="input">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
            @endif
        </div>

        <div class="has-text-right">
            <a href="#" class="button is-warning">Cancel</a>
            <button class="button is-success">Create</button>
        </div>
    </div>
@endsection
