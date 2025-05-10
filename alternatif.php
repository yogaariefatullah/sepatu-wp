<?php include 'header.php'; ?>

<?php
// Fungsi untuk menghitung skor sepatu berdasarkan kriteria yang dipilih
function hitungSkor($kriteria, $sepatu)
{
    global $connection;
    $skor = 0;
    foreach ($kriteria as $kd_kriteria => $nilai) {
        // Ambil bobot dari model berdasarkan kriteria
        $query = $connection->query("SELECT bobot FROM model WHERE kd_kriteria = '$kd_kriteria' AND kd_sepatu = '$sepatu'");
        $row = $query->fetch_assoc();
        $bobot = $row['bobot'];

        // Hitung skor berdasarkan nilai kriteria yang dipilih
        $skor += $bobot * $nilai;
    }
    return $skor;
}

// Ambil daftar sepatu dari database
$querySepatu = $connection->query("SELECT * FROM sepatu");

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil kriteria yang dipilih oleh pengguna
    $kriteria = [
        1 => $_POST['jenis_olahraga'], // Kriteria Jenis Olahraga
        2 => $_POST['gender'],         // Kriteria Gender
        3 => $_POST['warna'],          // Kriteria Warna
        4 => $_POST['kelenturan'],     // Kriteria Kelenturan
        5 => $_POST['tebal_sol'],      // Kriteria Tebal Sol
        6 => $_POST['harga'],          // Kriteria Harga
    ];

    // Array untuk menyimpan skor sepatu
    $skorSepatu = [];

    // Hitung skor untuk setiap sepatu
    while ($rowSepatu = $querySepatu->fetch_assoc()) {
        $skor = hitungSkor($kriteria, $rowSepatu['kd_sepatu']);
        $skorSepatu[$rowSepatu['kd_sepatu']] = $skor;
    }

    // Urutkan sepatu berdasarkan skor tertinggi
    arsort($skorSepatu);
}
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>Pilih Sepatu Berdasarkan Kriteria</b></h2>

                            <!-- Form untuk memilih kriteria -->
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="jenis_olahraga">Jenis Olahraga</label>
                                    <select class="form-control" name="jenis_olahraga" required>
                                        <option value="1">Lari</option>
                                        <option value="0.8">Tenis</option>
                                        <option value="0.7">Volley</option>
                                        <option value="0.9">Basket</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" required>
                                        <option value="1">Pria</option>
                                        <option value="1">Wanita</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="warna">Warna</label>
                                    <select class="form-control" name="warna" required>
                                        <option value="1">Gelap</option>
                                        <option value="0.8">Terang</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kelenturan">Kelenturan</label>
                                    <select class="form-control" name="kelenturan" required>
                                        <option value="1">Lentur</option>
                                        <option value="0.6">Kaku</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tebal_sol">Tebal Sol</label>
                                    <select class="form-control" name="tebal_sol" required>
                                        <option value="1">Tebal</option>
                                        <option value="0.7">Tipis</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <select class="form-control" name="harga" required>
                                        <option value="1">Murah</option>
                                        <option value="0.8">Mahal</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Cari Sepatu</button>
                            </form>

                            <!-- Menampilkan sepatu yang sesuai dengan kriteria -->
                            <h3 class="mt-4">Alternatif Sepatu:</h3>
                            <?php if (isset($skorSepatu)) : ?>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Sepatu</th>
                                            <th>Skor</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($skorSepatu as $kd_sepatu => $skor) : ?>
                                            <?php
                                            // Ambil data sepatu berdasarkan kd_sepatu
                                            $querySepatuData = $connection->query("SELECT * FROM sepatu WHERE kd_sepatu = '$kd_sepatu'");
                                            $sepatuData = $querySepatuData->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $sepatuData['nama_sepatu'] ?></td>
                                                <td><?= $skor ?></td>
                                                <td><?= "Rp. " . number_format($sepatuData['harga'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>