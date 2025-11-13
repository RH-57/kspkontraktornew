<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WVXBV23');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <title>{{ $service->title }} - PT. Karya Solusi Pembangunan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{asset('assets/web/img/favicon.ico')}}" rel="icon">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="{{asset('assets/web/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/web/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/web/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/web/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVXBV23"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="page-wrapper">
        <!-- Header -->
        @include('web.components.header')

        <!-- Hero Section -->
        <div class="container-fluid page-header py-5">
            <div class="container text-center">
                <h1 class="display-4 text-white fw-bold">{{ $service->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/services">Services</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $service->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Service Detail -->
        <div class="container py-6">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="service-description px-3 px-md-5">
                        {!! $service->description !!}
                    </div>

                    <div class="text-center mt-5">
                        <a href="https://wa.me/{{ $contacts->phone }}?text=Halo%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($service->title) }}"
                        target="_blank"
                        class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fab fa-whatsapp me-2"></i> Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Services -->
        <div class="container py-6">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Layanan Lainnya</h3>
                <p class="text-muted">Temukan solusi konstruksi terbaik lainnya dari kami</p>
            </div>
            <div class="row g-4">
                @foreach($relatedServices as $rel)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('storage/' . $rel->image) }}"
                             class="card-img-top"
                             alt="{{ $rel->title }}"
                             style="object-fit: cover; height: 220px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $rel->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($rel->short_description, 100) }}</p>
                            <a href="{{route('webservice.show', $rel->slug)}}" class="stretched-link text-primary fw-bold">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
       <!-- Footer Start -->
    <div class="footer container-fluid position-relative bg-dark bg-light-radial text-white-50 py-6 px-5">
        @include('web.components.footer')
    </div>
    <!-- Footer End -->
    </div>

    <a href="https://wa.me/{{ $contacts->phone }}?text=Halo%20saya%20tertarik%20dengan%20layanan%20{{$service->title}}"
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
