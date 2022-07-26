@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Facebook</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>STATUS</th>
                            <th>INICIO</th>
                            <th>FIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>
                                    <a href="{{ url('/relatorios/facebook/campaign/'. $campaign['id']."/user".'/'.$userid) }}">{{ $campaign['name'] }}</a>
                                </td>
                                <td>{{ $campaign['status'] }}</td>
                                <td>{{ $campaign['start_time']}}</td>
                                <td>{{ $campaign['end_time'] }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
                            <th>STATUS</th>
                            <th>INICIO</th>
                            <th>FIN</th>
                        </tr>
                    </tfoot>
                </table>
    </div>
</div>

@endsection
