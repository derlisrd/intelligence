@extends("layouts.app")

@section("title","Relatorio facebook | Campanha")
@section("breadcrumb","Campanha")
@section("currentpage","Campanha de facebook")

@section("container")
<div class="row">
    <div class="card p-2">
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="home" role="tabpanel">
                 <div class="table-responsive" id="_table-responsive">
                     <h3 class="card-title p-2">
                        Campanha
                     </h3>
                     <table id="myTable" class="table table-striped table-bordered">
                         <thead>
                             <tr>
                                 <th><b>Conta</b></th>
                                 <th><b>Pais</b></th>
                                 <th><b>Nome</b></th>
                                 <th><b>Custo</b></th>
                                 <th><b>Impressao</b></th>
                                 <th><b>Status</b></th>
                                 <th><b>Clicks</b></th>
                                 <th><b>Cpm</b></th>
                                 <th><b>Cpc</b></th>
                                 <th><b>Criacao</b></th>
                             </tr>
                         </thead>
                         <tbody id="_tablebody">
                             @foreach ($campaigns as $campaign)
                                <tr>
                                    <td><b>{{ $campaign['account_name'] }}</b></td>
                                    <td>{{ $campaign['country'] }}</td>
                                    <td>{{ $campaign['campaign_name'] }}</td>
                                    <td><b>R$. {{ $campaign['spend'] }}</b></td>
                                    <td><b>{{ $campaign['impressions'] }}</b></td>
                                    <td><b>{{ $campaign['status'] }}</b></td>
                                    <td><b>{{ $campaign['clicks'] }}</b></td>
                                    <td><b>R$. {{ $campaign['cpm'] }}</b></td>
                                    <td><b>R$. {{ $campaign['cpc'] }}</b></td>
                                    <td><b>{{ $campaign['created_time'] }}</b></td>
                                </tr>
                             @endforeach
                         </tbody>
                         <tfoot>
                             <tr>
                                <th><b>Conta</b></th>
                                 <th><b>Pais</b></th>
                                 <th><b>Nome</b></th>
                                 <th><b>Custo</b></th>
                                 <th><b>Impressao</b></th>
                                 <th><b>Status</b></th>
                                 <th><b>Clicks</b></th>
                                 <th><b>Cpm</b></th>
                                 <th><b>Cpc</b></th>
                                 <th><b>Criacao</b></th>
                             </tr>
                         </tfoot>
                     </table>
                 </div>
            </div>
            <div class="tab-pane  p-20" id="profile" role="tabpanel">
                <h4 class="text-center p-3">Coming soon</h4>
            </div>
            <div class="tab-pane p-20" id="messages" role="tabpanel">
                <h4 class="text-center p-3">Coming soon</h4>
            </div>
        </div>
    </div>
</div>
@endsection
