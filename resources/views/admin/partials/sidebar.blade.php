<div class="d-flex flex-column flex-shrink-0 p-3 text-white my_side">
    <a id="logo_debug" href="/"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="" alt="logo">
    </a>
    {{-- <div id="logo_debug"></div> --}}
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="{{ route('admin.index') }}" class="nav-link text-white">
                <i class="fa-solid fa-house"> Home</i>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.apartments.index') }}" class="nav-link text-white d-flex">
                <i class="fa-solid fa-list"> Appartamenti</i>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.apartments.create') }}" class="nav-link text-white">
                <i class="fa-solid fa-plus"> Aggiungi Appartamento</i>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.apartments.trash') }}" class="nav-link text-white">
                <i class="fa-solid fa-trash"> Cestino</i>
            </a>
        </li>
    </ul>
    <hr>
</div>
