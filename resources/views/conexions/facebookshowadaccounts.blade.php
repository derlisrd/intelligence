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
        <div class="form-check">
            <input class="form-check-input" name='check_account[]' value="{{ $account->account_ }}" type="checkbox" value="" id="_check_{{ $account->id }}">
            <label class="form-check-label" for="_check_{{ $account->id }}">
              {{ $account->account_name }}
            </label>
          </div>
        @endforeach
    </div>
    <div  class="col-12">
        <button type='submit' class="btn btn-primary">Salvar</button>
    </div>
</div>
</form>
@endsection
