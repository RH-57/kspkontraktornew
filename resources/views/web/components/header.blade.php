<div class="container-fluid px-4 d-none d-lg-block">
    <div class="row gx-4">
        <div class="col-lg-4 text-center py-2">
            <div class="d-inline-flex align-items-center">
                <i class="bi bi-geo-alt fs-4 text-primary me-2"></i>
                <div class="text-start">
                    <h6 class="text-uppercase fw-semibold mb-0" style="font-size: 0.85rem;">Our Office</h6>
                    <span style="font-size: 0.8rem;">{{ $contacts?->address ?? 'Alamat belum tersedia' }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-center border-start border-end py-2">
            <div class="d-inline-flex align-items-center">
                <i class="bi bi-envelope-open fs-4 text-primary me-2"></i>
                <div class="text-start">
                    <h6 class="text-uppercase fw-semibold mb-0" style="font-size: 0.85rem;">Email Us</h6>
                    <span style="font-size: 0.8rem;">{{ $contacts?->email ?? 'Email belum tersedia' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-center py-2">
            <div class="d-inline-flex align-items-center">
                <i class="bi bi-phone-vibrate fs-4 text-primary me-2"></i>
                <div class="text-start">
                    <h6 class="text-uppercase fw-semibold mb-0" style="font-size: 0.85rem;">Call Us</h6>
                    <span style="font-size: 0.8rem;">+{{ $contacts?->phone ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-dark bg-light-radial shadow-sm px-5 pe-lg-0">
        <nav class="navbar navbar-expand-lg bg-dark bg-light-radial navbar-dark py-3 py-lg-0">
           <a href="{{ route('home') }}" class="navbar-brand"
            style="display: flex; align-items: center; height: 60px; padding-left: 13px;">
                <img src="{{ asset('assets/web/img/logo.png') }}"
                    alt="KSP Kontraktor"
                    style="height: 45px; transform: scale(1.9); transform-origin: center; transition: transform 0.3s ease;">
            </a>



            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{route('services')}}" class="nav-item nav-link {{ request()->routeIs('services') ? 'active' : '' }}">Service</a>
                    <a href="{{route('projects')}}" class="nav-item nav-link {{ request()->routeIs('projects') ? 'active' : '' }}">Project</a>
                    <a href="{{route('articles')}}" class="nav-item nav-link {{ request()->routeIs('articles') ? 'active' : '' }}">Article</a>
                    <a href="{{route('contact')}}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a
                        href="https://wa.me/{{$contacts->phone}}?text=Saya%20tertarik%20dengan%20layanan%20Anda.%20Bisa%20minta%20penawaran?"
                        class="nav-item nav-link bg-primary text-white px-5 ms-3 d-none d-lg-block"
                        target="_blank">
                        Get A Quote
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
