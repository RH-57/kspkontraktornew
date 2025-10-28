<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Contact - PT. Karya Solusi Pembangunan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{asset('assets/web/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/web/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/web/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/web/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <!-- Customized Bootstrap Stylesheet
    <link href="{{asset('assets/web/css/bootstrap.min.css')}}" rel="stylesheet">-->
    <link href="{{asset('assets/web/css/custom.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/web/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div id="page-wrapper" style="height: 100vh; overflow: auto;">
    <!-- Topbar Start -->
    @include('web.components.header')
    <!-- Navbar End -->

    <!-- Contact Section Start -->
    <div class="container-fluid py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 text-uppercase mb-4">Hubungi <span class="text-primary">Kami</span></h1>
        </div>

        <div class="row g-5 align-items-start">
            <!-- LEFT: Map + Address -->
            <div class="col-lg-6">
                <div class="bg-light rounded shadow-sm p-4 h-100">
                    <div class="mb-3">
                        <iframe class="w-100 rounded"
                            src="{{ $contacts->maps }}"
                            frameborder="0" style="border:0; height:300px;" allowfullscreen=""></iframe>
                    </div>
                    <h5 class="text-uppercase fw-bold mb-2 text-dark">Alamat Kantor</h5>
                    <p class="mb-3">{{ $contacts->address }}</p>
                    <a href="{{ $contacts->maps }}" target="_blank" class="btn btn-primary btn-sm text-uppercase px-4">
                        <i class="fa fa-map-marker-alt me-2"></i>Lihat di Google Maps
                    </a>
                </div>
            </div>

            <!-- RIGHT: Contact Info -->
            <div class="col-lg-6">
                <div class="bg-white rounded shadow-sm p-4 h-100">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="text-uppercase fw-bold mb-3 text-dark">Kontak</h5>
                            <p class="mb-2"><i class="bi bi-telephone text-primary me-2"></i>{{ $contacts->phone }}</p>
                            <p class="mb-2"><i class="bi bi-envelope text-primary me-2"></i>{{ $contacts->email }}</p>
                            <p class="mb-0"><i class="fab fa-whatsapp text-primary me-2"></i>
                                <a href="https://wa.me/{{ $contacts->phone }}?text=Halo%20saya%20tertarik%20dengan%20layanan%20Anda"
                                target="_blank" class="text-dark">Chat WhatsApp</a>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <h5 class="text-uppercase fw-bold mb-3 text-dark">Sosial Media</h5>
                            @foreach($sosmeds as $sosmed)
                            <p class="mb-2"><i class="fab {{$sosmed->icon}} text-primary me-2"></i><a href="{{$sosmed->url}}" target="_blank" aria-label="Kunjungi Media Sosial KSP Kontraktor">KSP Kontraktor</a></p>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-uppercase fw-bold mb-3 text-dark">Jam Operasional</h5>
                            <div class="d-flex justify-content-between">
                                <span>Senin – Jumat</span>
                                <span>08.00 – 16.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Sabtu</span>
                                <span>08.00 – 12.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->



    <!-- Footer Start -->
    <div class="footer container-fluid position-relative bg-dark bg-light-radial text-white-50 py-6 px-5">
        @include('web.components.footer')
    </div>
    <!-- Footer End -->

    </div>

    <a href="https://wa.me/{{ $contacts->phone }}?text=Halo%20saya%20tertarik%20dengan%20layanan%20Anda"
        class="whatsapp-float"
        target="_blank"
        aria-label="Chat WhatsApp">
            <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/web/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/web/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/web/js/main.js')}}"></script>
</body>

</html>
