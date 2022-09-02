@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")
<form method="post" action={{ route('relatorios.postCampaigns') }}>
    @csrf
    <input type="hidden" name="fbuserid" value="{{ $fbuserid }}" />
    <div class="row">
        <div class="col-sm d-flex align-items-center flex-column mt-2">
            <label for="_accounts">Contas de anuncios</label>
            <select  class="form-select form-select-lg" name="account_id" id="_accounts" >
                <option value="">Seleccionar conta</option>
                @foreach ($ads_accounts as $v)
                    <option value="{{ $v->account_id }}" @if($v->account_id==$account_id) selected @endif >{{ $v->account_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm d-flex align-items-center flex-column mt-2">
            <label for="_country">País</label>
            <select  class="form-select form-select-lg" name="country" id="_country" >
                <option value="" >Seleccionar pais</option>
                @foreach ($paises as $p)
                    <option value="{{ $p->name }}" @if($p->name==$country) selected @endif>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm d-flex align-items-center mt-2">
            <div class="">
                <label for="_since" class="form-label">Desde</label>
                <input type="date" name="since" value="{{ $since ?? '' }}" id="_since" class="form-control form-control-lg"  />
            </div>
            <div class="">
                <label for="_since" class="form-label">Ate</label>
                <input type="date" name="to" id="_ate" value="{{ $to ?? '' }}" class="form-control form-control-lg"  />
            </div>
        </div>
    </div>

    <div class="d-flex flex-row">
        <div class="m-2">
            <button type="submit" class="btn btn-primary btn-lg">Filtrar</a>
        </div>
    </div>
</form>


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
                     <table id="myTable" class="table table-striped table-bordered">
                         <thead>
                             <tr>
                                 <th><b>Conta</b></th>
                                 <th><b>Data</b></th>
                                 <th><b>Pais</b></th>
                                 <th><b>Campanha</b></th>
                                 <th><b>Custo</b></th>
                                 <th><b>Impressoes</b></th>
                                 <th><b>Status</b></th>
                                 <th><b>Clicks</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CPC</b></th>
                                 <th><b>CTR</b></th>
                                 <th><b>Pixel</b></th>
                                 <th><b>Criaçao</b></th>
                             </tr>
                         </thead>
                         <tbody id="_tablebody">
                             @foreach ($campaigns as $campaign)
                                <tr>
                                    <td><b>{{ $campaign['account_name'] }}</b></td>
                                    <td><b>{{ $campaign['date_preset'] }}</b></td>
                                    <td><b>{{ $campaign['country'] }}</b></td>
                                    <td><a href="{{ route('facebook.campaign',$campaign['id']) }}">{{ $campaign['campaign_name'] }}</a></td>
                                    <td><b>R$. {{ $campaign['spend'] }}</b></td>
                                    <td><b>{{ $campaign['impressions'] }}</b></td>
                                    <td><b>{{ $campaign['status'] }}</b></td>
                                    <td><b>{{ $campaign['clicks'] }}</b></td>
                                    <td><b>R$. {{ $campaign['cpm'] }}</b></td>
                                    <td><b>R$. {{ $campaign['cpc'] }}</b></td>
                                    <td><b>R$. {{ $campaign['ctr'] }}</b></td>
                                    <td><b>{{ $campaign['fb_pixel_view_content'] }}</b></td>
                                    <td><b>{{ $campaign['created_time'] }}</b></td>
                                </tr>
                             @endforeach
                         </tbody>
                         <tfoot>
                             <tr>
                                <th><b>Conta</b></th>
                                 <th><b>Data</b></th>
                                 <th><b>Pais</b></th>
                                 <th><b>Campanha</b></th>
                                 <th><b>Custo</b></th>
                                 <th><b>Impressoes</b></th>
                                 <th><b>Status</b></th>
                                 <th><b>Clicks</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CPC</b></th>
                                 <th><b>CTR</b></th>
                                 <th><b>Pixel</b></th>
                                 <th><b>Criaçao</b></th>
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
