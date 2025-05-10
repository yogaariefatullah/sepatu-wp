<?php include 'headerhome.php'; ?>
<?php
if (isset($_SESSION["akun"])) { ?>
<div class="carousel-header">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="assets/assets_home/img/bg.jpg" class="img-fluid" alt="Image">
                <div class="carousel-caption">
                    <div class="text-center p-4" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase fw-bold mb-3 mb-md-4 wow fadeInUp" data-wow-delay="0.1s">Selamat Datang <?= $_SESSION['akun']['nama'] ?><br><br> di Sistem Pendukung Keputusan Pemilihan Sepatu Olahraga Menggunakan Metode Weighted Product (WP) di Emporio Armani 7</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
    <div class="carousel-header">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="assets/assets_home/img/bg.jpg" class="img-fluid" alt="Image">
                <div class="carousel-caption">
                    <div class="text-center p-4" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase fw-bold mb-3 mb-md-4 wow fadeInUp" data-wow-delay="0.1s">Selamat Datang <br><br> di Sistem Pendukung Keputusan Pemilihan Sepatu Olahraga Menggunakan Metode Weighted Product (WP) di Emporio Armani 7</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php include 'footerhome.php'; ?>