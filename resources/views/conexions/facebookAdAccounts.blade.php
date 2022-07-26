@extends("layouts.app")

@section("title","Contas de anuncio")

@section("breadcrumb","Contas de anuncio")

@section("container")


<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Contas de anuncio: </h5>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Usuario de facebook</th>
                            <th>Conta de anuncio</th>
                            <th>Opçoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adAccounts as $user)
                            <tr id="_user_{{ $user->id }}">
                                <td>{{ $user->facebook_user->name }}</td>
                                <td><b>{{ $user->account_name }}</b></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="ask({{ $user->id }})"  class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <tr>
                                <th>Usuario de facebook</th>
                                <th>Conta de anuncio</th>
                                <th>Opçoes</th>
                            </tr>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function ask(id){
        Swal.fire({
            title: 'Quer eliminar esta conta?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: `Cancelar`,
            }).then(async(res) => {
                if(res.isConfirmed){
                let data = await fetch(`/api/facebook/destroyadaccount/${id}`,
                    { method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                let json = await data.json()
                    if(json.response){
                        Swal.fire('Conta eliminada!', '', 'success')
                        document.getElementById(`_user_${id}`).remove();
                    }
                }
            })

    }
</script>
@endsection
