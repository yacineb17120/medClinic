<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="{{Auth::guard('doctor')->check() ? route('doctorHome') : (Auth::guard('secretary')->check() ? route('secretaryHome') : route('welcome'))}}">
                <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33" viewBox="0 0 30 33">
                    <g fill="none" fill-rule="evenodd">
                        <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                </svg>
                <span class="brand-name">Clinique Medicale</span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <li class="has-sub active expand">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#documentation" aria-expanded="false" aria-controls="documentation">
                        <i class="mdi mdi-book-open-page-variant"></i>
                        <span class="nav-text">Gestion</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse show" id="documentation" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li class="section-title">
                                Utilisateur
                            </li>
                            @if((Auth::guard('doctor')->check() && Auth::guard('doctor')->user()->is_admin)
                                || Auth::guard('secretary')->check())
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('doctor.index') }}">
                                            <span class="nav-text">Médecins</span>
                                        </a>
                                    </li>
                            @endif
                            @if(Auth::guard('doctor')->check() && Auth::guard('doctor')->user()->is_admin)
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('secretary.index') }}">
                                            <span class="nav-text">Secretaire</span>
                                        </a>
                                    </li>
                            @endif
                            <li>
                                <a class="sidenav-item-link" href="{{ route('patient.index') }}">
                                    <span class="nav-text">Patients</span>

                                </a>
                            </li>
                            @if(Auth::guard('doctor')->check())
                                <li>
                                    <a class="sidenav-item-link" href="{{ route('doctor.show',['doctor'=>Auth::guard('doctor')->user()->id]) }}">
                                        <span class="nav-text">Master Details</span>
                                    </a>
                                </li>
                            @endif
                            <li class="section-title">
                                Documents
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('appointment.index') }}">
                                    <span class="nav-text">Rendez-vous</span>

                                </a>
                            </li>
                            @if(Auth::guard('doctor')->check())
                                @if(Auth::guard('doctor')->user()->is_admin)
                                    <li class="section-title">
                                        Autre
                                    </li>
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('clinic.index') }}">
                                            <span class="nav-text">Clinique</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </div>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</aside>
