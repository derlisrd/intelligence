@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="col-sm d-flex align-items-center flex-column mt-2">
        <label for="_accounts">Contas de anuncios</label>
        <select  class="form-select form-select-lg" id="_accounts" >
            <option value="" selected>Seleccionar</option>
            @foreach ($fbuser->ads_accounts as $account)
                <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm d-flex align-items-center mt-2">
        <div class="">
            <label for="_since" class="form-label">Desde</label>
            <input type="date" name="since" id="_since" class="form-control form-control-lg"  />
        </div>
        <div class="">
            <label for="_since" class="form-label">Ate</label>
            <input type="date" name="since" id="_since" class="form-control form-control-lg"  />
        </div>
    </div>
</div>





<div class="d-flex flex-row">
    <div class="m-2">
        <a href="javascript:void(0)" onclick="getCampaignsByAccountId()" class="btn btn-primary btn-lg">Filtrar</a>
    </div>
</div>


<div class="row">
    <div class="card p-2">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Campanhas</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Conjunto de anuncios</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#messages"onchange=""
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
                                 <th><b>CONTA</b></th>
                                 <th><b>CAMPANHA</b></th>
                                 <th><b>PAIS</b></th>
                                 <th><b>CUSTO</b></th>
                                 <th><b>USS</b></th>
                                 <th><b>IMPRESSOES</b></th>
                                 <th><b>CLICKS</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CPC</b></th>
                                 <th><b>DATA DE CRIAÇAO</b></th>
                             </tr>
                         </thead>
                         <tbody id="_tablebody">
                             <div class="progress my-3 d-none" id="_loading">
                                 <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                             </div>


                         </tbody>
                         <tfoot>
                             <tr>
                                <th><b>CONTA</b></th>
                                 <th><b>CAMPANHA</b></th>
                                 <th><b>PAIS</b></th>
                                 <th><b>CUSTO</b></th>
                                 <th><b>USS</b></th>
                                 <th><b>IMPRESSOES</b></th>
                                 <th><b>CLICKS</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CPC</b></th>
                                 <th><b>DATA DE CRIAÇAO</b></th>
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

<script>



    async function getCampaignsByAccountId() {
        let fbuser_id = {{ $fbuser->id }}
        let valordolar = parseFloat( {{ $valordolarreal; }})
        const dosdecimales = n => ( Math.round((parseFloat(n)) * 100) / 100).toFixed(2)
        const calcular = m => ((Math.round((parseFloat(m)/valordolar) * 100) / 100).toFixed(2) )
        let sel = document.getElementById("_accounts");
        var opt = sel.options[sel.selectedIndex];
        let url = opt.value === "" ? "{{ route('api.all.facebook.getCampaigns') }}" : "/api/facebook/campaigns/act_"+opt.value+"/"+fbuser_id
        _cargando();
        let res = await fetch(url)
        let json = await res.json();
        let html = "";
        json.data.forEach(e=> {
            html +=
                `<tr>
                    <td>
                        <b>${e.account_name}</b>
                    </td>
                    <td>${e.campaign_name}</td>
                    <td><b>${e.country}</b></td>
                    <td>${dosdecimales(e.spend)} <b>${e.account_currency}</b></td>
                    <td>${calcular(e.spend)} USS</td>
                    <td>${e.impressions}</td>
                    <td>${e.clicks}</td>
                    <td>${dosdecimales(e.cpm)}</td>
                    <td>${e.cpc}</td>
                    <td>${e.created_time}</td>
                </tr>`;
            })
        _cargando(false);
        document.getElementById('_tablebody').innerHTML = html;
     }




    function _cargando(cargando = true){
        cargando ? document.getElementById("_loading").classList.remove("d-none") :  document.getElementById('_loading').classList.add('d-none');
    }


</script>

@endsection
