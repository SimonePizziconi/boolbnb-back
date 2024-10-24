<div class="d-flex flex-column flex-shrink-0 p-3 text-white my_sidebar">
    <a id="logo_debug" href="http://localhost:5174/" class="align-items-center mb-3 mb-md-0 me-md-auto d-flex">
        <img class="img-fluid" src="{{ asset('img/logo-bool-bnb.png') }}" alt="logo">
    </a>

    {{-- <div id="logo_debug"></div> --}}
    <hr>
    <div class="d-flex justify-content-around align-items-center flex-wrap my-5 flex-reverse">

        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="{{ route('admin.index') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-house"></i> Home</span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.apartments.index') }}" class="nav-link text-white d-flex">
                    <span><i class="fa-solid fa-list"></i> Appartamenti</span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.apartments.create') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-plus"></i> Nuovo Appartamento</span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.sponsorships.payment') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-star"></i> Sponsorizza appartamento</span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.messagges.index') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-envelope"></i> Messaggi</span>

                </a>
            </li>
        </ul>
        <ul class="nav nav-pills2 flex-column mb-auto">
            <li>
                <a href="{{ route('admin.index') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-house"></i></span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.apartments.index') }}" class="nav-link text-white d-flex">
                    <span><i class="fa-solid fa-list"></i></span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.apartments.create') }}" class="nav-link text-white">
                    <span><i class="fa-solid fa-plus"></i></span>
                </a>
            </li>
        </ul>
    </div>
    <hr>
</div>
