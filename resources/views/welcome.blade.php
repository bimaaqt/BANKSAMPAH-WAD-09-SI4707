<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bank Sampah - Solusi Pengelolaan Sampah Modern</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .hero-section {
                background-color: #f8f9fa;
                padding: 80px 0;
                margin-bottom: 40px;
            }
            .feature-card {
                transition: transform 0.3s;
                margin-bottom: 20px;
            }
            .feature-card:hover {
                transform: translateY(-5px);
            }
            .icon-feature {
                font-size: 2.5rem;
                color: #198754;
                margin-bottom: 20px;
            }
            .footer {
                background-color: #198754;
                color: white;
                padding: 40px 0;
                margin-top: 60px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-recycle me-2"></i>Bank Sampah
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#layanan">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">Kontak</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 mb-4">Ubah Sampah Menjadi Rupiah</h1>
                        <p class="lead mb-4">Bank Sampah adalah platform inovatif yang membantu Anda mengelola sampah dengan bijak sambil mendapatkan keuntungan finansial.</p>
                        @guest
                            <div class="mb-4">
                                <a href="{{ route('register') }}" class="btn btn-success btn-lg me-3">Mulai Sekarang</a>
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg">Login</a>
                            </div>
                        @endguest
                    </div>
                    <div class="col-md-6">
                        <img src="https://img.freepik.com/free-vector/garbage-recycling-isometric-composition_1284-23962.jpg" 
                             alt="Bank Sampah Hero" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="container my-5">
            <h2 class="text-center mb-5">Layanan Kami</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-trash-alt icon-feature"></i>
                            <h3>Sampah Organik</h3>
                            <p>Kelola sampah organik Anda dengan benar. Kami menerima berbagai jenis sampah organik yang dapat dikompos.</p>
                            <ul class="list-unstyled">
                                <li>✓ Sisa makanan</li>
                                <li>✓ Daun-daunan</li>
                                <li>✓ Sayuran busuk</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-recycle icon-feature"></i>
                            <h3>Sampah Non-Organik</h3>
                            <p>Daur ulang sampah non-organik Anda. Kami menerima berbagai jenis sampah yang dapat didaur ulang.</p>
                            <ul class="list-unstyled">
                                <li>✓ Plastik</li>
                                <li>✓ Kertas</li>
                                <li>✓ Logam</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-coins icon-feature"></i>
                            <h3>Poin Rewards</h3>
                            <p>Dapatkan poin untuk setiap sampah yang Anda setorkan. Tukarkan poin Anda dengan berbagai hadiah menarik.</p>
                            <ul class="list-unstyled">
                                <li>✓ Tukar dengan uang</li>
                                <li>✓ Voucher belanja</li>
                                <li>✓ Produk daur ulang</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="container my-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="https://img.freepik.com/free-vector/garbage-collection-abstract-concept-illustration_335657-4899.jpg" 
                         alt="Tentang Kami" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-4">Mengapa Memilih Kami?</h2>
                    <div class="mb-4">
                        <h5><i class="fas fa-check-circle text-success me-2"></i>Mudah Digunakan</h5>
                        <p>Platform user-friendly yang memudahkan Anda mengelola sampah.</p>
                    </div>
                    <div class="mb-4">
                        <h5><i class="fas fa-check-circle text-success me-2"></i>Rewards Menarik</h5>
                        <p>Dapatkan poin untuk setiap sampah yang Anda setorkan.</p>
                    </div>
                    <div class="mb-4">
                        <h5><i class="fas fa-check-circle text-success me-2"></i>Ramah Lingkungan</h5>
                        <p>Berkontribusi dalam menjaga lingkungan dengan mengelola sampah secara bertanggung jawab.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Bank Sampah</h4>
                        <p>Solusi modern untuk pengelolaan sampah yang menguntungkan dan ramah lingkungan.</p>
                    </div>
                    <div class="col-md-4">
                        <h4>Kontak</h4>
                        <p><i class="fas fa-envelope me-2"></i>info@banksampah.com</p>
                        <p><i class="fas fa-phone me-2"></i>+62 123 4567 890</p>
                        <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Sampah Berkah No. 123</p>
                    </div>
                    <div class="col-md-4">
                        <h4>Ikuti Kami</h4>
                        <div class="social-links">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
