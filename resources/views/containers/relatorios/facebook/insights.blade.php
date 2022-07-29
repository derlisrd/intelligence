@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Metricas de campanha</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>CAMPANHA</th>
                            <th>MOEDA</th>
                            <th>CUSTO</th>
                            <th>IMPRESSOES</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>CTR</th>
                            <th>CLICKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insights as $insight)
                            <tr>
                                <td>{{ $insight['campaign_name'] }}</td>
                                <th>{{ $insight['account_currency'] }}</th>
                                <td>{{ $insight['spend'] }}</td>
                                <td>{{ $insight['impressions'] }}</td>
                                <td>{{ round($insight['cpm'],2) }}</td>
                                <td>{{ round($insight['cpc'],2) }}</td>
                                <td>{{ round($insight['ctr'],2) }}</td>
                                <td> {{ $insight['clicks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>CAMPANHA</th>
                            <th>MOEDA</th>
                            <th>CUSTO</th>
                            <th>IMPRESSOES</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>CTR</th>
                            <th>CLICKS</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
