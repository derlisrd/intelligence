@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Basic Datatable</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Inicio</th>
                            <th>Fin</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{  $campaign['id'] }}</td>
                                <td>{{ $campaign['name'] }}</td>
                                <td>{{ $campaign['status'] }}</td>
                                <td>{{ $campaign['start_time']}}</td>
                                <td>{{ $campaign['end_time'] }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                        </tr>
                    </tfoot>
                </table>
    </div>
</div>

@endsection
