@extends("layouts.app")

@section("title","Contas de anuncio")

@section("breadcrumb","Contas de anuncio")

@section("container")
<form action={{ route('conexion.save.accounts') }} method="post">
    @csrf
<div class="row">
    <div  class="col-12">
        <h3>Seleccionar contas ativas</h3>
    </div>
    <div  class="col-12">
        @foreach ($adsaccounts as $account )
        <div class="form-check form-switch">
            <input onclick="update({{ $account->id }})" class="form-check-input" @if($account->account_active) checked @endif type="checkbox" role="switch" name='check_account[{{ $account->id }}]' value="{{ $account->account_active }}" id="_check_{{ $account->id }}">
            <label class="form-check-label" for="_check_{{ $account->id }}">
              {{ $account->account_name }}
            </label>
          </div>
        @endforeach
    </div>




</div>

</form>

<script>
    async function update(e){
        let id = document.getElementById("_check_"+e);

        let res = await fetch('/conexion/facebookadaccount/save/'+e)
        let json = await res.json();
        console.log(json);
    }

</script>
@endsection


