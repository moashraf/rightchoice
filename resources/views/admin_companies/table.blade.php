@section('third_party_stylesheets')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table([
    'width' => '100%',
    'class' => 'table table-striped table-bordered',
    'id' => 'companies-table'
]) !!}

@section('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function () {
            let table = $('#companies-table').DataTable();

            table.on('order.dt search.dt draw.dt', function () {
                let info = table.page.info();

                table.column(0, { search: 'applied', order: 'applied', page: 'current' })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = info.start + i + 1;
                    });
            }).draw();
        });
    </script>
@endsection
