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
                            <th>CONTA</th>
                            <th>ID</th>
                            <th>USER ID</th>
                            <th>ACOES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbuser->bussiness_accounts as $account)
                            <tr>
                                <td>{{ $fbuser->email }}</td>
                                <td><b>{{ $account->account_id }}</b></td>
                                <td><b>{{ $account->facebook_users_id}}</b></td>
                                <td> <a href="/relatorios/facebook/campaigns/account/{{ $account->id }}" class="btn btn-primary">Ver campanhas</a> </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>USER ID</th>
                            <th>ACOES</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
