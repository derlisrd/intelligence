 <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('home') }}" >
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Home</span></a></li>



                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark " href="javascript:void(0)" ><i class="mdi mdi-receipt"></i>
                                <span class="hide-menu">Relatorios: </span>
                            </a>
                            <ul class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{ route('relatorios.facebook.users') }}" class="sidebar-link"><i class="mdi mdi-facebook-box"></i><span class="hide-menu"> Facebook</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('relatorios.google.gam') }}" class="sidebar-link"><i class="mdi mdi-google-plus"></i><span class="hide-menu"> Google</span></a></li>
                            </ul>
                        </li>




                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" ><i class="fas fa-rocket"></i><span
                                    class="hide-menu">Conexões</span></a>
                            <ul class="collapse  first-level">
                                <li class="sidebar-item"><a href={{ route('conexions.facebook') }} class="sidebar-link"><i class="fab fa-facebook-square"></i>
                                    <span class="hide-menu"> Conectar facebook</span></a>
                                </li>
                                <li class="sidebar-item"><a href={{ route('facebook.adaccounts') }} class="sidebar-link"><i class="fab fa-facebook-square"></i>
                                    <span class="hide-menu">Facebook Ads Accounts</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
