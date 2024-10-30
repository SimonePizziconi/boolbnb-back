<header>
    <nav class="navbar fixed-top navbar-expand-md d-flex align-items-center navbar-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.index') }}">Dashboard</a>

            <!-- Bottone per il menu offcanvas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu offcanvas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <!-- Elementi di navigazione visibili solo agli ospiti (non autenticati) -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                                </li>
                            @endif
                        @else
                            <!-- Elementi di navigazione visibili solo agli utenti autenticati -->
                            <li class="nav-item d-inline-block d-md-none d-lg-none">
                                <a id="logo_debug" href="http://localhost:5174/"
                                    class="align-items-center mb-3 mb-md-0 me-md-auto d-flex w-25">
                                    <img class="img-fluid" src="{{ asset('img/small-logo.png') }}" alt="logo">
                                </a>
                            </li>
                            <li class="nav-item d-inline-block d-md-none d-lg-none">
                                <a class="nav-link" aria-current="page" href="{{ route('admin.apartments.index') }}">
                                    <span><i class="fa-solid fa-list"></i> Appartamenti</span>
                                </a>
                            </li>
                            <li class="nav-item d-inline-block d-md-none d-lg-none">
                                <a class="nav-link" aria-current="page" href="{{ route('admin.apartments.create') }}">
                                    <span><i class="fa-solid fa-plus"></i> Nuovo Appartamento</span>
                                </a>
                            </li>
                            <li class="nav-item d-inline-block d-md-none d-lg-none">
                                <a class="nav-link" aria-current="page" href="{{ route('admin.sponsorships.payment') }}">
                                    <span><i class="fa-solid fa-star"></i> Sponsorizza appartamento</span>
                                </a>
                            </li>
                            <li class="nav-item d-inline-block d-md-none d-lg-none">
                                <a class="nav-link" aria-current="page" href="{{ route('admin.messagges.index') }}">
                                    <span><i class="fa-solid fa-envelope"></i> Messaggi</span>
                                </a>
                            </li>
                            <li class="nav-item text-md-center">
                                <div class="btn-group my-dropdown">
                                    <a  class="nav-link" href="#" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa-solid fa-user my_icon d-none d-md-inline-block d-lg-inline-block"></i>
                                        <span class="d-block fw-bold fs-5 d-md-none">{{ Auth::user()->email }}</span>
                                        <span
                                        class="d-none d-md-block mt-1">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                  </div>
                            </li>
                            {{-- <li class="nav-item dropstart text-md-center">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user my_icon d-none d-md-inline-block d-lg-inline-block"></i>
                                    <span class="d-block fw-bold fs-5 d-md-none">{{ Auth::user()->email }}</span>
                                    <span
                                        class="d-none d-md-block mt-1">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li> --}}
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</header>
