<?php include 'headerhome.php';
error_reporting(1);
ini_set('display_errors', 1);

// Mendapatkan id akun pengguna yang sedang login
$idakun = $_SESSION['akun']['idakun'];
$nik = $_SESSION['akun']['nik'];
$ambildata = $koneksi->query("SELECT * FROM akun WHERE idakun='$idakun'");
$data = $ambildata->fetch_assoc();

// Ambil data riwayat pencarian sepatu oleh pengguna
$resultRiwayatPencarian = $koneksi->query("SELECT DISTINCT id_sepatu FROM hasil_rekomendasi WHERE id_user = '$idakun'");
$riwayatSepatu = [];
while ($row = $resultRiwayatPencarian->fetch_assoc()) {
    $riwayatSepatu[] = $row['id_sepatu']; // Menyimpan id_sepatu yang dicari oleh pengguna
}

// Jika pengguna tidak mencari sepatu apapun, tampilkan pesan
if (count($riwayatSepatu) === 0) {
    echo "<div class='alert alert-info'>Anda belum mencari sepatu apapun.</div>";
    exit;
}

// Ambil data sepatu yang pernah dicari berdasarkan riwayat
$sepatuData = [];
foreach ($riwayatSepatu as $id_sepatu) {
    // echo($id_sepatu);die;
    $resultSepatu = $koneksi->query("SELECT id_sepatu, nama_sepatu, gambar FROM sepatu WHERE id_sepatu = '$id_sepatu'");
    while ($row = $resultSepatu->fetch_assoc()) {
        $sepatuData[$row['id_sepatu']] = [
            'id_sepatu' => $row['id_sepatu'],
            'nama_sepatu' => $row['nama_sepatu'],
            'gambar' => $row['gambar']
        ];
    }
}


// Ambil data nilai untuk user yang dipilih
$resultUserValues = $connection->query("SELECT kd_kriteria, nilai FROM nilai WHERE nik = '$nik'");
$userValues = [];
while ($row = $resultUserValues->fetch_assoc()) {
    $userValues[$row['kd_kriteria']] = $row['nilai'];
}

// Ambil data kriteria dan tipe (max/min) untuk normalisasi
$resultKriteria = $connection->query("SELECT kd_kriteria, nama, sifat FROM kriteria");
$kriteriaTipe = [];
$kriteriaNames = []; // Array untuk menyimpan nama kriteria
while ($row = $resultKriteria->fetch_assoc()) {
    $kriteriaTipe[$row['kd_kriteria']] = $row['sifat']; // Menyimpan tipe kriteria (max/min)
    $kriteriaNames[$row['kd_kriteria']] = $row['nama']; // Menyimpan nama kriteria
}

// Ambil data bobot untuk sepatu
$resultBobot = $connection->query("SELECT id_sepatu, kd_kriteria, bobot FROM bobot_kriteria");
$bobotData = [];
while ($row = $resultBobot->fetch_assoc()) {
    $bobotData[$row['id_sepatu']][$row['kd_kriteria']] = $row['bobot'];
}

// Ambil data nilai kriteria untuk normalisasi
$resultNilaiKriteria = $connection->query("SELECT kd_kriteria, nilai FROM nilai_kriteria");
$nilaiKriteria = [];
while ($row = $resultNilaiKriteria->fetch_assoc()) {
    $nilaiKriteria[$row['kd_kriteria']] = $row['nilai'];
}

// Hitung normalisasi berdasarkan tipe max/min
$normalizedData = [];
foreach ($bobotData as $id_sepatu => $kriteriaData) {
    $normalizedData[$id_sepatu] = [];
    foreach ($kriteriaData as $kd_kriteria => $bobot) {
        $nilai = $nilaiKriteria[$kd_kriteria] ?? 1; // Nilai kriteria, jika tidak ada, gunakan nilai default 1
        $tipe = $kriteriaTipe[$kd_kriteria] ?? 'max';  // Ambil tipe kriteria (max/min), default ke 'max' jika tidak ada

        // Pastikan userValues[$kd_kriteria] ada dan valid
        $userValue = $userValues[$kd_kriteria] ?? 1;  // Jika tidak ada, gunakan nilai default 1

        // Normalisasi untuk tipe max (lebih besar lebih baik)
        if ($tipe == 'max') {
            // Menghindari pembagian dengan 0, jika nilai adalah 0 maka set ke 1
            $normalized = $nilai != 0 ? $userValue / $nilai : 1;  // Normalisasi biasa
        }
        // Normalisasi untuk tipe min (lebih kecil lebih baik)
        else if ($tipe == 'min') {
            // Menghindari pembagian dengan 0, jika nilai adalah 0 maka set ke 1
            $normalized = $nilai != 0 ? $nilai / $userValue : 1;  // Normalisasi terbalik
        }

        // Simpan hasil normalisasi
        $normalizedData[$id_sepatu][$kd_kriteria] = $normalized;
    }
}

// Hitung skor akhir untuk setiap sepatu
$scores = [];
foreach ($normalizedData as $id_sepatu => $kriteriaNormalized) {
    // Hanya hitung skor jika sepatu ada di $sepatuData
    if (!isset($sepatuData[$id_sepatu])) {
        continue;
    }

    $score = 0;
    foreach ($kriteriaNormalized as $kd_kriteria => $normalizedValue) {
        $score += $normalizedValue * $bobotData[$id_sepatu][$kd_kriteria];
    }
    $scores[$id_sepatu] = $score;
}
arsort($scores);


?>

<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Hasil Pencarian Sepatu Anda</h3>
        <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-white">Hasil Pencarian</a></li>
        </ol>
    </div>
</div>

<!-- Daftar Sepatu dan Skor -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-5">
            <?php
            $ranking = 1;
            foreach ($scores as $id_sepatu => $skor) {
                if (!isset($sepatuData[$id_sepatu])) {
                    echo "ID sepatu $id_sepatu tidak ditemukan di sepatuData<br>";
                    continue;
                }
                $sepatu = $sepatuData[$id_sepatu];





                ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="foto/<?php echo $sepatu['gambar']; ?>" class="card-img-top img-fluid rounded" alt="<?php echo $sepatu['nama_sepatu']; ?>" style="object-fit: cover; height: 250px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $sepatu['nama_sepatu']; ?></h5>
                            <p class="card-text">Ranking: <?php echo $ranking++; ?></p>
                            <p class="card-text">Skor: <?php echo number_format($skor, 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include 'footerhome.php'; ?>