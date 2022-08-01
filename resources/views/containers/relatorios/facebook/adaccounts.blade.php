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
    async function changeAccount(e){
        let act_account_id = e.value;
        let fbuser_id = {{ $fbuser->id }}

        if(act_account_id){
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
            let body = document.getElementById('_tablebody');
            body.innerHTML = htmlcampaigns;
        }

    }
</script>

@endsection
