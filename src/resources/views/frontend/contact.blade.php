<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_web/css/contact.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <section class="contact-section py-5" id="contact">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-md-6">
                    <h2 class="mb-4">Contact<span style="color: #107cc1;"> Us</span></h2>
                    <p class="mb-4">Untuk Memberikan Kepuasan Terhadap Pelanggan Kami Mengedepankan Kualitas Produk
                        Sehingga Terjaga Kesinambungan dalam Service Customer dan Kami Memberikan Competitive Price.
                    </p>
                    <form method="POST" action="">
                        @csrf <!-- Token CSRF untuk keamanan -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email aktif" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomer telfon</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomer telfon aktif" required>
                        </div>
                        <div class="mb-3">
                            <label for="inquiry" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="inquiry" name="description" placeholder="Deskripsikan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-50">Send</button>
                    </form>
                    
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif                    
                </div>
                <!-- Map -->
                <div class="col-md-6">
                    <div id="map" class="map-container" style="width: 100%; height: 400px;">
                        <!-- You can embed a Google map iframe here -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.0764298726566!2d107.61912391531698!3d-6.917463695000927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64923df79a1%3A0x401e8f1fc28bf80!2sBandung%2C%20Bandung%20City%2C%20West%20Java%2C%20Indonesia!5e0!3m2!1sen!2sid!4v1635731361030!5m2!1sen!2sid"
                            width="100%" height="400" style="border:0;" allowfullscreen=""
                            loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- footer include --}}

    <script src="style_web/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>

</html>
