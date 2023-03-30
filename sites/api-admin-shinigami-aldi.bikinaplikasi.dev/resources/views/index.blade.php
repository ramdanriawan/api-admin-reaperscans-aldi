<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('') }}/fonts/icomoon/style.css">
    <link rel="stylesheet" href="{{ url('') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ url('') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ url('') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ url('') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ url('') }}/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{ url('') }}/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{ url('') }}/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="{{ url('') }}/css/aos.css">
    <link rel="stylesheet" href="{{ url('') }}/css/style.css">

</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <div class="border-bottom top-bar py-2 bg-dark sticky-top" id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        @if(!auth()->user())
                        <a href="{{ url('login') }}" class="btn  btn-primary">Login</a>
                        @else
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn  btn-danger" type="submit"
                               onclick="event.preventDefault(); if(confirm('Yakin akan logut?')) this.closest('form').submit(); ">
                                <i class="fa fa-power-off"></i> Logout
                            </button>
                        </form>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="social-media">
                        <li><a href="#" class="btn btn-sm btn-outline-prmary p-2">Home</span></a></li>
                        <li><a href="#kegiatan" class="btn btn-sm btn-outline-prmary p-2">Kegiatan</span></a></li>
                        <li><a href="#profil" class="btn btn-sm btn-outline-prmary p-2">Profil</span></a></li>
                        <li><a href="#kontak" class="btn btn-sm btn-outline-prmary p-2">Kontak</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header class="site-navbar bg-white site-navbar-target py-2" role="banner" style="z-index: -1">

        <div class="container">
            <div class="row align-items-center">

                <div class="col-11">
                    <h1 class="mb-0 site-logo py-auto">
                        <a href="index.html" class="text-black h2 mb-0">
                            <marquee>PANTI ASUHAN AISYIYAH KUALA TUNGKAL</marquee>
                        </a>
                    </h1>
                </div>

                {{--                <div class="col-12 col-md-10 d-none d-xl-block">--}}
                {{--                    <nav class="site-navigation position-relative text-right" role="navigation">--}}

                {{--                        <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">--}}
                {{--                            <li><a href="#home-section" class="nav-link">Home</a></li>--}}
                {{--                            <li><a href="#work-section" class="nav-link">Work</a></li>--}}
                {{--                            <li>--}}
                {{--                                <a href="#services-section" class="nav-link">Services</a>--}}
                {{--                            </li>--}}
                {{--                            <li class="has-children">--}}
                {{--                                <a href="#about-section" class="nav-link">About</a>--}}
                {{--                                <ul class="dropdown">--}}
                {{--                                    <li><a href="#about-section">Specialties</a></li>--}}
                {{--                                    <li><a href="#team-section">Our Team</a></li>--}}
                {{--                                </ul>--}}
                {{--                            </li>--}}
                {{--                            <li><a href="#blog-section" class="nav-link">Blog</a></li>--}}
                {{--                            <li><a href="#contact-section" class="nav-link">Contact</a></li>--}}
                {{--                        </ul>--}}
                {{--                    </nav>--}}
                {{--                </div>--}}


                {{--                <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a--}}
                {{--                        href="#" class="site-menu-toggle js-menu-toggle text-black"><span--}}
                {{--                            class="icon-menu h3"></span></a></div>--}}

            </div>
        </div>

    </header>


    <div class="site-blocks-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade"
         data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">

                <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8 text-center">
                            <h1>Perduli dan Menyayangi Anak <br><span class="typed-words"></span></h1>
                            <p class="lead mb-5">Anak adalah harapan masa depan</p>
                            {{--                            <div><a data-fancybox data-ratio="2" href="https://vimeo.com/317571768"--}}
                            {{--                                    class="btn btn-primary btn-md">Watch Video</a></div>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <div class="site-section" id="profil">
        <div class="container">
            <div class="row mb-5">

                <div class="col-md-5 ml-auto order-md-2" data-aos="fade">
                    <img src="{{ url($profil->gambar) }}" alt="Image" class="img-fluid rounded mb-5">
                    
                    <iframe width="100%" height="240" id="gmap_canvas" src="https://maps.google.com/maps?q={{ urlencode($profil->alamat) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br><style>.mapouter{position:relative;text-align:right;height:500px;width:600px;}</style><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style>
                </div>

                <div class="col-md-6 order-md-1" data-aos="fade">

                    <div class="row">

                        <div class="col-12">
                            <div class="text-left pb-1">
                                <h2 class="text-black h1 site-section-heading">Profil</h2>
                            </div>
                        </div>
                        <div class="col-12 mb-5">
                            <p class="lead text-justify">{{ $profil->deskripsi }}</p>
                        </div>
                        <div class="col-md-12 mt-5 mb-md-6 mb-0 col-lg-6">
                            <div class="unit-4">
                                <div class="unit-4-icon mr-4 mb-3"><span
                                        class="text-secondary icon-location_city"></span>
                                </div>
                                <div>
                                    <p class="text-justify">{{ $profil->alamat }}</p>
                                    <p class="mb-0"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5 mb-md-6 mb-0 col-lg-6" id="kontak">
                            <div class="unit-4">
                                <div class="unit-4-icon mr-4 mb-3"><span class="text-secondary icon-address-book"></span>
                                </div>
                                <div>
                                    <p><i class="icon icon-phone"></i> {{ $profil->no_hp }} <br>
                                    <i class="icon icon-facebook"></i> {{ $profil->akun_facebook }} <br>
                                    <i class="icon icon-instagram"></i> {{ $profil->akun_instagram }} <br>
                                    <i class="icon icon-whatsapp"></i> {{ $profil->no_whatsapp }}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>


    <section class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="p-3 box-with-humber">
                        <div class="number-behind">01.</div>
                        <h2 class="text-primary">Visi</h2>
                        <p class="mb-4">{{ $visi }}</p>
                        {{--                        <ul class="list-unstyled ul-check primary">--}}
                        {{--                            <li>Customer Experience</li>--}}
                        {{--                            <li>Product Management</li>--}}
                        {{--                            <li>Proof of Concept</li>--}}
                        {{--                        </ul>--}}
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="p-3 box-with-humber">
                        <div class="number-behind">02.</div>
                        <h2 class="text-primary">Misi</h2>
                        {{--                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Et praesentium eos--}}
                        {{--                            nulla qui commodi consectetur beatae fugiat. Veniam iste rerum perferendis.</p>--}}
                        <ul class="list-unstyled ul-check primary">
                            @forelse($misi as $item)
                            <li>{{ $item }}</li>
                            @empty
                            - Belum Ada Misi -
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="site-section" id="kegiatan">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="text-black h1 site-section-heading text-center">Kegiatan Panti</h2>
                    <p class="lead"></p>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                @forelse($kegiatan_panti as $item)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url($item->gambar) }}" class="media-1" data-fancybox="gallery">
                        <img src="{{ url($item->gambar) }}" alt="Image" class="img-fluid">
                        <div class="media-1-content p-2">
                            <h2>{{$item->judul}}</h2>
                            <span class="category">{{ $item->deskripsi }}</span>
                        </div>
                    </a>
                </div>
                @empty
                - Tidak Ada Kegiatan -
                @endforelse

            </div>
        </div>
    </section>

    


    <div class="site-section border-bottom" id="team-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 text-center">
                    <h2 class="text-black h1 site-section-heading">Rekening Donasi</h2>
                </div>
            </div>
            <div class="row">
                @forelse($rekening_donasi as $item)
                <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <div class="text-center">
                        <img src="{{ $item->gambar }}" alt="Image"
                             class="img-fluid w-50">
                        <h3>{{ $item->no_rekening }}</h3>
                        <p class="position text-muted">{{ $item->atas_nama }}</p>

                    </div>
                </div>
                @empty
                    
                @endforelse
                
            </div>
        </div>
    </div>


    <section class="site-section bg-light" id="contact-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="text-black h1 site-section-heading">Donasi & Buku Tamu</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-5">
                    <form action="{{ route('donatur.store') }}" class="p-5 bg-white" method="post">

                        <h2 class="h4 text-black mb-5">Isi form jika berdonasi</h2>

                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="text-black" for="nama">Nama *</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="no_hp">No Hp</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="subject">Nama Pemilik Rekening *</label>
                                <input type="text" name="nama_pemilik_rekening" id="subject" class="form-control" required>
                            </div>
                        </div>
                        
                        
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="subject">Jumlah *</label>
                                <input type="text" name="jumlah" id="subject" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="message">Pesan</label>
                                <textarea name="pesan" id="message" cols="30" rows="7" class="form-control"
                                          placeholder="Tulis pesan..."></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="submit" value="Kirim" class="btn btn-primary btn-md text-white">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-md-6 mb-5">
                    <form action="{{ route('buku-tamu.store') }}" class="p-5 bg-white" method="post">

                        <h2 class="h4 text-black mb-5">Buku Tamu</h2>

                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="text-black" for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="text-black" for="pesan_kesa">Pesan / Kesan</label>
                                <textarea name="pesan_kesan" id="pesan_kesa" cols="30" rows="7" class="form-control"
                                          placeholder="Tulis pesan / kesan..."></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="submit" value="Kirim" class="btn btn-primary btn-md text-white">
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">

            <div class="row text-center">
                <div class="col-md-12">
                    <div class="border-top text-white pt-3">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | PANTI ASUHAN AISYIYAH KUALA TUNGKAL.</a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</div> <!-- .site-wrap -->

<script src="{{ url('') }}/js/jquery-3.3.1.min.js"></script>
<script src="{{ url('') }}/js/jquery-migrate-3.0.1.min.js"></script>
<script src="{{ url('') }}/js/jquery-ui.js"></script>
<script src="{{ url('') }}/js/popper.min.js"></script>
<script src="{{ url('') }}/js/bootstrap.min.js"></script>
<script src="{{ url('') }}/js/owl.carousel.min.js"></script>
<script src="{{ url('') }}/js/jquery.stellar.min.js"></script>
<script src="{{ url('') }}/js/jquery.countdown.min.js"></script>
<script src="{{ url('') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ url('') }}/js/jquery.easing.1.3.js"></script>
<script src="{{ url('') }}/js/aos.js"></script>
<script src="{{ url('') }}/js/jquery.fancybox.min.js"></script>
<script src="{{ url('') }}/js/jquery.sticky.js"></script>

<script src="{{ url('') }}/js/typed.js"></script>
<script>
    var typed = new Typed('.typed-words', {
        strings: [" Sepenuh Hati"],
        typeSpeed: 80,
        backSpeed: 80,
        backDelay: 4000,
        startDelay: 1000,
        loop: true,
        showCursor: true
    });
</script>

<script src="{{ url('') }}/js/main.js"></script>

</body>
</html>