@extends('layouts.admin')

@section('content')
    <x-flash-message/>

    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                Database Management
            </div>
        </div>

        <div class="card-content">
            <table class="table table-hover is-fullwidth">
                <thead>
                <tr>
                    <th>Table</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tables as $table)
                    <tr>
                        <td>{{ $table->getTableName() }}</td>
                        <td>
                            <a class="button is-success is-small" href="{{ route('builder.table', $table->getTableName()) }}">
                                <span class="icon">
                                    <i class="far fa-copy"></i>
                                </span>
                                <span>Create CRUD</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{ asset('library/jquery-3.5.1.min.js') }}"></script>
    <script>
        $(function() {
            $('.modal-button').on('click', function() {
                const target = $(this).data('target');
                const modal = $(`div[data-uuid=${target}]`);

                modal.toggleClass('is-active');
            });

            document.addEventListener('keyup', event => {
                if(event.keyCode === 27) {
                    $('.modal.is-active').removeClass('is-active');
                }
            })
        });
    </script>
@endpush
