@extends("layouts.app")
@section("title","Intelligence home page")
@section("breadcrumb","Home")
@section("container")


<div class="row">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 border bg-success rounded-8">
            <div class="card-block">
              <h4 class="card-title text-center text-white text-uppercase ">Google AM</h4>
              <h6 class="card-subtitle text-white text-center">Receita geral </h6>
              <h1 class="text-center text-white"> 1230 Rs.</h1>
            </div>
        </div>
    </div>



    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 border bg-info rounded-8">
            <div class="card-block">
              <h4 class="card-title text-center font-weight-bold text-white text-uppercase ">Facebook</h4>
              <h6 class="card-subtitle text-white text-center">Custos de campanhas</h6>
              <h1 class="text-center text-white"> 1230 Rs.</h1>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 border bg-dark rounded-8">
            <div class="card-block">
              <h4 class="card-title text-center font-weight-bold text-white text-uppercase ">Contas</h4>
              <h6 class="card-subtitle text-white text-center">Contas de facebook</h6>
              <h1 class="text-center text-white">10</h1>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card p-4 border bg-danger rounded-8">
            <div class="card-block">
              <h4 class="card-title text-center font-weight-bold text-white text-uppercase ">Dominios</h4>
              <h6 class="card-subtitle text-white text-center">Cant. dominios atuais</h6>
              <h1 class="text-center text-white">33</h1>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="card p-4 rounded-8">
            <div class="table-responsive">
                <h5 class="card-title p-2 text-info text-uppercase">
                   Ultimas campanhas facebook
                </h5>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><b>Conta</b></th>
                            <th><b>Campanha</b></th>
                            <th><b>Pais</b></th>
                            <th><b>Custo</b></th>
                            <th><b>Impressoes</b></th>
                            <th><b>Clicks</b></th>
                            <th><b>Data</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbcampaigns as $fb )
                        <tr>
                            <td>{{ $fb->account_name }} </td>
                            <td>{{ $fb->campaign_name }}</td>
                            <td>{{ $fb->country }} </td>
                            <td>{{ $fb->spend }} </td>
                            <td>{{ $fb->impressions }} </td>
                            <td>{{ $fb->clicks }} </td>
                            <td>{{ $fb->date_start }}</td> </td>
                        <tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><b>Conta</b></th>
                            <th><b>Campanha</b></th>
                            <th><b>Pais</b></th>
                            <th><b>Custo</b></th>
                            <th><b>Impressoes</b></th>
                            <th><b>Clicks</b></th>
                            <th><b>Data</b></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>



@endsection

