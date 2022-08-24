@extends("layouts.app")
@section("title","Intelligence home page")
@section("breadcrumb","Home")
@section("container")


<div class="row">


    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-success rounded-8">
            <div class="card-block">
                <h4 class="card-title text-center text-white text-uppercase ">
                    <i class="me-2 mdi mdi-google"></i>
                    Google AM
                </h4>
              <h6 class="card-subtitle text-white text-center">Receita </h6>
              <h1 class="text-center text-white"> {{ $receita_gl ?? '0' }} Rs.</h1>
            </div>
        </div>
    </div>



    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-info rounded-8">
            <div class="card-block">
              <h4 class="card-title text-center font-weight-receitabold text-white text-uppercase ">
                <i class="me-2 mdi mdi-facebook-box"></i>
                Facebook
              </h4>
              <h6 class="card-subtitle text-white text-center">Custos de campanhas</h6>
              <h1 class="text-center text-white"> {{ $custo_fb ?? '0' }} Rs.</h1>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-dark rounded-8">
            <div class="card-block">
                <h4 class="card-title text-center text-white text-uppercase ">
                    <i class="fas fa-user-circle"></i>
                    Contas
                </h4>
              <h6 class="card-subtitle text-white text-center">Contas de facebook</h6>
              <h1 class="text-center text-white">{{ $contas_fb ?? '0' }}</h1>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-danger rounded-8">
            <div class="card-block">
                <h4 class="card-title text-center text-white text-uppercase ">
                    <i class="me-2 mdi mdi-domain"></i>
                    Dominios
                </h4>
              <h6 class="card-subtitle text-white text-center">Cant. dominios atuais</h6>
              <h1 class="text-center text-white">{{ $contas_dominios ?? '0' }}</h1>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover p-4 border bg-warning rounded-8">
            <div class="card-block">
                <h4 class="card-title text-center text-white text-uppercase ">
                    <i class="me-2 mdi mdi-cash-usd"></i>
                    Lucros
                </h4>
              <h6 class="card-subtitle text-white text-center">Cant. lucro</h6>
              <h1 class="text-center text-white">{{ ($receita_gl - $custo_fb) }} Rs.</h1>
            </div>
        </div>
    </div>

    <div class="col-12">
        <form>
        <div class="row p-2 m-2">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label>Data inicial</label>
                    <input type="date" name="data_inicial" class="form-control input-lg" placeholder="data" />
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label>Data final</label>
                    <input type="date" name="data_final" class="form-control input-lg" placeholder="data" />
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <button class="btn btn-lg btn-outline-success mt-3" type="submit">FILTRAR</button>
            </div>
        </div>
        </form>
    </div>

    <div class="col-12">
        <div class="card p-4 rounded-8">
            <div class="table-responsive" id="_table-responsive">
                <h3 class="card-title p-2">
                   Ultimas campanhas
                </h3>
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><b>Campanha</b></th>
                            <th><b>Dominio</b></th>
                            <th><b>Key</b></th>
                            <th><b>Pais</b></th>
                            <th><b>Impressoes</b></th>
                            <th><b>Custo facebook</b></th>
                            <th><b>Receita</b></th>
                        </tr>
                    </thead>
                    <tbody id="_tablebody">
                       @foreach ($campaigns as $c)
                       <tr>
                           <td>{{ $c['campaign_name'] }}</td>
                           <td>{{ $c['domain'] }}</td>
                           <td>{{ $c['key_value'] }}</td>
                           <td>{{ $c['country'] }}</td>
                           <td>{{ $c['impressions'] }}</td>
                           <td>{{ $c['spend'] }}</td>
                           <td>{{ $c['receita'] }}</td>
                        </tr>
                       @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                           <th><b>Campanha</b></th>
                           <th><b>Dominio</b></th>
                           <th><b>Key</b></th>
                           <th><b>Pais</b></th>
                           <th><b>Impressoes</b></th>
                           <th><b>Custo facebook</b></th>
                           <th><b>Receita</b></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>




</div>



@endsection

