@push('after_styles')
    <link rel="stylesheet" href="{{ asset('library/DataTables/datatables.min.css') }}">
    <style>
        .disabled {
            pointer-events: none;
        }
    </style>
@endpush

<table class="table is-bordered is-fullwidth pt-3" id="list">
    <thead>
    <tr>
        @foreach(array_column($columns, 'data') as $column)
        <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tfoot>
    <tr class="has-background-grey-lighter">
        @foreach(array_column($columns, 'data') as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </tfoot>
</table>

@push('after_scripts')
    <script src="{{ asset('library/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('library/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/DataTables/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function () {
            $.fn.dataTable.ext.classes.sPageButton = 'button mx-1'
            $.fn.dataTable.ext.classes.sPageButtonActive = 'current is-primary is-outlined'
            $.fn.dataTable.ext.classes.sPageButtonDisabled = 'disabled'

            const columns = @json($columns);

            $('#list thead tr').clone(true).appendTo('#list thead')
            $('#list thead tr:eq(1) th').each(function (i) {
                var title = $(this).text()
                $(this).html('<input type="text" class="input is-small pr-0 search-column" placeholder="Search ' + title + '" />')

                $('input', this).on('keyup', function (event) {
                    if (table.column(i).search() !== this.value && event.keyCode === 13) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw()
                    }
                })
            })

            const table = $('#list').DataTable({
                dom: 'flBrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: document.querySelector('input[name="search_path"]').value,
                    type: 'POST',
                    data: {
                        _token: document.querySelector('input[name="csrf_token"]').value
                    }
                },
                columns,
                orderCellsTop: true,
                buttons: [
                    {
                        text: 'Clear search',
                        action: () => {
                            table.search('')
                                .columns().search('')
                                .draw();

                            $('.search-column').val('')
                        },
                        className: 'button is-small is-success ml-3',

                    }
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select class="select is-fullwidth"><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            })

            $('#list_filter input').unbind()
            $('#list_filter input').bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    table.search(this.value).draw()
                }
            })
        })
    </script>
@endpush
