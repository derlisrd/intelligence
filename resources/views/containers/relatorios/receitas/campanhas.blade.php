@extends("layouts.app")

@section("title","Receitas")
@section("breadcrumb","Receitas")
@section("currentpage","Receitas")

@section("container")
<div class="row">
    <div class="col-12 d-flex align-items-center flex-row mt-2">
        <div class="p-2 mx-2">
            <label for="domain">Dominios</label>
        <select  class="form-select form-select-lg" id="domain" >
            <option value="" selected>Seleccionar</option>
            @foreach ($domains as $val)
                <option value="{{ $val->domain }}">{{ $val->domain }}</option>
            @endforeach
        </select>
        </div>
        <div class="p-2 mt-4 mx-2">
            <input type="text" name="pais" class="form-control form-control-lg" placeholder="Pais" />
        </div>
        <button class="btn btn-primary btn-lg mt-4" onclick="filtrar()">Filtrar</button>
    </div>

</div>

@endsection
<script>
    async function filtrar(){
        let domain = document.getElementById('domain').value;

        let res = await fetch(`/api/receitas/${domain}`);
        let data = await res.json();
        console.log(data)
    }
</script>
