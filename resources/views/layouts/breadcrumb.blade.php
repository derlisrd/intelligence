
<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">
                            @yield("breadcrumb","Intelligence")
                        </h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    @isset($breadcrumblinks)
                                        @foreach ($breadcrumblinks as $bread)
                                            <li class="breadcrumb-item {{ $bread["active"] ? 'active' : '' }}" aria-current="page">
                                            @if ($bread["route"])
                                                <a href="
                                                    @if(isset( $bread['routeparams']) )
                                                        {{  route($bread["route"],$bread['routeparams']) }}
                                                    @else
                                                       {{  route($bread["route"]) }}
                                                    @endif
                                                ">
                                                    {{ $bread["title"] }}
                                                </a>
                                            @else
                                                {{ $bread["title"] }}
                                            @endif
                                            </li>
                                        @endforeach
                                    @endisset
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
