@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
               Conta: {{ $fbuser->email }}
            </h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><b>NOME</b></th>
                            <th><b>BUSSINESS ACT ID</b></th>
                            <th><b>FB USER ID</b></th>
                            <th><b>ACOES</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbuser->ads_accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->account_id }}</td>
                                <td>{{ $account->facebook_users_id}}</td>
                                <td><a href="{{ route('relatorios.facebook.campaigns',[$fbuser->id,$account->account_id]) }}" class="btn btn-primary">Campanhas</a></td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><b>NOME</b></th>
                            <th><b>BUSSINESS ACT ID</b></th>
                            <th><b>FB USER ID</b></th>
                            <th><b>ACOES</b></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
