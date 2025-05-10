<?php include 'header.php'; ?>
<br>
<br>
<?php
$tahun = date('Y');
$idjenis = 1;
$sqlKriteria = "";
$namaKriteria = [];
$queryKriteria = $connection->query("SELECT a.kd_kriteria, a.nama FROM kriteria a JOIN model b USING(kd_kriteria) WHERE b.kd_jenis=$idjenis");
while ($kr = $queryKriteria->fetch_assoc()) {
    $sqlKriteria .= "SUM(
				IF(
					c.kd_kriteria=" . $kr["kd_kriteria"] . ",
					IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization/nilai.nilai), 0
				)
			) AS " . strtolower(str_replace(" ", "_", $kr["nama"])) . ",";
    $namaKriteria[] = strtolower(str_replace(" ", "_", $kr["nama"]));
}
$sql = "SELECT
			(SELECT nama FROM akun WHERE nik=pgwai.nik) AS nama,
			(SELECT nik FROM akun WHERE nik=pgwai.nik) AS nik,
			$sqlKriteria
			SUM(
				IF(
						c.sifat = 'max',
						nilai.nilai / c.normalization,
						c.normalization / nilai.nilai
				) * c.bobot
			) AS rangking
		FROM
			nilai
			JOIN akun pgwai USING(nik)
			JOIN (
				SELECT
						nilai.kd_kriteria AS kd_kriteria,
						kriteria.sifat AS sifat,
						(
							SELECT bobot FROM model WHERE kd_kriteria=kriteria.kd_kriteria AND kd_jenis=jenis.kd_jenis
						) AS bobot,
						ROUND(
							IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1
						) AS normalization
					FROM nilai
					JOIN kriteria USING(kd_kriteria)
					JOIN jenis ON kriteria.kd_jenis=jenis.kd_jenis
					WHERE jenis.kd_jenis=$idjenis
				GROUP BY nilai.kd_kriteria
			) c USING(kd_kriteria)
		WHERE kd_jenis=$idjenis
		GROUP BY nilai.nik
		ORDER BY rangking DESC"; ?>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row mb-3">
                <div class="col-md-12">
              
                    <div class="card">
                        <div class="card-body">
                        <h2 class="text-dark mb-4 text-center"><b>Hasil Penilaian Peserta Dengan WP</b></h2>

                            <div class="table-responsive">
                                <table class="table table-condensed table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <?php $query = $connection->query("SELECT nama FROM kriteria WHERE kd_jenis=1");
                                            while ($row = $query->fetch_assoc()) :
                                            ?>
                                                <th><?= $row["nama"]
                                                    ?></th>
                                            <?php endwhile
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query = $connection->query($sql) or die(mysqli_error($connection));
                                        $no = 1;
                                        while ($row = $query->fetch_assoc()) : ?>
                                            <?php
                                            $rangking = number_format((float) $row["rangking"], 8, '.', '');
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row["nik"] ?></td>
                                                <td><?= $row["nama"] ?></td>
                                                <?php for ($i = 0; $i < count($namaKriteria); $i++) : ?>
                                                    <th><?= round(number_format((float) $row[$namaKriteria[$i]], 8, '.', ''), 2); ?></th>
                                                <?php endfor ?>
                                            </tr>
                                        <?php
                                            $no++;
                                        endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover text-center">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Rangking</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query = $connection->query($sql) or die(mysqli_error($connection));
                                        $no = 1;
                                        while ($row = $query->fetch_assoc()) : ?>
                                            <?php
                                            $rangking = number_format((float) $row["rangking"], 8, '.', '');
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row["nik"] ?></td>
                                                <td><?= $row["nama"] ?></td>
                                                <td><?= round($rangking, 2) ?></td>
                                            </tr>
                                        <?php
                                            $no++;
                                        endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $query = $connection->query($sql) or die(mysqli_error($connection));
            $no = 1;
            $dataset = [];
            while ($row = $query->fetch_assoc()) :
                $rangking = number_format((float) $row["rangking"], 8, '.', '');
                $dataset[] = array("y" => intval($rangking), 'label' => $row["nama"]);
                $no++;
            endwhile;
            ?>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <script>
                window.onload = function() {
                    var chart = new CanvasJS.Chart("grafik", {
                        animationEnabled: true,
                        exportEnabled: false,
                        theme: "light1",
                        title: {
                            text: "Grafik Hasil Penilaian Peserta Dengan WP"
                        },
                        axisY: {
                            minimum: 0
                        },
                        data: [{
                            type: "column",
                            indexLabelFontColor: "#5A5757",
                            indexLabelPlacement: "outside",
                            dataPoints: <?php echo json_encode($dataset); ?>
                        }]
                    });
                    chart.render();
                }
            </script>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="grafik" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>