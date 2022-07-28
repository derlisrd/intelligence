@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Campaigns</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>OBJETIVO</th>
                            <th>ID CAMPANHA</th>
                            <th>ACCOES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign['name'] }}</td>
                                <td>{{ $campaign['objective'] }}</td>
                                <td>{{ $campaign['id'] }}</td>
                                <td><a href="#" class="btn btn-primary">Visoes</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
                            <th>OBJETIVO</th>
                            <th>ID CAMPANHA</th>
                            <th>ACCOES</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
