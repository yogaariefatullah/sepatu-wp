<?php include 'header.php'; ?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <!-- Form untuk memilih user -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4 text-center"><b>Pilih User untuk Menampilkan Hasil Ranking Sepatu</b></h2>
                            <form method="GET" action="">
                                <div class="form-group">
                                    <label for="nik">Pilih User (NIK atau Nama)</label>
                                    <select name="nik" id="nik" class="form-control">
                                        <option value="">Pilih User</option>
                                        <?php
                                        // Ambil data user untuk dipilih
                                        $resultUser = $connection->query("SELECT nik, nama FROM akun WHERE role !='Admin'");
                                        while ($row = $resultUser->fetch_assoc()) {
                                            $selected = isset($_GET['nik']) && $_GET['nik'] == $row['nik'] ? 'selected' : '';
                                            echo "<option value='{$row['nik']}' $selected>{$row['nik']} - {$row['nama']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Tampilkan Ranking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['nik']) && !empty($_GET['nik'])): ?>
                <?php
                // Ambil data berdasarkan NIK yang dipilih
                $nik = $connection->real_escape_string($_GET['nik']);

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

                // Ambil data sepatu (nama dan gambar)
                $resultSepatu = $connection->query("SELECT id_sepatu, nama_sepatu, gambar FROM sepatu");
                $sepatuData = [];
                while ($row = $resultSepatu->fetch_assoc()) {
                    $sepatuData[$row['id_sepatu']] = [
                        'nama_sepatu' => $row['nama_sepatu'],
                        'gambar' => $row['gambar']
                    ];
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
                    $score = 0;
                    foreach ($kriteriaNormalized as $kd_kriteria => $normalizedValue) {
                        $score += $normalizedValue * $bobotData[$id_sepatu][$kd_kriteria];
                    }
                    $scores[$id_sepatu] = $score;
                }

                // Urutkan sepatu berdasarkan skor
                arsort($scores);
                ?>
                <!-- Tabel Hasil Ranking -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="text-dark mb-4">Hasil Ranking Sepatu</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Sepatu</th>
                                    <th>Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rank = 1; ?>
                                <?php foreach ($scores as $id_sepatu => $score): ?>
                                    <tr>
                                        <td><?php echo $rank++; ?></td>
                                        <td>
                                            <img src="foto/<?php echo $sepatuData[$id_sepatu]['gambar']; ?>" alt="<?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>" width="50">
                                            <?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>
                                        </td>
                                        <td><?php echo number_format($score, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Matriks Bobot dan Nilai -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="text-dark mb-4">Matriks Bobot dan Nilai Kriteria</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sepatu</th>
                                    <?php foreach ($kriteriaNames as $kd_kriteria => $nama_kriteria): ?>
                                        <th><?php echo $nama_kriteria; ?></th>
                                    <?php endforeach; ?>
                                    <th>Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bobotData as $id_sepatu => $kriteriaData): ?>
                                    <tr>
                                        <td>
                                            <img src="foto/<?php echo $sepatuData[$id_sepatu]['gambar']; ?>" alt="<?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>" width="50">
                                            <?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>
                                        </td>
                                        <?php foreach ($kriteriaData as $kd_kriteria => $bobot): ?>
                                            <td><?php echo $bobot; ?></td>
                                        <?php endforeach; ?>
                                        <td><?php echo array_sum($kriteriaData); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Normalisasi -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="text-dark mb-4">Matriks Normalisasi</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sepatu</th>
                                    <?php foreach ($kriteriaNames as $kd_kriteria => $nama_kriteria): ?>
                                        <th><?php echo $nama_kriteria; ?></th>
                                    <?php endforeach; ?>
                                    <th>Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($normalizedData as $id_sepatu => $normalizedValues): ?>
                                    <tr>
                                        <td>
                                            <img src="foto/<?php echo $sepatuData[$id_sepatu]['gambar']; ?>" alt="<?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>" width="50">
                                            <?php echo $sepatuData[$id_sepatu]['nama_sepatu']; ?>
                                        </td>
                                        <?php foreach ($normalizedValues as $kd_kriteria => $normalizedValue): ?>
                                            <td><?php echo number_format($normalizedValue, 2); ?></td>
                                        <?php endforeach; ?>
                                        <td><?php echo number_format($scores[$id_sepatu], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>