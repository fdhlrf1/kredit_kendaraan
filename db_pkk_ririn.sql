-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Bulan Mei 2025 pada 04.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pkk_ririn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tkendaraan`
--

CREATE TABLE `tkendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `tipe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tkendaraan`
--

INSERT INTO `tkendaraan` (`id_kendaraan`, `merk`, `model`, `tahun`, `harga`, `stok`, `tipe`) VALUES
(1, 'Honda', 'Beat', 2020, 12000000, 99, 'motor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tkredit`
--

CREATE TABLE `tkredit` (
  `id_kredit` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `jangka_waktu` int(11) NOT NULL,
  `bunga_persen` int(11) NOT NULL,
  `total_bunga` decimal(12,2) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `jumlah_cicilan` decimal(12,2) DEFAULT NULL,
  `status` enum('menunggu','sedang_berjalan','selesai','gagal') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tkredit`
--

INSERT INTO `tkredit` (`id_kredit`, `id_pelanggan`, `id_kendaraan`, `tanggal_pengajuan`, `jangka_waktu`, `bunga_persen`, `total_bunga`, `total_harga`, `jumlah_cicilan`, `status`) VALUES
(5, 1, 1, '2025-05-20', 6, 0, 0.00, 12000000.00, 2000000.00, 'sedang_berjalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tpelanggan`
--

CREATE TABLE `tpelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tpelanggan`
--

INSERT INTO `tpelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_telepon`, `email`, `tanggal_lahir`) VALUES
(1, 'Adi', 'Bandung', '0849328423', 'adi@mail.com', '2025-05-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tpembayaran`
--

CREATE TABLE `tpembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_kredit` int(11) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `jumlah_bayar` decimal(12,2) DEFAULT NULL,
  `sisa_cicilan` decimal(12,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tproseskredit`
--

CREATE TABLE `tproseskredit` (
  `id_proses` int(11) NOT NULL,
  `id_kredit` int(11) DEFAULT NULL,
  `id_staf` int(11) DEFAULT NULL,
  `tanggal_proses` date DEFAULT NULL,
  `hasil` enum('disetujui','ditolak') DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tproseskredit`
--

INSERT INTO `tproseskredit` (`id_proses`, `id_kredit`, `id_staf`, `tanggal_proses`, `hasil`, `keterangan`) VALUES
(6, 5, 1, '2025-05-20', 'disetujui', 'Kredit disetujui oleh Petugas STAF 1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tstaf`
--

CREATE TABLE `tstaf` (
  `id_staf` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tstaf`
--

INSERT INTO `tstaf` (`id_staf`, `id_user`, `nama`, `jabatan`, `no_telepon`, `email`) VALUES
(1, 2, 'staf1', 'Staff Layanan', '032439859349', 'user1@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tusers`
--

CREATE TABLE `tusers` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tusers`
--

INSERT INTO `tusers` (`id_user`, `username`, `password`, `nama`, `alamat`, `role`) VALUES
(1, 'admin', 'admin', 'Ririn', 'Gunung Batu', 'admin'),
(2, 'staf1', 'staf1', NULL, NULL, 'staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tkendaraan`
--
ALTER TABLE `tkendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indeks untuk tabel `tkredit`
--
ALTER TABLE `tkredit`
  ADD PRIMARY KEY (`id_kredit`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_kendaraan` (`id_kendaraan`);

--
-- Indeks untuk tabel `tpelanggan`
--
ALTER TABLE `tpelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `tpembayaran`
--
ALTER TABLE `tpembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `tpembayaran_ibfk_1` (`id_kredit`);

--
-- Indeks untuk tabel `tproseskredit`
--
ALTER TABLE `tproseskredit`
  ADD PRIMARY KEY (`id_proses`),
  ADD KEY `tproseskredit_ibfk_1` (`id_kredit`),
  ADD KEY `tproseskredit_ibfk_2` (`id_staf`);

--
-- Indeks untuk tabel `tstaf`
--
ALTER TABLE `tstaf`
  ADD PRIMARY KEY (`id_staf`),
  ADD KEY `fk_staf_user` (`id_user`);

--
-- Indeks untuk tabel `tusers`
--
ALTER TABLE `tusers`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tkendaraan`
--
ALTER TABLE `tkendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tkredit`
--
ALTER TABLE `tkredit`
  MODIFY `id_kredit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tpelanggan`
--
ALTER TABLE `tpelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tpembayaran`
--
ALTER TABLE `tpembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tproseskredit`
--
ALTER TABLE `tproseskredit`
  MODIFY `id_proses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tstaf`
--
ALTER TABLE `tstaf`
  MODIFY `id_staf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tusers`
--
ALTER TABLE `tusers`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tkredit`
--
ALTER TABLE `tkredit`
  ADD CONSTRAINT `tkredit_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tpelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tkredit_ibfk_2` FOREIGN KEY (`id_kendaraan`) REFERENCES `tkendaraan` (`id_kendaraan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tpembayaran`
--
ALTER TABLE `tpembayaran`
  ADD CONSTRAINT `tpembayaran_ibfk_1` FOREIGN KEY (`id_kredit`) REFERENCES `tkredit` (`id_kredit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tproseskredit`
--
ALTER TABLE `tproseskredit`
  ADD CONSTRAINT `tproseskredit_ibfk_1` FOREIGN KEY (`id_kredit`) REFERENCES `tkredit` (`id_kredit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tproseskredit_ibfk_2` FOREIGN KEY (`id_staf`) REFERENCES `tstaf` (`id_staf`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tstaf`
--
ALTER TABLE `tstaf`
  ADD CONSTRAINT `fk_staf_user` FOREIGN KEY (`id_user`) REFERENCES `tusers` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
