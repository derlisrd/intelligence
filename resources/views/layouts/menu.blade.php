 <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="charts.html" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span
                                    class="hide-menu">Charts</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="widgets.html" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span
                                    class="hide-menu">Widgets</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="tables.html" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span
                                    class="hide-menu">Tables</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="grid.html" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span
                                    class="hide-menu">Full Width</span></a></li>


                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span
                                    class="hide-menu">Relatorios: </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{ route('relatorios.facebook.users') }}" class="sidebar-link"><i class="mdi mdi-facebook-box"></i><span class="hide-menu"> Facebook</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('relatorios.facebook.users') }}" class="sidebar-link"><i class="mdi mdi-google-plus"></i><span class="hide-menu"> Google</span></a></li>
                            </ul>
                        </li>


                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="pages-buttons.html" aria-expanded="false"><i
                                    class="mdi mdi-relative-scale"></i><span class="hide-menu">Buttons</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span
                                    class="hide-menu">Icons </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="icon-material.html" class="sidebar-link"><i
                                            class="mdi mdi-emoticon"></i><span class="hide-menu"> Material Icons
                                        </span></a></li>
                                <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><i
                                            class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Font Awesome
                                            Icons </span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="pages-elements.html" aria-expanded="false"><i class="mdi mdi-pencil"></i><span
                                    class="hide-menu">Elements</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-move-resize-variant"></i><span class="hide-menu">Addons </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="index2.html" class="sidebar-link"><i
                                            class="mdi mdi-view-dashboard"></i><span class="hide-menu"> Dashboard-2
                                        </span></a></li>
                                <li class="sidebar-item"><a href="pages-gallery.html" class="sidebar-link"><i
                                            class="mdi mdi-multiplication-box"></i><span class="hide-menu"> Gallery
                                        </span></a></li>
                                <li class="sidebar-item"><a href="pages-calendar.html" class="sidebar-link"><i
                                            class="mdi mdi-calendar-check"></i><span class="hide-menu"> Calendar
                                        </span></a></li>
                                <li class="sidebar-item"><a href="pages-invoice.html" class="sidebar-link"><i
                                            class="mdi mdi-bulletin-board"></i><span class="hide-menu"> Invoice
                                        </span></a></li>
                                <li class="sidebar-item"><a href="pages-chat.html" class="sidebar-link"><i
                                            class="mdi mdi-message-outline"></i><span class="hide-menu"> Chat Option
                                        </span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span
                                    class="hide-menu">Authentication </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="authentication-login.html" class="sidebar-link"><i
                                            class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Login </span></a>
                                </li>
                                <li class="sidebar-item"><a href="authentication-register.html" class="sidebar-link"><i
                                            class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Register
                                        </span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="fas fa-rocket"></i><span
                                    class="hide-menu">Conexões</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href={{ route('conexions.facebook') }} class="sidebar-link"><i class="fab fa-facebook-square"></i>
                                    <span class="hide-menu"> Conectar facebook</span></a>
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
