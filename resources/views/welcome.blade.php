<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ASIAP</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/landingpages/img/iconWebsite.png') }}" rel="icon">
  <link href="{{ asset('assets/landingpages/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/landingpages/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landingpages/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('assets/landingpages/css/style.css') }}" rel="stylesheet">
  	   @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top" style="background-color: white;">
    <div class="container d-flex align-items-center">

     <a href="index.html" class="logo me-auto"><img src="{{ asset('assets/landingpages/img/asiap2.png') }}" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active text-dark" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto active text-dark" href="#buku">Buku</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle" style="color: black;"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center bg-light">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1 class="text-dark mb-3">Selamat Datang di Halaman Mencari Buku</h1>
          <h4 class="text-muted" style="font-size: 17px;">Selamat datang di halaman pencarian buku, di sini Anda dapat menemukan berbagai informasi lengkap tentang buku-buku terbaru, ulasan, dan rekomendasi bacaan menarik.</h4>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{ asset('assets/landingpages/img/caribuku.jpg') }}" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>
    

  </section><!-- End Hero -->

  <main id="main">

    <section class="inner-page">
      <div class="container">
      

        

        <section id="buku" class="portfolio">
          <div class="container" data-aos="fade-up">
        
            <div class="section-title">
              <form action="/search" method="get" class="search-form" data-aos="fade-up">
                <h2><i class="bx bx-search-alt"></i> Form Pencarian Buku</h2>
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Masukkan judul buku..." style="border-radius: 20px;">
                  <button type="submit" class="btn btn-primary" style="border-radius: 20px; margin-left: 5px;">Cari</button>
                </div>
              </form>
            </div>
            
            <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
              <li data-filter="*" class="filter-active">Semua</li>
              <li data-filter=".filter-novel">Novel</li>
              <li data-filter=".filter-sejarah">Sejarah</li>
              <li data-filter=".filter-pelajaran">Pelajaran</li>
            </ul>
        
            <style>
              #portfolio-flters {
              display: flex;
              flex-wrap: wrap;
              justify-content: center;
              padding: 0;
              margin: 0;
              list-style: none;
            }
        
            #portfolio-flters li {
              margin: 5px 10px;
              padding: 10px 20px;
              background: #f8f8f8;
              border-radius: 5px;
              cursor: pointer;
              transition: background 0.3s;
            }
        
            #portfolio-flters li:hover {
              background: #ddd;
            }
        
            #portfolio-flters .filter-active {
              background: #007bff;
              color: white;
            }
        
            @media (max-width: 600px) {
              #portfolio-flters li {
                flex: 1 1 100%;
                text-align: center;
              }
            }
        
            </style>
            
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-novel">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/novel1.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Novel 1</h4>
                  <a href="{{ asset('assets/landingpages/img/novel1.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="NovLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.el 1"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-pelajaran">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/sejarah1.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Sejarah 1</h4>
                  <a href="{{ asset('assets/landingpages/img/sejarah1.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="SejLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.arah 1"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-novel">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/novel2.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Novel 2</h4>
                  <a href="{{ asset('assets/landingpages/img/novel2.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="NovLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.el 2"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-sejarah">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/sejarah2.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Sejarah 2</h4>
                  <a href="{{ asset('assets/landingpages/img/sejarah2.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="SejLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.arah 2"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-pelajaran">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/pelajaran2.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Pelajaran 2</h4>
                  <a href="{{ asset('assets/landingpages/img/pelajaran2.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="PelLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.ajaran 2"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-novel">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/novel3.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Novel 3</h4>
                  <a href="{{ asset('assets/landingpages/img/novel3.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="NovLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.el 3"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 portfolio-item filter-novel">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/novel1.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Novel 1</h4>
                  <a href="{{ asset('assets/landingpages/img/novel1.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="NovLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.el 1"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
              <div class="col-lg-4 col-md-6 portfolio-item filter-pelajaran">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/sejarah1.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Sejarah 1</h4>
                  <a href="{{ asset('assets/landingpages/img/sejarah1.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="SejLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.arah 1"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
              
              <div class="col-lg-4 col-md-6 portfolio-item filter-pelajaran">
                <div class="portfolio-img"><img src="{{ asset('assets/landingpages/img/pelajaran2.jpg') }}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                  <h4>Pelajaran 2</h4>
                  <a href="{{ asset('assets/landingpages/img/pelajaran2.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="PelLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.ajaran 2"><i class="bx bx-plus"></i></a>
                  <a href="detail.html" class="details-link" title="detail"><i class="bx bx-link"></i></a>
                </div>
              </div>
        
  
   
        
            </div>

        </section><!-- End Portfolio Section -->
        


      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container footer-bottom clearfix">
      <div class="copyright text-warning">
        &copy; Copyright <strong><span>CreativeCode5 & Ziyutechno</span></strong>. All Rights Reserved
      </div>

    </div>
  </footer><!-- End Footer -->
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short" style="color: yellow;"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/landingpages/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/landingpages/vendor/waypoints/noframework.waypoints.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/landingpages/js/main.js') }}"></script>

</body>

</html>