@extends("layouts.app")

@section("title","Relatorios facebook")

@section("breadcrumb","Relatorios de facebook")

@section("currentpage","facebook")

@section("container")

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Insigns</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>IMPRESSOES</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>CLICKS</th>
                            <th>CTR %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign['campaign_name'] }}</td>
                                <td><b>{{ $campaign['impressions'] }}</b></td>
                                <td>{{ round($campaign['cpm'],2) }}</td>
                                <td>{{ round($campaign['cpc'],2)}}</td>
                                <td>{{ $campaign['clicks'] }}</td>
                                <td>{{ round($campaign['ctr'], 2) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
                            <th>IMPRESSOES</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>CLICKS</th>
                            <th>CTR %</th>
                        </tr>
                    </tfoot>
                </table>
    </div>
</div>



@endsection
