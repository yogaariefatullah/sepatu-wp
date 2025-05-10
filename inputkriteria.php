<?php
include 'headerhome.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil pilihan warna dari database
$warna_query = $koneksi->query("SELECT DISTINCT warna FROM sepatu ORDER BY warna ASC");

// Proses saat form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    // Ambil data preferensi dari form
    $gender = $_POST["gender"];
    $olahraga = $_POST["olahraga"];
    $warna = $_POST["warna"];
    $kelenturan = $_POST["kelenturan"];
    $tebal_sol = $_POST["tebal_sol"];

    // Query sepatu yang cocok dengan preferensi
    $query = $koneksi->query("SELECT * FROM sepatu WHERE gender = '$gender' AND jenis_olahraga LIKE '%$olahraga%' AND warna LIKE '%$warna%' AND kelenturan LIKE '%$kelenturan%' AND tebal_sol LIKE '%$tebal_sol%'");

    if ($query->num_rows > 0) {
        $results = [];

        while ($row = $query->fetch_assoc()) {
            $skor_wp = 1;
            $id_sepatu = $row['id_sepatu'];

            // Ambil bobot kriteria untuk sepatu ini
            $bobot_query = $koneksi->query("SELECT * FROM bobot_kriteria WHERE id_sepatu = '$id_sepatu'");
            $bobot_data = [];
            while ($bobot_row = $bobot_query->fetch_assoc()) {
                $bobot_data[$bobot_row['kd_kriteria']] = $bobot_row['bobot'];
            }

            // Preferensi pengguna
            $kriteria = [
                'gender' => $gender,
                'jenis_olahraga' => $olahraga,
                'warna' => $warna,
                'kelenturan' => $kelenturan,
                'tebal_sol' => $tebal_sol
            ];

            $penjelasan = [];

            // Hitung skor WP
            foreach ($kriteria as $kriteria_name => $preferensi_value) {
                $nilai_sepatu = $row[$kriteria_name];
                $bobot = isset($bobot_data[$kriteria_name]) ? $bobot_data[$kriteria_name] : 1;

                if ($nilai_sepatu == $preferensi_value) {
                    $nilai_kecocokan = 1;
                    $keterangan = "Cocok (nilai 1)";
                } else {
                    $nilai_kecocokan = 0.75;
                    $keterangan = "Kurang cocok (nilai 0.75)";
                }

                $kontribusi = pow($nilai_kecocokan, $bobot);
                $skor_wp *= $kontribusi;

                $penjelasan[] = ucfirst($kriteria_name) . " = " . $nilai_sepatu . ", preferensi: " . $preferensi_value . ", bobot: " . $bobot . ", $keterangan, kontribusi: " . round($kontribusi, 4);
            }

            $row['skor_wp'] = $skor_wp;
            $row['penjelasan_wp'] = $penjelasan;
            $results[] = $row;
        }

        // Urutkan berdasarkan skor WP tertinggi
        usort($results, function ($a, $b) {
            return $b['skor_wp'] <=> $a['skor_wp'];
        });

        // Hitung total skor WP
        $total_skor_wp = array_sum(array_column($results, 'skor_wp'));

        // Hitung persentase WP
        foreach ($results as &$sepatu) {
            $sepatu['persentase_wp'] = ($sepatu['skor_wp'] / $total_skor_wp) * 100;
        }
        unset($sepatu);
        $idakun = $_SESSION['akun']['idakun'];
        
        if (isset($idakun)) {

            
            foreach ($results as $sepatu) {
                $id_sepatu = $sepatu['id_sepatu'];
                $skor_wp = $sepatu['skor_wp'];
                $persentase_wp = $sepatu['persentase_wp'];
                $preferensi_json = json_encode($kriteria);
                $penjelasan_json = json_encode($sepatu['penjelasan_wp']);

                $stmt = $koneksi->prepare("INSERT INTO hasil_rekomendasi (id_user, id_sepatu, skor_wp, persentase_wp, preferensi_json, penjelasan_json) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiddss", $idakun, $id_sepatu, $skor_wp, $persentase_wp, $preferensi_json, $penjelasan_json);
                $stmt->execute();
            }
        }
    } else {
        $error_msg = "Tidak ada sepatu yang sesuai dengan preferensi Anda.";
    }
}
?>

<!-- HTML untuk form input preferensi -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Input Preferensi Pengguna</h3>
        <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-white">Input Preferensi</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid overflow-hidden py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-12 wow fadeInRight" data-wow-delay="0.3s">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-description mt-3">Masukkan Preferensi Anda</h3>
                        <form class="forms-sample" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="">Pilih Gender</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="olahraga">Jenis Olahraga</label>
                                <select class="form-control" name="olahraga" id="olahraga" required>
                                    <option value="">Pilih Jenis Olahraga</option>
                                    <option value="Lari">Lari</option>
                                    <option value="Tenis">Tenis</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Sepak Bola">Sepak Bola</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="warna">Warna</label>
                                <select class="form-control" name="warna" id="warna" required>
                                    <option value="">Pilih Warna</option>
                                    <?php while ($row = $warna_query->fetch_assoc()) : ?>
                                        <option value="<?= htmlspecialchars($row['warna']) ?>"><?= htmlspecialchars($row['warna']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kelenturan">Kelenturan</label>
                                <select class="form-control" name="kelenturan" id="kelenturan" required>
                                    <option value="">Pilih Kelenturan</option>
                                    <option value="Lentur">Lentur</option>
                                    <option value="Kaku">Kaku</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tebal_sol">Tebal Sol</label>
                                <select class="form-control" name="tebal_sol" id="tebal_sol" required>
                                    <option value="">Pilih Tebal Sol</option>
                                    <option value="Tipis">Tipis</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Tebal">Tebal</option>
                                </select>
                            </div>

                            <button type="submit" name="search" class="btn btn-info btn-block">Cari Sepatu Terbaik</button>
                        </form>
                    </div>
                </div>

                <!-- Tampilkan hasil -->
                <?php if (isset($results) && count($results) > 0) : ?>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4>Rekomendasi Sepatu Terbaik</h4>
                            <div class="row">
                                <?php foreach ($results as $sepatu) : ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="foto/<?= $sepatu['gambar'] ?>" class="card-img-top" alt="Gambar Sepatu">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $sepatu['nama_sepatu'] ?></h5>
                                                <p class="card-text">Jenis Olahraga: <?= $sepatu['jenis_olahraga'] ?></p>
                                                <p class="card-text">Warna: <?= $sepatu['warna'] ?></p>
                                                <p class="card-text">Kelenturan: <?= $sepatu['kelenturan'] ?></p>
                                                <p class="card-text">Tebal Sol: <?= $sepatu['tebal_sol'] ?></p>
                                                <p class="card-text"><strong>Skor WP:</strong> <?= round($sepatu['persentase_wp'], 2) ?>%</p>
                                                <p class="card-text"><strong>Penjelasan Skor WP:</strong></p>
                                                <ul>
                                                    <?php foreach ($sepatu['penjelasan_wp'] as $penj) : ?>
                                                        <li><?= htmlspecialchars($penj) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif (isset($error_msg)) : ?>
                    <div class="alert alert-danger mt-4"><?= $error_msg ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footerhome.php'; ?>