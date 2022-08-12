@extends("layouts.app")

@section("title","Relatorios Google Ad Manager")
@section("breadcrumb","Relatorios Google Ad Manager")
@section("currentpage","Google Ad Manager")

@section("container")

<div class="row">
    <div class="card p-2">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Campanhas</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile"
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Conjunto de anuncios</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#messages"onchange=""
                    role="tab"><span class="hidden-sm-up"></span> <span
                        class="hidden-xs-down">Anuncios</span></a> </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="home" role="tabpanel">
                 <div class="table-responsive" id="_table-responsive">
                     <h3 class="card-title p-2">
                        Campanhas
                     </h3>
                     <table id="zero_config" class="table table-striped table-bordered">
                         <thead>
                             <tr>
                                 <th><b>DOMAIN</b></th>
                                 <th><b>NOME</b></th>
                                 <th><b>VALUE</b></th>
                                 <th><b>PAIS</b></th>
                                 <th><b>RECEITA</b></th>
                                 <th><b>IMPRESSOES</b></th>
                                 <th><b>CLICKS</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CTR</b></th>
                                 <th><b>DATA DE CRIAÇAO</b></th>
                             </tr>
                         </thead>
                         <tbody id="_tablebody">
                            @foreach ($campaigns as $campaign)
                            <tr>
                                <td><b>{{ $campaign->domain }}</b></td>
                                 <td><b>{{ $campaign->name }}</b></td>
                                 <td><b>{{ $campaign->value }}</b></td>
                                 <td><b>{{ $campaign->country }}</b></td>
                                 <td><b>{{ $campaign->receita }}</b></td>
                                 <td><b>{{ $campaign->impressions }}</b></td>
                                 <td><b>{{ $campaign->clicks }}</b></td>
                                 <td><b>{{ $campaign->cpm }}</b></td>
                                 <td><b>{{ $campaign->ctr }}</b></td>
                                 <td><b>{{ $campaign->date }}</b></td>
                             </tr>
                            @endforeach

                         </tbody>
                         <tfoot>
                             <tr>
                                <th><b>DOMAIN</b></th>
                                 <th><b>NOME</b></th>
                                 <th><b>VALUE</b></th>
                                 <th><b>PAIS</b></th>
                                 <th><b>RECEITA</b></th>
                                 <th><b>IMPRESSOES</b></th>
                                 <th><b>CLICKS</b></th>
                                 <th><b>CPM</b></th>
                                 <th><b>CTR</b></th>
                                 <th><b>DATA DE CRIAÇAO</b></th>
                             </tr>
                         </tfoot>
                     </table>
                 </div>
            </div>
            <div class="tab-pane  p-20" id="profile" role="tabpanel">
                <h4 class="text-center p-3">Coming soon</h4>
            </div>
            <div class="tab-pane p-20" id="messages" role="tabpanel">
                <h4 class="text-center p-3">Coming soon</h4>
            </div>
        </div>
    </div>

</div>


@endsection
