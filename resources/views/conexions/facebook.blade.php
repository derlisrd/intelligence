@extends("layouts.app")

@section("title","Conectar con facebook")

@section("breadcrumb","Conectar con facebook")

@section("container")
<div class="my-5">
    <a href="{{ $urllogin }}" class="btn btn-primary">Facebook</a>
</div>



<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Usuarios de facebook: </h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>FB USER ID</th>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>TOKEN</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fbusers as $user)
                            <tr>
                                <td>{{ $user->facebook_user_id  }}</td>
                                <td>{{ $user->name  }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ substr( $user->access_token,0,10 ); }}...</td>
                                <th><a href="#" class="btn btn-secondary">Refresh token</a> </th>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <tr>
                                <th>FB USER ID</th>
                                <th>NOME</th>
                                <th>EMAIL</th>
                                <th>TOKEN</th>
                                <th>Accion</th>
                            </tr>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
