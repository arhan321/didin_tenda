<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TRI ASTRA PERSADA</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

@include('frontend.link_css.link')

</head>

<body class="index-page">


@include('frontend.layouts.navbar')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="container">
        <div class="row gy-4">
          @foreach ($Home as $h)
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1>{{$h->title_1}}</h1>
            <p>{{$h->title_2}}</p>
            <div class="d-flex">
              <a href="#about" class="btn-get-started">Get Started</a>
              <!-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> -->
            </div>
          </div>
          @endforeach
          @foreach ($Home as $hj)
          <div class="col-lg-4 order-1 order-lg-2 d-flex justify-content-end" style="margin-left: 10%;" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ $hj->getFirstMediaUrl('image', 'priview') }}" class="img-fluid animated" alt="">
          </div>
          @endforeach
        </div>
      </div>

    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            @foreach ($about as $a)
            <p>
              {{$a->title_1}}
            </p>
            @endforeach
            <ul>
              <li><i class="bi bi-check2-circle"></i> <span>{{ \App\Models\About::find(2)->title_row }}</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>{{ \App\Models\About::find(3)->title_row }}</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>{{ \App\Models\About::find(4)->title_row }}</span></li>
            </ul>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            @foreach ($about as $ab)
            <p>{{$ab->title_2}}</p>
            <!-- <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a> -->
            @endforeach
          </div>

        </div>

      </div>

    </section>
    <!-- /About Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us light-background" data-builder="section">

      <div class="container-fluid">

        <div class="row gy-4">

          <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

            <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
              <h3 style="margin-bottom:5%"><span>mengapa memilih</span><strong> TRI ASTRA PERSADA?</strong></h3>
              <p>
                <!-- Mengapa Memilih TRI ASTRA PERSADA? -->
              </p>
            </div>

            <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
              @foreach ($about2 as $a)
              {{-- <div class="faq-item faq-active"> --}}
                <div class="faq-item">
                <h3><span>{{$a->no}}</span> {{$a->title_1}}</h3>
                <div class="faq-content">
                  <p>{{$a->title_row}}</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>
              @endforeach
              <!-- End Faq item-->
            </div>

          </div>

          <div class="col-lg-5 order-1 order-lg-2 why-us-img">
            <img src="frontend/img/logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
          </div>
        </div>

      </div>

    </section>
    <!-- /Why Us Section -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Category Barang Sewa TRI ASTRA PERSADA</p>
      </div><!-- End Section Title -->

      <div class="container">
   
        <div class="row gy-4 justify-content-center">
          @foreach ($services as $s)
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <div class="icon"><i class="{{$s->icon}}"></i></div>
              <h4><a href="" class="stretched-link">{{$s->title_1}}</a></h4>
              <p>{{$s->text}}</p>
            </div>
          </div>
          @endforeach
        </div>
     
      </div>

    </section>
    <!-- /Services Section -->

 <!-- Portfolio Section -->
 <section id="portfolio" class="portfolio section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Product</h2>
    <p>Product Penyewaan yang tersedia di TRI ASTRA PERSADA</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
          <li data-filter="*" class="filter-active">All</li>
          {{-- Ambil kategori unik dari produk --}}
          @foreach ($products->pluck('category')->unique() as $category)
              <li data-filter=".filter-{{ $category }}">{{ ucfirst($category) }}</li>
          @endforeach
      </ul><!-- End Portfolio Filters -->
  
      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
          @if($products->isNotEmpty())
              @foreach ($products as $portfolio)
                  <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ $portfolio->category }}">
                      {{-- Pastikan gambar yang diambil dari media sudah ada dan sesuai --}}
                      <img src="{{ $portfolio->getFirstMediaUrl('image', 'priview')  }}" class="img-fluid" alt="{{ $portfolio->title_1 }}">
                      <div class="portfolio-info">
                          <h4>{{ $portfolio->title_1 }}</h4>
                          <p>{{ $portfolio->title_2 }}</p>
                          <a href="{{ $portfolio->getFirstMediaUrl('image', 'priview')  }}" title="{{ $portfolio->title_1 }}" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                          <a href="" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                      </div>
                  </div><!-- End Portfolio Item -->
              @endforeach
          @else
              <div class="col-lg-12 text-center">
                  <h3>Product belum di input oleh admin</h3>
              </div>
          @endif
      </div><!-- End Portfolio Container -->
  </div>

</div>

</section><!-- /Portfolio Section -->



    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Team CV. TRI ASTRA PERSADA</p>
      </div>
      <!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

        @foreach ($team as $t)
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="{{ $t->getFirstMediaUrl('image', 'priview')  }}" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>{{$t->name}}</h4>
                <span>{{$t->position}}</span>
                <p>{{$t->description}}</p>
                <div class="social">
                  <!-- <a href=""><i class="bi bi-twitter-x"></i></a> -->
                  <!-- <a href=""><i class="bi bi-facebook"></i></a> -->
                  <!-- <a href=""><i class="bi bi-instagram"></i></a> -->
                  <!-- <a href=""> <i class="bi bi-linkedin"></i> </a> -->
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->
          @endforeach
        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section light-background" style="margin-top: 5%; margin-bottom:5%">

      <section id="clients" class="clients section light-background" >

        <div class="container section-title" data-aos="fade-up">
          <h2>Client</h2>
          <p>Client bisnis TRI ASTRA PERSADA</p>
        </div>

        <div class="container" data-aos="zoom-in">
          <style>
            .swiper-wrapper {
                display: flex;
                align-items: center;
            }
        
            /* Center single slide */
            .swiper-wrapper.center-slide {
                justify-content: center;
            }
        
            /* Adjust spacing for different screen sizes */
            @media (min-width: 320px) {
                .swiper-slide {
                    margin-right: 40px;
                }
            }
        
            @media (min-width: 480px) {
                .swiper-slide {
                    margin-right: 60px;
                }
            }
        
            @media (min-width: 640px) {
                .swiper-slide {
                    margin-right: 80px;
                }
            }
        
            @media (min-width: 992px) {
                .swiper-slide {
                    margin-right: 120px;
                }
            }
        
            @media (min-width: 1200px) {
                .swiper-slide {
                    margin-right: 120px;
                }
            }
          </style>
        
          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 5000
                },
                "slidesPerView": "auto",
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "breakpoints": {
                  "320": { "slidesPerView": 2, "spaceBetween": 40 },
                  "480": { "slidesPerView": 3, "spaceBetween": 60 },
                  "640": { "slidesPerView": 4, "spaceBetween": 80 },
                  "992": { "slidesPerView": 5, "spaceBetween": 120 },
                  "1200": { "slidesPerView": 6, "spaceBetween": 120 }
                }
              }
            </script>
        
            <div class="swiper-wrapper align-items-center {{ count($clients) === 1 ? 'center-slide' : '' }}">
              @foreach ($clients as $c)
              <div class="swiper-slide">
                <img src="{{ $c->getFirstMediaUrl('image', 'priview') }}" class="img-fluid" alt="">
              </div>
              @endforeach
            </div>
          </div>
        </div>
        
  
        </div>
  
      </section>

    </section>
    <!-- /Pricing Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">

            <div class="info-wrap">
              @foreach ($settings as $set)
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Address</h3>
                  <p>{{ $set->address}}</p>
                </div>
              </div>
              @endforeach
              @foreach ($settings as $set)
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Call Us</h3>
                  <p>{{ $set->phone}}</p>
                </div>
              </div>
              @endforeach
              @foreach ($settings as $set)
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email Us</h3>
                  <p>{{ $set->email}}</p>
                </div>
              </div>
              @endforeach
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.778957513761!2d106.7970682757306!3d-6.160351760378373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f66b8c3d6ecf%3A0x6587ca77f60a48d2!2sJl.%20Kalianyar%20X%20No.15%2C%20RT.16%2FRW.8%2C%20Kali%20Anyar%2C%20Kec.%20Tambora%2C%20Kota%20Jakarta%20Barat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2011310!5e0!3m2!1sid!2sid!4v1734426313495!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-7">
            <form action="" method="POST" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              @csrf
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Your Name</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>

                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Subject</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Message</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                </div>

                {{-- <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div> --}}

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div>
          <!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <!-- <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div>
        </div>
      </div> -->
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          @foreach ($settings as $s)
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">{{$s->company_name}}</span>
          </a>
          @endforeach
          @foreach ($settings as $se)
          <div class="footer-contact pt-3">
            <p>{{ $se->address }}</p>
            <p class="mt-3"><strong>Phone:</strong> <span>{{ $se->phone }}</span></p>
            <p><strong>Email:</strong> <span>{{ $se->email }}</span></p>
          </div>
          @endforeach
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Product</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Team</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Client</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            @foreach ( $services as $serv )
            <li><i class="bi bi-chevron-right"></i> <a href="#">{{ $serv->title_1 }}</a></li>
            @endforeach
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us Social Media</h4>
          {{-- <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p> --}}
          <div class="social-links d-flex">
            @foreach ($socialmedias as $sos)
            <a href="{{ $sos->link }}"><i class="{{ $sos->icon }}"></i></a>
            @endforeach
          </div>
        </div>

      </div>
    </div>

    {{-- <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">TRI ASTRA PERSADA</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div> --}}

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  @include('frontend.script.script')

</body>

</html>