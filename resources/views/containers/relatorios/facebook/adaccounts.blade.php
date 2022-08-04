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
                <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
            @endforeach
        </select>
        <a href="javascript:void(0)" onclick="sincronizarAdCampaigns()" class="btn btn-primary">Sincronizar cuentas</a>
    </div>
    <div class="card p-2">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Campanhas</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Conjunto de anuncios</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#messages"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Anuncios</span></a> </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="home" role="tabpanel">
                 <div class="table-responsive" id="_table-responsive">
                     <h3 class="card-title p-2">
                        Campanhas
                     </h3>
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
                             <div class="progress my-3 d-none" id="_loading">
                                 <div class="progress-bar progress-bar-striped progress-bar-animated bg-cyan" style="width:100%"></div>
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
            <div class="tab-pane  p-20" id="profile" role="tabpanel">
                <div class="table-responsive" id="_table-responsive">
                    <h3 class="card-title p-2">
                       Conjunto de anuncios
                    </h3>
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
                            <div class="progress my-3 d-none" id="_loading">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-cyan" style="width:100%"></div>
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
            <div class="tab-pane p-20" id="messages" role="tabpanel">
                <div class="table-responsive" id="_table-responsive">
                    <h3 class="card-title p-2">
                       Anuncios
                    </h3>
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
                            <div class="progress my-3 d-none" id="_loading">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-cyan" style="width:100%"></div>
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
            console.log(data)
            let html = "";
            /* campaigns.forEach(e=> {
                html +=
                `<tr><td>${opt.text}</td><td>${e.name }</td><td>${e.objective}</td><td>${e.id}</td><td><a href="/relatorios/facebook/{{ $fbuserid }}/${e.id}/insights" class="btn btn-primary">Visoes</a></td></tr>`;
            }) */

            document.getElementById('_tablebody').classList.remove('d-none');
            document.getElementById('_tablebody').innerHTML = html;
            _cargando(false);
        }

    }

    function cargarHtml (campaigns){
        let htmlcampaigns = "";

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
