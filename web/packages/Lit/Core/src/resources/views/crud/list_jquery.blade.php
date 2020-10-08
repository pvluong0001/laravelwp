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
        <th></th>
    </tr>
    </thead>
    <tfoot>
    <tr class="has-background-grey-lighter">
        @foreach(array_column($columns, 'data') as $column)
            <th>{{ $column }}</th>
        @endforeach
        <th></th>
    </tr>
    </tfoot>
</table>

<script id='infoWindowTemplate' type='text/x-jquery-tmpl'>
    <span>
    <div class="has-text-centered">
        <a href="{{ route($crud->getRouteNamePrefix() . '.edit', '???') }}" class="has-text-warning-dark"><i class="fas fa-edit"></i></a>
        <form class="is-inline" action="{{ route($crud->getRouteNamePrefix() . '.delete', '???') }}" method="POST">
            @csrf
            @method('DELETE')
            <a href="#" class="has-text-danger edit-btn"><i class="fas fa-trash"></i></a>
        </form>
    </div>
    </span>
</script>

@push('after_scripts')
    <script src="{{ asset('library/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('library/jquery-tmpl/jquery.tmpl.min.js') }}"></script>
    <script src="{{ asset('library/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/DataTables/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function () {
            $.fn.dataTable.ext.classes.sPageButton = 'button mx-1'
            $.fn.dataTable.ext.classes.sPageButtonActive = 'current is-primary is-outlined'
            $.fn.dataTable.ext.classes.sPageButtonDisabled = 'disabled'

            const columns = @json($columns);

            columns.push({
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    const template = $("#infoWindowTemplate").tmpl({}).html();

                    return template.replaceAll('???', row.id);
                }
            })

            $('#list thead tr').clone(true).appendTo('#list thead')
            $('#list thead tr:eq(1) th:not(:last-child)').each(function (i) {
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

            $(document).on('click', '.edit-btn', function() {
               $(this).closest('form').submit();
            });

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
                                .draw()

                            $('.search-column').val('')
                        },
                        className: 'button is-small is-success ml-3',

                    }
                ],
                initComplete: function () {
                    const columnsLength = columns.length;

                    this.api().columns().every(function (index) {
                        if(++index === columnsLength) {
                            return;
                        }
                        var column = this
                        var select = $('<select class="select is-fullwidth"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                )

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw()
                            })

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        })
                    })
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
