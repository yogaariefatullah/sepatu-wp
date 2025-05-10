<?php include 'header.php'; ?>

<?php
$update = (isset($_GET['action']) && $_GET['action'] == 'update') ? true : false;
if ($update) {
    $sql = $connection->query("SELECT * FROM sepatu WHERE id_sepatu='$_GET[key]'");
    $row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validasi = false;
    $err = false;

    // Handle file upload for gambar (image)
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $namafoto = $_FILES['gambar']['name'];
        $lokasifoto = $_FILES['gambar']['tmp_name'];
        $gambar = $namafoto;

        if (!move_uploaded_file($lokasifoto, $gambar)) {
            echo alert("Gagal upload gambar!", "?page=sepatu");
            exit;
        }
    } elseif (!$update) {
        echo alert("Gambar wajib diunggah!", "?page=sepatu");
        exit;
    } else {
        $gambar = $row['gambar'];
    }

    if ($update) {
        // Update data sepatu
        $sql = "UPDATE sepatu SET 
                    nama_sepatu='$_POST[nama_sepatu]', 
                    jenis_olahraga='$_POST[jenis_olahraga]',  
                    gender='$_POST[gender]', 
                    warna='$_POST[warna]', 
                    kelenturan='$_POST[kelenturan]', 
                    tebal_sol='$_POST[tebal_sol]', 
                    harga='$_POST[harga]', 
                    gambar='$gambar' 
                WHERE id_sepatu='$_GET[key]'";
    } else {
        // Insert data sepatu
        $sql = "INSERT INTO sepatu (nama_sepatu,jenis_olahraga, gender, warna, kelenturan, tebal_sol, harga, gambar) 
                VALUES ('$_POST[nama_sepatu]','$_POST[jenis_olahraga]', '$_POST[gender]', '$_POST[warna]', '$_POST[kelenturan]', '$_POST[tebal_sol]', '$_POST[harga]', '$gambar')";
        $validasi = true;
    }

    if ($validasi) {
        // Periksa jika sepatu sudah ada berdasarkan kriteria
        $q = $connection->query("SELECT id_sepatu FROM sepatu WHERE jenis_olahraga='$_POST[jenis_olahraga]' AND warna='$_POST[warna]' AND kelenturan='$_POST[kelenturan]' AND tebal_sol='$_POST[tebal_sol]'");
        if ($q->num_rows) {
            echo alert("Sepatu sudah ada!", "?page=sepatu");
            $err = true;
        }
    }

    // Menjalankan query dan memberikan pesan sukses atau gagal
    if (!$err && $connection->query($sql)) {
        echo alert("Berhasil!", "?page=sepatu");
    } else {
        echo alert("Gagal!", "?page=sepatu");
    }
}

// Hapus sepatu jika ada permintaan
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $connection->query("DELETE FROM sepatu WHERE id_sepatu='$_GET[key]'");
    echo alert("Berhasil dihapus!", "?page=sepatu");
}
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-description mt-3"><?= ($update) ? "Edit Sepatu" : "Tambah Sepatu" ?></h3>
                            <form class="forms-sample" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
                                <!-- Form input untuk Sepatu -->
                                <div class="form-group">
                                    <label for="nama_sepatu">Nama Sepatu</label>
                                    <input type="text" name="nama_sepatu" class="form-control" value="<?= $update ? $row['nama_sepatu'] : '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_olahraga">Jenis Olahraga</label>
                                    <select class="form-control" name="jenis_olahraga" required>
                                        <option value="">--Pilih Jenis Olahraga--</option>
                                        <option value="Running" <?= ($update && $row['jenis_olahraga'] == 'Running') ? 'selected' : '' ?>>Running</option>
                                        <option value="Tennis dan Padel" <?= ($update && $row['jenis_olahraga'] == 'Tennis dan Padel') ? 'selected' : '' ?>>Tennis dan Padel</option>
                                        <option value="Fitness" <?= ($update && $row['jenis_olahraga'] == 'Fitness') ? 'selected' : '' ?>>Fitness</option>
                                    </select>
                                </div>
                         

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" required>
                                        <option value="Pria" <?= ($update && $row['gender'] == 'Pria') ? 'selected' : '' ?>>Pria</option>
                                        <option value="Wanita" <?= ($update && $row['gender'] == 'Wanita') ? 'selected' : '' ?>>Wanita</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="warna">Warna</label>
                                    <input type="text" name="warna" class="form-control" value="<?= $update ? $row['warna'] : '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="kelenturan">Kelenturan</label>
                                    <select class="form-control" name="kelenturan" required>
                                        <option value="Kaku" <?= ($update && $row['kelenturan'] == 'Kaku') ? 'selected' : '' ?>>Kaku</option>
                                        <option value="Lentur" <?= ($update && $row['kelenturan'] == 'Lentur') ? 'selected' : '' ?>>Lentur</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tebal_sol">Tebal Sol</label>
                                    <select class="form-control" name="tebal_sol" required>
                                        <option value="Tebal" <?= ($update && $row['tebal_sol'] == 'Tebal') ? 'selected' : '' ?>>Tebal</option>
                                        <option value="Tipis" <?= ($update && $row['tebal_sol'] == 'Tipis') ? 'selected' : '' ?>>Tipis</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga" class="form-control" value="<?= $update ? $row['harga'] : '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" name="gambar" class="form-control">
                                    <?= $update && $row['gambar'] ? "<img src='foto/" . $row['gambar'] . "' width='100' height='auto'>" : '' ?>
                                </div>

                                <button type="submit" class="btn btn-primary me-2 float-end"><?= ($update) ? "Update" : "Tambah" ?></button>
                                <?php if ($update) : ?>
                                    <a href="?page=sepatu" class="btn btn-light">Batal</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-dark mb-4"><b>Daftar Sepatu</b></h2>
                            <table class="table table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sepatu</th>
                                        <th>Jenis Olahraga</th>
                                        <th>Harga</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php
                                    $query = $connection->query("SELECT * FROM sepatu");
                                    while ($row = $query->fetch_assoc()) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_sepatu'] ?></td>
                                            <td><?= $row['jenis_olahraga'] ?></td>
                                            <td><?= $row['harga'] ?></td>
                                            <td>
                                                <?php if ($row['gambar']) : ?>
                                                    <img src="foto/<?= $row['gambar'] ?>" width="100" height="auto">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="?page=sepatu&action=update&key=<?= $row['id_sepatu'] ?>" class="btn btn-warning m-1">Edit</a>
                                                    <a href="?page=sepatu&action=delete&key=<?= $row['id_sepatu'] ?>" class="btn btn-danger m-1">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>