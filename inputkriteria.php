<?php
include 'headerhome.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan session sudah dimulai

// Ambil pilihan warna dari database
$warna_query = $koneksi->query("SELECT DISTINCT warna FROM sepatu ORDER BY warna ASC");
$harga_query = $koneksi->query("SELECT DISTINCT harga FROM sepatu ORDER BY harga ASC");
$harga_list = [];
while ($row = $harga_query->fetch_assoc()) {
    $harga_list[] = $row['harga'];
}
// Proses saat form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $gender = $_POST["gender"];
    $olahraga = $_POST["olahraga"];
    $warna = $_POST["warna"];
    $kelenturan = $_POST["kelenturan"];
    $tebal_sol = $_POST["tebal_sol"];
    $harga_min = $_POST["harga_min"];
    $harga_max = $_POST["harga_max"];

    // Filter sepatu berdasarkan preferensi
    // Konversi harga ke float
    $harga_min_new = floatval($harga_min);
    $harga_max_new = floatval($harga_max);

    // Escape string untuk keamanan
    $gender = $koneksi->real_escape_string($gender);
    $olahraga = $koneksi->real_escape_string($olahraga);
    $warna = $koneksi->real_escape_string($warna);
    $kelenturan = $koneksi->real_escape_string($kelenturan);
    $tebal_sol = $koneksi->real_escape_string($tebal_sol);

    // Susun query
    $sql = "
        SELECT * FROM sepatu 
        WHERE gender = '$gender' 
        AND jenis_olahraga LIKE '%$olahraga%' 
        AND warna LIKE '%$warna%' 
        AND kelenturan LIKE '%$kelenturan%' 
        AND tebal_sol LIKE '%$tebal_sol%' 
        AND harga BETWEEN $harga_min_new AND $harga_max_new
    ";

    // Eksekusi query
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $results = [];

        // Ambil semua bobot dan tipe kriteria
        $kriteria_result = $koneksi->query("SELECT * FROM kriteria");
        $kriteria_data = [];
        $total_bobot = 0;

        while ($kr = $kriteria_result->fetch_assoc()) {
            $kriteria_data[$kr['kd_kriteria']] = [
                'bobot' => 1, // default jika tidak ada bobot disimpan
                'sifat' => $kr['sifat']
            ];
            $total_bobot += 1;
        }

        // Normalisasi bobot
        foreach ($kriteria_data as $kd => &$val) {
            $val['bobot'] = $val['bobot'] / $total_bobot;
        }

        // Loop setiap sepatu untuk hitung skor WP
        while ($row = $result->fetch_assoc()) {
            $id_sepatu = $row['id_sepatu'];
            $skor_wp = 1;
            $penjelasan = [];

            // Ambil nilai untuk setiap sepatu
            $nilai_query = $koneksi->prepare("SELECT * FROM nilai_wp WHERE id_sepatu = ?");
            $nilai_query->bind_param("i", $id_sepatu);
            $nilai_query->execute();
            $nilai_result = $nilai_query->get_result();

            $nilai_kriteria = [];
            while ($n = $nilai_result->fetch_assoc()) {
                $nilai_kriteria[$n['kd_kriteria']] = $n['nilai'];
            }

            // Hitung kontribusi harga pada skor WP
            $nilai_harga = $row['harga'];
            $harga_bobot = 1; // Misalnya bobotnya 1, bisa disesuaikan
            $sifat_harga = 'min'; // Jika harga lebih rendah lebih baik
            $bobot_terapan_harga = ($sifat_harga == 'min') ? -$harga_bobot : $harga_bobot;
            $kontribusi_harga = pow($nilai_harga, $bobot_terapan_harga);
            $skor_wp *= $kontribusi_harga;

            $penjelasan[] = "Harga: Nilai = $nilai_harga, Bobot = $harga_bobot, Sifat = $sifat_harga, Kontribusi Harga = " . round($kontribusi_harga, 4);

            // Hitung kontribusi setiap kriteria lainnya
            foreach ($kriteria_data as $kd_kriteria => $kriteria_info) {
                $nilai = isset($nilai_kriteria[$kd_kriteria]) ? $nilai_kriteria[$kd_kriteria] : 1;
                $bobot = $kriteria_info['bobot'];
                $sifat = $kriteria_info['sifat'];

                // Penyesuaian min/max
                $bobot_terapan = ($sifat == 'min') ? -$bobot : $bobot;
                $kontribusi = pow($nilai, $bobot_terapan);
                $skor_wp *= $kontribusi;

                $penjelasan[] = "Kriteria $kd_kriteria: Nilai = $nilai, Bobot = $bobot, Sifat = $sifat, Kontribusi = " . round($kontribusi, 4);
            }

            $row['skor_wp'] = $skor_wp;
            $row['penjelasan_wp'] = $penjelasan;
            $results[] = $row;
        }

        // Normalisasi skor WP menjadi persentase
        usort($results, function ($a, $b) {
            return $b['skor_wp'] <=> $a['skor_wp'];
        });
        $total_skor = array_sum(array_column($results, 'skor_wp'));

        foreach ($results as &$sepatu) {
            $sepatu['persentase_wp'] = ($sepatu['skor_wp'] / $total_skor) * 100;
        }

        // Simpan jika user login
        if (isset($_SESSION['akun']['idakun'])) {
            $idakun = intval($_SESSION['akun']['idakun']); // pastikan id_user berupa integer

            foreach ($results as $sepatu) {
                $id_sepatu = intval($sepatu['id_sepatu']); // pastikan id_sepatu juga integer
                $skor_wp = floatval($sepatu['skor_wp']);
                $persentase_wp = floatval($sepatu['persentase_wp']);
                $pref = $koneksi->real_escape_string(json_encode($_POST));
                $penj = $koneksi->real_escape_string(json_encode($sepatu['penjelasan_wp']));

                $sql = "
                    INSERT INTO hasil_rekomendasi 
                    (id_user, id_sepatu, skor_wp, persentase_wp, preferensi_json, penjelasan_json) 
                    VALUES 
                    ($idakun, $id_sepatu, $skor_wp, $persentase_wp, '$pref', '$penj')
                ";

                $koneksi->query($sql);
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
                                    <option value="Running">Running</option>
                                    <option value="Tennis dan Padel">Tenis</option>
                                    <option value="Fitness">Basket</option>
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
                                    <option value="Tebal">Tebal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_min">Harga Min</label>
                                <select class="form-control" name="harga_min" id="harga_min" required>
                                    <option value="">Pilih Harga Minimum</option>
                                    <?php foreach ($harga_list as $harga) : ?>
                                        <option value="<?= $harga ?>" <?= (isset($_POST['harga_min']) && $_POST['harga_min'] == $harga) ? 'selected' : '' ?>>
                                            Rp <?= number_format($harga, 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="harga_max">Harga Max</label>
                                <select class="form-control" name="harga_max" id="harga_max" required>
                                    <option value="">Pilih Harga Maksimum</option>
                                    <?php foreach ($harga_list as $harga) : ?>
                                        <option value="<?= $harga ?>" <?= (isset($_POST['harga_max']) && $_POST['harga_max'] == $harga) ? 'selected' : '' ?>>
                                            Rp <?= number_format($harga, 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary" name="search">Cari Sepatu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Display results -->
<?php if (isset($results)) : ?>
    <div class="container mt-5">
        <h3>Hasil Rekomendasi Sepatu</h3>
        <div class="row">
            <?php foreach ($results as $sepatu) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="foto/<?= htmlspecialchars($sepatu['gambar']) ?>" class="card-img-top" alt="Gambar Sepatu">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($sepatu['nama_sepatu']) ?></h5>
                            <p class="card-text">Persentase WP: <?= round($sepatu['persentase_wp'], 2) ?>%</p>

                            <?php if (!empty($penjelasan)) : ?>
                                <div class="mt-2">
                                    <strong>Penjelasan:</strong>
                                    <ul class="mb-0">
                                        <?php foreach ($penjelasan as $key => $value) : ?>
                                            <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                        <?php endforeach; ?>

                                        <?php if (isset($sepatu['persentase_wp'])) : ?>
                                            <?php
                                                            $persentase = round($sepatu['persentase_wp'], 2);

                                                            // Cek jika skor WP adalah 100%
                                                            if ($persentase == 100.00) : ?>
                                                <li class="text-success"><strong>Kesimpulan:</strong> Semua kriteria cocok 100%, sehingga sepatu ini sangat sesuai dengan preferensi Anda.</li>
                                            <?php
                                                            // Jika persentase WP lebih dari 80%, tetapi kurang dari 100%
                                                            elseif ($persentase >= 80) : ?>
                                                <li class="text-warning"><strong>Kesimpulan:</strong> Sebagian besar kriteria cocok dengan preferensi Anda (<?= $persentase ?>%). Sepatu ini sangat layak dipertimbangkan.</li>
                                            <?php
                                                            // Jika persentase WP lebih dari 50%, tetapi kurang dari 80%
                                                            elseif ($persentase >= 50) : ?>
                                                <li class="text-info"><strong>Kesimpulan:</strong> Beberapa kriteria cocok (<?= $persentase ?>%). Sepatu ini cukup sesuai dengan preferensi Anda, tetapi masih ada beberapa yang perlu dipertimbangkan.</li>
                                            <?php
                                                            // Jika persentase WP kurang dari 50%
                                                            else : ?>
                                                <li class="text-danger"><strong>Kesimpulan:</strong> Sebagian besar kriteria tidak cocok (<?= $persentase ?>%). Sepatu ini kurang sesuai dengan preferensi Anda.</li>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>


<?php
include 'footerhome.php';
?>