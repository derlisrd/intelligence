@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="col-12 col-sm-4 m-3">
        <label for="accounts">Contas de anuncios</label>
        <select  class="form-select form-select-lg mb-3" id="accounts" onchange="changeAccount(this)">
            <option value="">Seleccionar</option>
            @foreach ($fbuser->ads_accounts as $account)
                <option value="{{ $account->account_id }}">{{ $account->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
               Campanhas
            </h3>

            <div class="table-responsive" id="_table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>OBJETIVO</th>
                            <th>ID CAMPANHA</th>
                            <th>ACCOES</th>
                        </tr>
                    </thead>
                    <tbody id="_tablebody">
                        <tr id="_loading" class="d-none" ><td align="center" colspan="4"><h4>Carregando...</h4></td></tr>
                        @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign['name'] }}</td>
                            <td>{{ $campaign['objective'] }}</td>
                            <td>{{ $campaign['id'] }}</td>
                            <td><a href="{{ route('relatorios.facebook.insights.campaign',[$fbuserid,$campaign['id']]) }}" class="btn btn-primary">Visoes</a></td>
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

<script>
    const id = e => document.getElementById(e);
    async function changeAccount(e){
        let act_account_id = e.value;
        let fbuser_id = {{ $fbuser->id }}

        if(act_account_id){
            id('_loading').classList.remove("d-none")
            param = act_account_id;
            let res = await fetch("/relatorios/facebook/api/campaigns/"+param+"/"+fbuser_id)
            let data = await res.json();
            let campaigns = data.campaigns;
            let htmlcampaigns = "";
            campaigns.forEach(e=> {
                htmlcampaigns += `<tr>
                                <td>${e.name }</td>
                                <td>${e.objective}</td>
                                <td>${e.id}</td>
                                <td><a href="/relatorios/facebook/${fbuser_id}/${e.id}/insights" class="btn btn-primary">Visoes</a></td>
                            </tr>`;
            })
            id('_tablebody').innerHTML = htmlcampaigns;

        }
        id('_loading').classList.add("d-none")
    }
</script>

@endsection
