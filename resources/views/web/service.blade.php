<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Services - PT. Karya Solusi Pembangunan</title>
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

    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Service</h1>
        <div class="d-inline-flex text-white">
            <h6 class="text-uppercase m-0"><a href="">Home</a></h6>
            <h6 class="text-white m-0 px-3">/</h6>
            <h6 class="text-uppercase text-white m-0">Service</h6>
        </div>
    </div>
    <!-- Page Header Start -->

     <!-- Services Start -->
    <div class="container-fluid bg-light py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-7 text-uppercase mb-4">Kami Menyediakan Layanan Konstruksi <span class="text-primary">TERBAIK</span></h1>
        </div>
        <div class="row g-5">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service-item bg-white d-flex flex-column align-items-center text-center h-100">
                    <img
                        class="img-fluid"
                        src="{{ asset('storage/' .$service->image) }}"
                        alt="{{ $service->title }}"
                        style="width: 100%; height: 250px; object-fit: cover; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;"
                    />
                    <div class="service-icon bg-white">
                        <i class="fa fa-3x {{ $service->icon }} text-primary"></i>
                    </div>
                    <div class="px-4 pb-4 d-flex flex-column flex-grow-1">
                        <h4 class="text-uppercase mb-3">{{ $service->title }}</h4>
                        <p class="flex-grow-1">
                            {{ $service->short_description }}
                        </p>
                        <a class="btn text-primary mt-auto" href="{{route('webservice.show' , $service->slug)}}">
                            Read More <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Services End -->

    <div class="container-fluid bg-light py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-7 text-uppercase mb-4">
                Mengapa <span class="text-primary">Harus</span> Memilih Kami?
            </h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Tenaga Ahli</h5>
                    <p class="text-muted mb-0">Tim berpengalaman dan profesional di bidangnya.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-money-bill-wave fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Harga Murah</h5>
                    <p class="text-muted mb-0">Solusi terbaik dengan biaya yang tetap terjangkau.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-pencil-ruler fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Gratis Design</h5>
                    <p class="text-muted mb-0">Kami menyediakan design gratis sesuai kebutuhan Anda.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-map fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Gratis Survey</h5>
                    <p class="text-muted mb-0">Survey lokasi tanpa biaya tambahan.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-check fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Berkualitas</h5>
                    <p class="text-muted mb-0">Material terbaik dan standar pengerjaan tinggi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <i class="fas fa-award fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Bergaransi</h5>
                    <p class="text-muted mb-0">Kami memberikan garansi sebagai bentuk tanggung jawab.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Prosedur Kerja sama -->
    <div class="container-fluid bg-light py-5 px-4">
        <div class="text-center mx-auto mb-4" style="max-width: 600px;">
             <h1 class="display-7 text-uppercase mb-4">
                <span class="text-primary">prosedur</span> Kerja sama
            </h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion modern-accordion" id="proceduresAccordion">
                    @foreach($procedures as $procedure)
                    <div class="accordion-item mb-3 shadow-sm rounded-2">
                        <h2 class="accordion-header" id="heading{{ $procedure->id }}">
                            <button class="accordion-button d-flex align-items-center gap-3 py-2 px-3 fs-6 {{ $loop->first ? '' : 'collapsed' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $procedure->id }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $procedure->id }}">
                                <span class="step-circle fs-5">{{ $procedure->no }}</span>
                                <span class="fw-semibold fs-6 text-dark">{{ $procedure->title }}</span>
                            </button>
                        </h2>
                        <div id="collapse{{ $procedure->id }}"
                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            aria-labelledby="heading{{ $procedure->id }}"
                            data-bs-parent="#proceduresAccordion">
                            <div class="accordion-body fs-6 text-muted">
                                {{ $procedure->description }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




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
