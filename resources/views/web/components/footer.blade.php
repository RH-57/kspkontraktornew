<div class="row g-5">
            <div class="col-lg-6 pe-lg-5">
                <a href="{{ route('home') }}" class="navbar-brand d-inline-block mb-3"
                style="display: flex; align-items: center;">
                    <img src="{{ asset('assets/web/img/logo.png') }}"
                        alt="KSP Kontraktor"
                        style="height: 90px; object-fit: contain;">
                </a>

                <p>Kami adalah partner terpercaya dalam mewujudkan struktur baja yang kokoh, presisi, dan efisien. Dengan komitmen pada kualitas material dan ketepatan waktu, setiap proyek adalah cerminan standar ketangguhan tertinggi.</p>
                <p><i class="fa fa-map-marker-alt me-2"></i>{{$contacts->address}}</p>
                <p><i class="fa fa-phone-alt me-2"></i>{{$contacts->phone}}</p>
                <p><i class="fa fa-envelope me-2"></i>{{$contacts->email}}</p>
                <div class="d-flex justify-content-start mt-4">
                    @foreach($sosmeds as $sosmed)
                    <a class="btn btn-lg btn-primary btn-lg-square rounded-0 me-2" href="{{$sosmed->url}}"><i class="fab {{$sosmed->icon}}"></i></a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="row g-5">
                    <div class="col-sm-6">
                        <h4 class="text-white text-uppercase mb-4">Quick Links</h4>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white-50 mb-2" href="{{route('home')}}"><i class="fa fa-angle-right me-2"></i>Home</a>
                            <a class="text-white-50 mb-2" href="{{route('services')}}"><i class="fa fa-angle-right me-2"></i>Services</a>
                            <a class="text-white-50 mb-2" href="{{route('projects')}}"><i class="fa fa-angle-right me-2"></i>Projects</a>
                            <a class="text-white-50 mb-2" href="{{route('articles')}}"><i class="fa fa-angle-right me-2"></i>Artikel</a>
                            <a class="text-white-50" href="{{route('contact')}}"><i class="fa fa-angle-right me-2"></i>Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark bg-light-radial text-white border-top border-primary px-0">
        <div class="d-flex flex-column flex-md-row justify-content-between">
            <div class="py-4 px-5 text-center text-md-start">
                <p class="mb-0">&copy; <a class="text-primary" href="#">kspkontraktor.com</a>. All Rights Reserved.</p>
            </div>
            <div class="py-4 px-5 bg-primary footer-shape position-relative text-center text-md-end">
                <p class="mb-0">Designed by <a class="text-dark" href="https://htmlcodex.com">HTML Codex</a></p>
                <p class="mb-0">Distributed by <a class="text-dark" href="https://themewagon.com">ThemeWagon</a></p>
            </div>
        </div>
