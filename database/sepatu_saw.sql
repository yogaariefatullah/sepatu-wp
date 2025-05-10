-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2024 pada 09.22
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sepatusaw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `idakun` int(11) NOT NULL,
  `nama` text NOT NULL,
  `nik` varchar(25) NOT NULL,
  `jeniskelamin` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `nohp` varchar(255) NOT NULL,
  `pekerjaan` text NOT NULL,
  `alamat` text NOT NULL,
  `role` text NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`idakun`, `nama`, `nik`, `jeniskelamin`, `email`, `nohp`, `pekerjaan`, `alamat`, `role`, `password`, `foto`) VALUES
(2, 'Administrator', '123', 'Laki - Laki', 'admin@gmail.com', '08988387271', 'Kepala Sekolah', '-', 'Admin', 'admin', ''),
(30, 'Sugeng', 'A1', 'Laki - Laki', 'sugeng@gmail.com', '085912592', 'Programmer', 'Jl. Palembang', 'Peserta', 'sugeng', ''),
(31, 'Alex', 'A2', 'Laki - Laki', 'alex@gmail.com', '085981295821', 'Staff', 'Jl. Palembang', 'Peserta', 'alex', ''),
(35, 'Husen', 'A4', 'Laki - Laki', 'husen@gmail.com', '0858215912', 'Staff', 'Jl. Palembang', 'Peserta', 'husen', ''),
(39, 'Vidha', '99', 'Perempuan', 'vidha@gmail.com', '08951829521', 'Guru Biologi', 'Jl. Palembang', 'Peserta', 'vidha', ''),
(40, 'Agnes', '666', 'Laki - Laki', 'agnes@gmail.com', '085912512612', '-', 'Jl. Palembang', 'Peserta', 'agnes', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `id_bobotkriteria` int(3) NOT NULL,
  `id_sepatu` int(3) NOT NULL,
  `kd_kriteria` int(3) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id_bobotkriteria`, `id_sepatu`, `kd_kriteria`, `bobot`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 4),
(3, 1, 3, 3),
(4, 1, 4, 4),
(5, 1, 5, 4),
(6, 1, 6, 2),
(7, 2, 1, 4),
(8, 2, 2, 4),
(9, 2, 3, 2),
(10, 2, 4, 3),
(11, 2, 5, 3),
(12, 2, 6, 3),
(13, 3, 1, 2),
(14, 3, 2, 4),
(15, 3, 3, 1),
(16, 3, 4, 4),
(17, 3, 5, 3),
(18, 3, 6, 2),
(19, 4, 1, 1),
(20, 4, 2, 3),
(21, 4, 3, 2),
(22, 4, 4, 3),
(23, 4, 5, 2),
(24, 4, 6, 3),
(25, 5, 1, 3),
(26, 5, 2, 4),
(27, 5, 3, 3),
(28, 5, 4, 4),
(29, 5, 5, 4),
(30, 5, 6, 2),
(31, 6, 1, 3),
(32, 6, 2, 3),
(33, 6, 3, 3),
(34, 6, 4, 3),
(35, 6, 5, 3),
(36, 6, 6, 3),
(37, 7, 1, 3),
(38, 7, 2, 3),
(39, 7, 3, 2),
(40, 7, 4, 3),
(41, 7, 5, 4),
(42, 7, 6, 2),
(43, 8, 1, 3),
(44, 8, 2, 4),
(45, 8, 3, 1),
(46, 8, 4, 3),
(47, 8, 5, 3),
(48, 8, 6, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `kd_jenis` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`kd_jenis`, `nama`) VALUES
(1, 'Penilaian Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `kd_kriteria` int(11) NOT NULL,
  `kd_jenis` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `tipe` varchar(25) NOT NULL,
  `sifat` enum('min','max') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`kd_kriteria`, `kd_jenis`, `nama`, `tipe`, `sifat`) VALUES
(1, 1, 'Jenis Olahraga', 'Jenis Olahraga', 'max'),
(2, 1, 'Gender', 'Gender Sepatu', 'max'),
(3, 1, 'Warna', 'Warna Sepatu', 'max'),
(4, 1, 'Kelenturan', 'Kelenturan Sepatu', 'max'),
(5, 1, 'Tebal Sol', 'Ketebalan Sol Sepatu', 'max'),
(6, 1, 'Harga', 'Harga Sepatu', 'min');

-- --------------------------------------------------------

--
-- Struktur dari tabel `model`
--

CREATE TABLE `model` (
  `kd_model` int(11) NOT NULL,
  `kd_jenis` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `bobot` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `model`
--

INSERT INTO `model` (`kd_model`, `kd_jenis`, `kd_kriteria`, `bobot`) VALUES
(1, 1, 1, 5),
(2, 1, 2, 4),
(3, 1, 3, 3),
(4, 1, 4, 4),
(5, 1, 5, 2),
(6, 1, 6, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `kd_nilai` int(11) NOT NULL,
  `kd_jenis` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nik` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`kd_nilai`, `kd_jenis`, `kd_kriteria`, `nik`, `nilai`) VALUES
(25, 1, 1, 'A2', 0.5),
(26, 1, 2, 'A2', 1),
(27, 1, 3, 'A2', 0.75),
(28, 1, 4, 'A2', 0.5),
(29, 1, 5, 'A2', 1),
(30, 1, 6, 'A2', 0.5),
(31, 1, 1, 'A1', 2),
(32, 1, 2, 'A1', 3),
(33, 1, 3, 'A1', 3),
(34, 1, 4, 'A1', 2),
(35, 1, 5, 'A1', 3),
(36, 1, 6, 'A1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_kriteria`
--

CREATE TABLE `nilai_kriteria` (
  `kd_nilaikriteria` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai_kriteria`
--

INSERT INTO `nilai_kriteria` (`kd_nilaikriteria`, `kd_kriteria`, `nilai`, `keterangan`) VALUES
(1, 1, 4, 'Lari'),
(2, 1, 3, 'Tenis'),
(3, 1, 2, 'Volley'),
(4, 1, 1, 'Basketball'),
(5, 2, 4, 'Pria'),
(6, 2, 3, 'Wanita'),
(7, 3, 4, 'Gelap'),
(8, 3, 3, 'Terang'),
(9, 4, 4, 'Lentur'),
(10, 4, 2, 'Kaku'),
(11, 5, 4, 'Tebal'),
(12, 5, 3, 'Tipis'),
(13, 6, 1, '< 1,500,000'),
(14, 6, 2, '1,500,000 - 2,000,000'),
(15, 6, 3, '2,000,000 - 2,500,000'),
(16, 6, 4, '> 2,500,000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `kd_penilaian` int(11) NOT NULL,
  `kd_jenis` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `bobot` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`kd_penilaian`, `kd_jenis`, `kd_kriteria`, `keterangan`, `bobot`) VALUES
(2, 1, 1, 'Basket', 4),
(3, 1, 1, 'Lari', 3),
(4, 1, 1, 'Tenis', 2),
(5, 1, 2, 'Pria', 5),
(6, 1, 2, 'Wanita', 4),
(7, 1, 3, 'Gelap', 5),
(8, 1, 3, 'Terang', 4),
(9, 1, 4, 'Lentur', 5),
(10, 1, 4, 'Kaku', 3),
(11, 1, 5, 'Tebal', 5),
(12, 1, 5, 'Tipis', 3),
(13, 1, 6, 'Sangat Murah', 5),
(14, 1, 6, 'Murah', 4),
(15, 1, 6, 'Sedang', 3),
(16, 1, 6, 'Mahal', 2),
(17, 1, 6, 'Sangat Mahal', 1),
(19, 1, 1, 'Volley', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_sepatu`
--

CREATE TABLE `penilaian_sepatu` (
  `kd_penilaian` int(11) NOT NULL,
  `id_sepatu` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilaian_sepatu`
--

INSERT INTO `penilaian_sepatu` (`kd_penilaian`, `id_sepatu`, `kd_kriteria`, `keterangan`, `bobot`) VALUES
(1, 1, 1, 'Lari', 5),
(2, 1, 2, 'Pria', 4),
(3, 1, 3, 'Gelap', 3),
(4, 1, 4, 'Lentur', 4),
(5, 1, 5, 'Tebal', 2),
(6, 1, 6, '1500000', 5),
(7, 2, 1, 'Lari', 5),
(8, 2, 2, 'Wanita', 4),
(9, 2, 3, 'Terang', 3),
(10, 2, 4, 'Lentur', 4),
(11, 2, 5, 'Tebal', 2),
(12, 2, 6, '1800000', 5),
(13, 3, 1, 'Basket', 5),
(14, 3, 2, 'Pria', 4),
(15, 3, 3, 'Gelap', 3),
(16, 3, 4, 'Kaku', 4),
(17, 3, 5, 'Tipis', 2),
(18, 3, 6, '1400000', 5),
(19, 4, 1, 'Tenis', 5),
(20, 4, 2, 'Wanita', 4),
(21, 4, 3, 'Terang', 3),
(22, 4, 4, 'Lentur', 4),
(23, 4, 5, 'Tebal', 2),
(24, 4, 6, '1700000', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sepatu`
--

CREATE TABLE `sepatu` (
  `id_sepatu` int(11) NOT NULL,
  `nama_sepatu` varchar(100) NOT NULL,
  `jenis_olahraga` enum('Lari','Tenis','Volley','Basket') NOT NULL,
  `merk` varchar(50) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `warna` enum('Gelap','Terang') NOT NULL,
  `kelenturan` enum('Kaku','Lentur') NOT NULL,
  `tebal_sol` enum('Tipis','Tebal') NOT NULL,
  `harga` float NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sepatu`
--

INSERT INTO `sepatu` (`id_sepatu`, `nama_sepatu`, `jenis_olahraga`, `merk`, `gender`, `warna`, `kelenturan`, `tebal_sol`, `harga`, `gambar`) VALUES
(1, 'Nike Air Zoom', 'Lari', 'Nike', 'Pria', 'Gelap', 'Lentur', 'Tebal', 1500000, 'nike_zoom.jpg'),
(2, 'Adidas Ultraboost', 'Lari', 'Adidas', 'Wanita', 'Terang', 'Lentur', 'Tebal', 1800000, 'adidas_ultra.jpg'),
(3, 'Puma Ignite', 'Basket', 'Puma', 'Pria', 'Gelap', 'Kaku', 'Tipis', 1400000, 'puma_ignite.jpg'),
(4, 'Asics Gel', 'Tenis', 'Asics', 'Wanita', 'Terang', 'Lentur', 'Tebal', 1700000, 'asics_gel.jpg'),
(5, 'Reebok Nano X', 'Lari', '', 'Pria', 'Gelap', 'Kaku', 'Tipis', 0, 'reebok_nano_x.jpg'),
(6, 'Under Armour HOVR', 'Lari', '', 'Pria', 'Gelap', 'Kaku', 'Tipis', 0, 'under_armour_hovr.jpg'),
(7, 'New Balance 1080', 'Lari', '', 'Pria', 'Gelap', 'Kaku', 'Tipis', 0, 'new_balance_1080.jpg'),
(8, 'Mizuno Wave Rider', 'Lari', '', 'Pria', 'Gelap', 'Kaku', 'Tipis', 0, 'mizuno_wave_rider.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`idakun`),
  ADD KEY `nip` (`nik`);

--
-- Indeks untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`id_bobotkriteria`),
  ADD KEY `id_jenisbarang` (`id_sepatu`),
  ADD KEY `id_kriteria` (`kd_kriteria`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kd_kriteria`),
  ADD KEY `kd_beasiswa` (`kd_jenis`),
  ADD KEY `kd_beasiswa_2` (`kd_jenis`);

--
-- Indeks untuk tabel `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`kd_model`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_jenis`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`kd_nilai`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_jenis`),
  ADD KEY `nip` (`nik`);

--
-- Indeks untuk tabel `nilai_kriteria`
--
ALTER TABLE `nilai_kriteria`
  ADD PRIMARY KEY (`kd_nilaikriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`kd_penilaian`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_jenis`);

--
-- Indeks untuk tabel `penilaian_sepatu`
--
ALTER TABLE `penilaian_sepatu`
  ADD PRIMARY KEY (`kd_penilaian`);

--
-- Indeks untuk tabel `sepatu`
--
ALTER TABLE `sepatu`
  ADD PRIMARY KEY (`id_sepatu`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `idakun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  MODIFY `id_bobotkriteria` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `kd_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kd_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `model`
--
ALTER TABLE `model`
  MODIFY `kd_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `kd_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `nilai_kriteria`
--
ALTER TABLE `nilai_kriteria`
  MODIFY `kd_nilaikriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `kd_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `penilaian_sepatu`
--
ALTER TABLE `penilaian_sepatu`
  MODIFY `kd_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `sepatu`
--
ALTER TABLE `sepatu`
  MODIFY `id_sepatu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `fk_beasiswa` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `model_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`nik`) REFERENCES `akun` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
