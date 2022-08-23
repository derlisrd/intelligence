@extends("layouts.app")

@section("title","Relatorios facebook")
@section("breadcrumb","Relatorios de facebook")
@section("currentpage","facebook")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Contas conectadas</h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>USER ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbusers as $user)
                            <tr>
                                <td><b><a href="{{ route('view.relatorios.getCampaigns',$user->id) }}"> {{ $user->name }}</a></b></td>
                                <td><b>{{ $user->email }}</b></td>
                                <td><b>{{ $user->facebook_user_id}}</b></td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>USER ID</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
