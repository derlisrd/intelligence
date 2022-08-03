@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="col-12 col-sm-4 m-3">
        <label for="_accounts">Contas de anuncios</label>
        <select  class="form-select form-select-lg mb-3" id="_accounts" onchange="changeAccount()">
            <option value="" selected>Seleccionar</option>
            @foreach ($fbuser->ads_accounts as $account)
                <option value="{{ $account->account_id }}">{{ $account->name }}</option>
            @endforeach
        </select>
        <a href="javascript:void(0)" onclick="sincronizarAdCampaigns()" class="btn btn-primary">Sincronizar cuentas</a>
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
                            <th>CONTA</th>
                            <th>NOME DE CAMPANHA</th>
                            <th>OBJETIVO</th>
                            <th>ID CAMPANHA</th>
                            <th>ACCOES</th>
                        </tr>
                    </thead>
                    <tbody id="_tablebody">
                        <div class="d-flex justify-content-center mb-5 d-none" id="_loading">
                            <div class="spinner-grow" role="status">
                              <span class="sr-only">Loading...</span>
                            </div>
                          </div>

                        @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign['account_name'] }}</td>
                            <td>{{ $campaign['name'] }}</td>
                            <td>{{ $campaign['objective'] }}</td>
                            <td>{{ $campaign['campaign_id'] }}</td>
                            <td><a href="{{ route('relatorios.facebook.insights.campaign',[$fbuserid,$campaign['campaign_id']]) }}" class="btn btn-primary">Visoes</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
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

    function _cargando(cargando = true){

        if(cargando){
            document.getElementById("_loading").classList.remove("d-none");
        }
        else{
            document.getElementById('_loading').classList.add('d-none');
        }

    }
    async function changeAccount(){

        let fbuser_id = {{ $fbuser->id }}
        let sel = document.getElementById("_accounts");
        var opt = sel.options[sel.selectedIndex];

        if(opt.value && opt.value!==""){
            _cargando()
            document.getElementById('_tablebody').classList.add("d-none");
             param = opt.value;
            let res = await fetch("/relatorios/facebook/api/campaigns/"+param+"/"+fbuser_id)
            let data = await res.json();
            let campaigns = data.campaigns;
            let htmlcampaigns = cargarHtml(campaigns);

            document.getElementById('_tablebody').classList.remove('d-none');
            document.getElementById('_tablebody').innerHTML = htmlcampaigns;
            _cargando(false);
        }

    }

    function cargarHtml (campaigns){
        let htmlcampaigns = "";
        campaigns.forEach(e=> {
        htmlcampaigns +=
        `<tr><td>${e.name}</td><td>${e.account_name }</td><td>${e.objective}</td><td>${e.id}</td><td><a href="/relatorios/facebook/{{ $fbuserid }}/${e.campaign_id}/insights" class="btn btn-primary">Visoes</a></td></tr>`;
        })
        return htmlcampaigns;
    }

    async function sincronizarAdCampaigns(){
        _cargando();
        let fbuser_id = {{ $fbuser->id }}
        let res = await fetch("/relatorios/facebook/api/sinc_adcampaigns/"+fbuser_id)
        let datas = await res.json();
        cargarHtml(datas);
        _cargando(false);
    }
</script>

@endsection
