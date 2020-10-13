@extends('layouts.admin')

@push('after_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                {{ $table->getTableName() }}
            </div>
        </div>

        <div class="card-content">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-title">
                        Columns
                    </div>
                </div>
                <div class="card-content">
                    <form action="{{ route('builder.store', $table->getTableName()) }}" method="POST">
                        @csrf
                        <div class="columns">
                            <div class="column is-9">
                                <table class="table table-hover is-fullwidth">
                                    <tbody>
                                    <tr>
                                        <td>Select</td>
                                        <td>
                                            <table class="table is-bordered is-fullwidth">
                                                @foreach($table->getColumns() as $column)
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="columnsDef[]" checked value="{{ $column->getName() }}">
                                                                {{ $column->getName() }}
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {!! $columnsSelect !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Create/Update</td>
                                        <td>
                                            <table class="table is-bordered is-fullwidth">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Create Request</th>
                                                    <th>Update Request</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($table->getColumnsExcept() as $column)
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="fieldsDef[]" checked value="{{ $column->getName() }}">
                                                                {{ $column->getName() }}
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {!! $columnsField !!}
                                                        </td>
                                                        <td width="250">
                                                            <select name="createRequests[{{ $column->getName() }}][]" class="rules select is-fullwidth" multiple>
                                                                {!! $requestRulesHtml !!}
                                                            </select>
                                                        </td>
                                                        <td width="250">
                                                            <select name="updateRequests[{{ $column->getName() }}][]" class="rules select is-fullwidth" multiple>
                                                                {!! $requestRulesHtml !!}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card column is-3">
                                <div class="card-header">
                                    <div class="card-header-title">Settings</div>
                                </div>
                                <div class="card-content">
                                    <div class="field">
                                        <input id="switchExample" type="checkbox" name="create_model" value="1" class="switch is-rtl" checked>
                                        <label for="switchExample">Create new model</label>
                                    </div>
                                    <div class="field is-hidden" id="model">
                                        <div class="control">
                                            <input class="input is-primary" name="model" type="text" placeholder="Model namespace">
                                        </div>
                                    </div>
                                    <div id="modelSettings">
                                        <p class="subtitle is-5 has-text-black">Fillable</p>
                                        <div>
                                            <ul class="list">
                                                @foreach($table->getColumnsExcept() as $column)
                                                <li>
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="fillables[]" checked value="{{ $column->getName() }}">
                                                        {{ $column->getName() }}
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="pt-3">
                                        <p class="subtitle is-5 has-text-black">Request</p>
                                        <ul class="list">
                                            <li>
                                                <label class="checkbox">
                                                    <input type="checkbox" name="request[create]" checked value="1">
                                                    Create Request
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox">
                                                    <input type="checkbox" name="request[update]" checked value="1">
                                                    Update Request
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="has-text-right">
                            <a href="{{ route('builder.index') }}" class="button">Back</a>
                            <button class="button is-primary">Create CRUD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{ asset('library/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('.rules').select2({
            tags: true
        });

        $('#switchExample').on('change', function() {
            const checked = $(this).is(':checked');
            const modelWrapper = $("#model");
            const modelInput = $("input[name=model]")

            if(checked) {
                modelWrapper.addClass('is-hidden');
                modelInput.removeAttr('required');
            } else {
                modelWrapper.removeClass('is-hidden');
                modelInput.attr('required', 'required');
            }
        })
    </script>
@endpush
