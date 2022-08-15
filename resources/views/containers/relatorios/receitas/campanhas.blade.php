@extends("layouts.app")

@section("title","Receitas")
@section("breadcrumb","Receitas")
@section("currentpage","Receitas")

@section("container")
<div class="row">
<form action="{{ route('receitas.campaigns') }}" method="post">
    @csrf
    <div class="col-12 d-flex align-items-center flex-row mt-2">
        <div class="p-2 mx-2">
            <label for="domain">Dominios</label>
        <select  class="form-select form-select-lg" id="domain" name="domain" >
            <option value="" selected>Seleccionar</option>
            @foreach ($domains as $val)
                <option value="{{ $val->domain }}">{{ $val->domain }}</option>
            @endforeach
        </select>
        </div>
        <div class="p-2 mt-4 mx-2">
            <input type="text" name="country" class="form-control form-control-lg" placeholder="Pais" />
        </div>
        <button class="btn btn-primary btn-lg mt-4" type="submit">Filtrar</button>
    </div>
</form>
</div>

<div class="row">
   <div class="card p-2">
    <div class="card-body">
        <div class="table-responsive" id="_table-responsive">
            <h3 class="card-title p-2">
               Campanhas
            </h3>
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>DOMINIO</th>
                        <th>CAMPANHA</th>
                        <th>CUSTO FB</th>
                        <th>RECEITA GOOGLE</th>
                        <th>BALANÇO</th>
                    </tr>
                </thead>
                <tbody id="_tablebody">
                   @foreach ($campaigns as $campaign)
                   <tr>

                    </tr>
                   @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>DOMINIO</th>
                        <th>CAMPANHA</th>
                        <th>CUSTO FB</th>
                        <th>RECEITA GOOGLE</th>
                        <th>BALANÇO</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
   </div>
</div>





@endsection

