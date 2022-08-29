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
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><b>Dominio</b></th>
                        <th><b>Pais</b></th>
                        <th><b>Campanha fb</b></th>
                        <th><b>Chave</b></th>
                        <th><b>Custo fb R$.</b></th>
                        <th><b>Receita Gam R$.</b></th>
                        <th><b>Cpm Gam R$.</b></th>
                        <th><b>Custo fb Us$.</b></th>
                        <th><b>Receita Gam Us$.</b></th>
                        <th><b>Cpm Gam Us$.</b></th>
                        <th><b>Lucro Us$</b></th>
                        <th><b>Lucro % </b></th>
                    </tr>
                </thead>
                <tbody id="_tablebody">
                   @foreach ($reports as $c)
                   <tr>
                        <td>{{ $c['domain'] }}</td>
                        <td>{{ $c['country'] }}</td>
                        <td>{{ $c['campaign_name'] }}</td>
                        <td>{{ $c['key_value'] }}</td>
                        <td>R$. {{ $c['spend'] }}</td>
                        <td>R$. {{ round((($c['receita'])*$dolar),2) }}</td>
                        <td>R$. {{ round((($c['cpm_gam'])*$dolar),2) }}</td>
                        <td>Us$. {{ round(($c['spend']/$dolar),2) }}</td>
                        <td>Us$. {{ (($c['receita'])) }}</td>
                        <td>Us$. {{ (($c['cpm_gam'])) }}</td>
                        <td>Us$ {{  round(($c['receita'])-($c['spend']/$dolar),2) }}  </td>
                        <td> %</td>
                    </tr>
                   @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th><b>Dominio</b></th>
                        <th><b>Pais</b></th>
                        <th><b>Campanha fb</b></th>
                        <th><b>Chave</b></th>
                        <th><b>Custo fb R$.</b></th>
                        <th><b>Receita Gam R$.</b></th>
                        <th><b>Cpm Gam R$.</b></th>
                        <th><b>Custo fb Us$.</b></th>
                        <th><b>Receita Gam Us$.</b></th>
                        <th><b>Cpm Gam Us$.</b></th>
                        <th><b>Lucro</b></th>
                        <th><b>Lucro % </b></th>
                </tfoot>
            </table>
        </div>
    </div>
   </div>
</div>





@endsection

