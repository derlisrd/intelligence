@extends("layouts.app")

@section("title","Contas de anuncio")

@section("breadcrumb","Contas de anuncio")

@section("container")
<form>
<div class="row">
    <div  class="col-12">
        <h3>Seleccionar contas ativas</h3>
    </div>
    <div  class="col-12">
        @foreach ($adsaccounts as $account )
        <div class="form-check">
            <input class="form-check-input" name='' type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Default checkbox
            </label>
          </div>
        @endforeach
    </div>
    <div  class="col-12">

    </div>
</div>
</form>
@endsection
