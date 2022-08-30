@extends("layouts.app")

@section("title","Receitas")
@section("breadcrumb","Receitas")
@section("currentpage","Receitas")

@section("container")
<div class="row">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-light rounded-8 shadow">
            <div class="card-block">
                <h4 class="card-title text-center text-uppercase ">
                    <i class="me-2 mdi mdi-cash-usd"></i>
                    Dolar
                </h4>
              <h6 class="card-subtitle text-center">Valor dolar do dia e</h6>
              <h3 class="text-center">R$. {{ $dolar ?? '0' }} </h3>
            </div>
        </div>
    </div>
<form action="{{ route('receitas.campaigns') }}" method="post">
    @csrf
    <div class="col-12 d-flex align-items-center flex-row mt-2">
        <div class="p-2 mx-2">
            <label for="domain">Dominios</label>
            <select  class="form-select form-select-lg" id="domain" name="domain" >
                <option value="" selected>Seleccionar dominio</option>
                @foreach ($domains as $val)
                    <option @if($val->domain==$domain) selected @endif value="{{ $val->domain }}">{{ $val->domain }}</option>
                @endforeach
            </select>
        </div>
        <div class="p-2 mx-2">
            <label for="country">Pais</label>
            <select  class="form-select form-select-lg" id="country" name="country" >
                <option value="" selected>Seleccionar pais</option>
                @foreach ($countries as $c)
                    <option @if($c->name==$country) selected @endif value="{{ $c->name }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="p-2 mx-2">
            <label for="desde">Desde: </label>
            <input type="date" name="desde" class="form-control form-control-lg" value="{{  $desde ?? '' }}" />
        </div>
        <div class="p-2 mx-2">
            <label for="hasta">Ate: </label>
            <input type="date" name="hasta" class="form-control form-control-lg" value="{{  $hasta ?? '' }}" />
        </div>
        <div class="p-2 mx-2">
            <label for="country">Chave de valor</label>
            <input  class="form-control input-lg" id="value" value="{{ $value ?? '' }}" name="value" />
        </div>
        <button class="btn btn-primary btn-lg mt-4" type="submit">Filtrar</button>
    </div>
</form>
</div>

<div class="row mt-4">
   <div class="card p-2">
    <div class="card-body">
        <div class="table-responsive" id="_table-responsive">
            <h3 class="card-title p-2">
               Campanhas
            </h3>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="stickycolumn bg-white"><b>Dominio</b></th>
                        <th><b>Pais</b></th>
                        <th><b>Chave</b></th>
                        <th class="bg-info text-white">Conta</th>
                        <th class="bg-info text-white">Campanha</th>
                        <th class="bg-info text-white">Objetivo</th>
                        <th class="bg-info text-white">Impressao</th>
                        <th class="bg-info text-white">Clicks</th>
                        <th class="bg-info text-white">CTR</th>
                        <th class="bg-info text-white">CPC</th>
                        <th class="bg-primary text-white">Dominio</th>
                        <th class="bg-primary text-white">Impressoes</th>
                        <th class="bg-primary text-white">Clicks</th>
                        <th class="bg-primary text-white">CTR</th>
                        <th class="bg-primary text-white">CPM</th>
                        <th class="bg-primary text-white">Receita</th>
                        <th class="bg-success text-white">Results</th>
                    </tr>
                </thead>
                <tbody id="_tablebody">
                   @foreach ($reports as $c)
                   <tr>
                        <td class="stickycolumn">{{ $c['domain'] }}</td>
                        <td>{{ $c['country'] }}</td>
                        <td>{{ $c['key_value'] }}</td>

                        <td>{{ $c['account_name'] }}</td>
                        <td>{{ $c['campaign_name'] }}</td>
                        <td>{{ $c['objective'] }}</td>
                        <td>{{ $c['impressions_fb'] }}</td>
                        <td>{{ $c['clicks_fb'] }}</td>
                        <td>{{ $c['ctr_fb'] }}</td>
                        <td>{{ $c['cpc_fb'] }}</td>
                        <td>{{ $c['domain'] }}</td>
                        <td>{{ $c['impressions'] }}</td>
                        <td>{{ $c['clicks'] }}</td>
                        <td>{{ $c['ctr'] }}</td>
                        <td>{{ $c['cpm'] }}</td>
                        <td>{{ $c['receita'] }}</td>
                        <td>
                            <p>Un monte de coisas</p>
                        </td>
                    </tr>
                   @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th class="stickycolumn"><b>Dominio</b></th>
                        <th><b>Pais</b></th>
                        <th><b>Chave</b></th>
                        <th class="bg-info text-white">Conta</th>
                        <th class="bg-info text-white">Campanha</th>
                        <th class="bg-info text-white">Objetivo</th>
                        <th class="bg-info text-white">Impressao</th>
                        <th class="bg-info text-white">Clicks</th>
                        <th class="bg-info text-white">CTR</th>
                        <th class="bg-info text-white">CPC</th>
                        <th class="bg-primary text-white">Dominio</th>
                        <th class="bg-primary text-white">Impressoes</th>
                        <th class="bg-primary text-white">Clicks</th>
                        <th class="bg-primary text-white">CTR</th>
                        <th class="bg-primary text-white">CPM</th>
                        <th class="bg-primary text-white">Receita</th>
                        <th class="bg-success text-white">Results</th>
                </tfoot>
            </table>
        </div>
    </div>
   </div>
</div>
<style>
    .stickycolumn{
        position:sticky !important;
        left:0 !important;
        background-color:white !important;
        border-right: 2px solid black;
        z-index: 10;
    }
</style>
@endsection

