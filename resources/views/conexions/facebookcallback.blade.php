@extends("layouts.app")

@section("title","Conectar con facebook")

@section("breadcrumb","Conectar con facebook")

@section("container")

<h2>Seu usuario esta conectado</h2>
<h3>Dados: </h3>
<h4> {{ $userfb->name }}</h4>
<h4> {{ $userfb->email }}</h4>
@endsection
