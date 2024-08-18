<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muty Mom and Baby Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html {
            scroll-behavior: smooth;
        }

        #home{
            background-image: url('{{asset('storage/spa-supplies.webp')}}', radial-gradient(circle farthest-corner at 10% 20%, rgba(14, 174, 87, 1) 0%, rgba(12, 116, 117, 1) 90%)) !;
        }
    </style>
</head>

<body>
    <header class="py-3 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                <span class="fs-5 fw-bold">MUTY MOM AND BABY SPA</span>
            </a>
            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                <ul class="nav me-auto">
                    <li class="nav-item"><a href="#home" class="nav-link link-body-emphasis px-2 active"
                            aria-current="page">Home</a></li>
                    <li class="nav-item"><a href="#profile" class="nav-link link-body-emphasis px-2">Profile Spa</a>
                    </li>
                    <li class="nav-item"><a href="#about" class="nav-link link-body-emphasis px-2">Tentang Kami</a>
                    </li>
                    <li class="nav-item"><a href="{{ url('/customer/register') }}" class="nav-link link-body-emphasis px-2">
                        <button class="btn" style="background-color: #FFBF00; font-weight:500;" type="button">Daftar</button>
                    </a></li>
                    
                </ul>
            </div>
        </div>
    </header>

    <div class="b-example-divider"></div>

    {{-- Home --}}
    <section id="home" class="mb-5 bg-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/Backgourd Depan.jpeg') }}'), radial-gradient(circle farthest-corner at 10% 20%, rgba(14, 174, 87, 1) 0%, rgba(12, 116, 117, 1) 90%);
    height: 100vh;
    background-position: center;
    background-size: cover;
    min-height: 100vh;">

        <div class="p-5 text-center ">
            <h1 class="text-light">WELCOME TO MUTY MOM AND BABY SPA</h1>
                   
                
            
            <p class="col-lg-8 mx-auto fs-5 text-light">
        
            </p>
            <div class="d-inline-flex gap-2 mb-5">
                
            </div>
        </div>
    </section>

    </body>
    <html>
    {{-- Profile --}}
    <section id="profile" class="container px-4 py-5">
        <h2 class="pb-2 border-bottom">Profile Spa</h2>

        <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
            <div class="col d-flex flex-column align-items-start gap-2">
                <p class="text-body-secondary"></p>
            </div>Muty Mom and Baby Spa adalah bisnis dalam bidang jasa. kesehatan yang diberikan kepada manusia mulai dari usia 0 bulan - selesai masa menyusui (perempun).
            Otlet muty Mom and Baby Spa berada di Jl.Fatahila, Blok Kleben, Kelurahan Perbutulan, Kecamatan Sumber, Kab Cirebon. Berdiri sejak 25 Maret 2023 hingga saat ini. 
            Muty Mom and Baby Spa memiliki layanan: Baby Spa, Kids Spa, and Moms Spa (Pijat, Terapi, Lulur, Berendam, dan Berenang.) 

            <div class="col">
                <div class="row row-cols-1">
                    {{-- Gambar --}}
                   <img src="{{asset('images/Baby Massage.jpeg') }}" alt="" width="300">
                </div>
            </div>
        </div>
    </section>


    {{-- Tentang --}}
    <section id="about" class="py-3 py-md-5">
        <div class="container">
            <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
                <div class="col-12 col-lg-6 col-xl-5">
                    {{-- Gambar --}}
                    <img src="{{asset('images/Baby Swimming.jpeg') }}" alt="" width="300">
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="row justify-content-xl-center">
                        <div class="col-12 col-xl-11">
                            <h2 class="mb-3">Team Muty Mom and Baby Spa </h2>
                            
                            <p class="mb-5"></p>
                                <p> 1. Owner : Imam A.A,S.Km</p>
                                <p> 2. Bidan Manager : Nokila M.Amd.Keb </p>
                                <p> 3. Bidan Terapis : Rokiah Amd.Keb </P>
                                <p> 4. Bidan Terapis : Maelisa Amd.Keb</p>
                            </p>
                            <div class="row gy-4 gy-md-0 gx-xxl-5X">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex">
                                        <div class="me-4 text-primary">
                                            {{-- <img src="" alt=""> --}}
                                        </div>
                                        <div>
                                            <h2 class="h4 mb-3">VISI</h2>
                                            <p class="text-secondary mb-0"> Menjadi salah satu pelopor pelayanan jasa tumbuh kembang anak dan balita berkelas dan temuka serta memberikan kontribusi ibu hamil hingga masa menyusui.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex">
                                        <div class="me-4 text-primary">
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                                            </svg> --}}
                                        </div>
                                        <div>
                                            <h2 class="h4 mb-3">MISI</h2>
                                            <p class="text-secondary mb-0">
                                                <p> 1. Memberikan pelayanan dan fasilitas yang terbaik bagi anak untuk tumbuh dan berkembang</p>
                                                <p> 2. Memberikan pelayanan secara profesional</P>
                                               <p> 3. Menyediakan, Melakukan inovasi, serta mengembangkan produk maupun layanan yang berorientasi pada customer.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="profile" class="container px-4 py-5">
        <h2 class="pb-2 border-bottom">Lokasi Kami</h2>

        <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
            <div class="col d-flex flex-column align-items-start gap-2">
                <p class="text-body-secondary">JL.FATAHILAH, BLOK KLEBEN, KELURAHAN PERBUTULAN, KECAMATAN SUMBER, KAB CIREBON.</p>
            </div>

            <div class="col">
                <div class="row row-cols-1">
                    {{-- Gambar --}}
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.3085520679933!2d108.49772390000001!3d-6.7321594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1e3cbd1e0ec9%3A0x4fe3b506efe470e3!2sJl.%20Fatahillah%2C%20Kabupaten%20Cirebon%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1720808292125!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
