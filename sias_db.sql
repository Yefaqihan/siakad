-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Apr 2026 pada 20.29
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
-- Database: `sias_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alfa') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`id`, `siswa_id`, `tanggal`, `status`, `keterangan`, `created_at`) VALUES
(1, 1, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(2, 2, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(3, 3, '2026-04-06', 'sakit', NULL, '2026-04-06 12:40:48'),
(4, 4, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(5, 5, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(6, 6, '2026-04-06', 'izin', NULL, '2026-04-06 12:40:48'),
(7, 7, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(8, 8, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48'),
(9, 9, '2026-04-06', 'alfa', NULL, '2026-04-06 12:40:48'),
(10, 10, '2026-04-06', 'hadir', NULL, '2026-04-06 12:40:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `nama_mapel`, `kode`, `created_at`) VALUES
(1, 'Matematika', 'MTK', '2026-04-06 12:40:48'),
(2, 'Bahasa Indonesia', 'BIN', '2026-04-06 12:40:48'),
(3, 'Bahasa Inggris', 'BIG', '2026-04-06 12:40:48'),
(4, 'Ilmu Pengetahuan Alam', 'IPA', '2026-04-06 12:40:48'),
(5, 'Ilmu Pengetahuan Sosial', 'IPS', '2026-04-06 12:40:48'),
(6, 'Pendidikan Agama', 'PAI', '2026-04-06 12:40:48'),
(7, 'Pendidikan Jasmani', 'PJK', '2026-04-06 12:40:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `guru_id` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `judul`, `deskripsi`, `file_path`, `guru_id`, `mapel_id`, `created_at`) VALUES
(1, 'Persamaan Linear Satu Variabel', 'Materi tentang penyelesaian persamaan linear satu variabel', NULL, 2, 1, '2026-04-06 12:40:48'),
(2, 'Struktur Teks Deskripsi', 'Materi tentang cara menyusun teks deskripsi yang baik', NULL, 2, 2, '2026-04-06 12:40:48'),
(3, 'Simple Present Tense', 'Materi tentang penggunaan simple present tense dalam kalimat', 'materi_69d3ba1db66ff.pdf', 3, 3, '2026-04-06 12:40:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `nilai_angka` decimal(5,2) NOT NULL,
  `semester` varchar(10) DEFAULT 'Ganjil',
  `tahun_ajaran` varchar(20) DEFAULT '2024/2025',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `siswa_id`, `mapel_id`, `nilai_angka`, `semester`, `tahun_ajaran`, `created_at`) VALUES
(1, 1, 1, 85.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(2, 1, 2, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(3, 1, 3, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(4, 1, 4, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(5, 1, 5, 75.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(6, 1, 6, 90.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(7, 1, 7, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(8, 2, 1, 92.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(9, 2, 2, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(10, 2, 3, 90.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(11, 2, 4, 85.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(12, 2, 5, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(13, 2, 6, 95.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(14, 2, 7, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(15, 3, 1, 70.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(16, 3, 2, 72.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(17, 3, 3, 68.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(18, 3, 4, 75.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(19, 3, 5, 70.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(20, 3, 6, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(21, 3, 7, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(22, 4, 1, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(23, 4, 2, 85.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(24, 4, 3, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(25, 4, 4, 90.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(26, 4, 5, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(27, 4, 6, 92.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(28, 4, 7, 85.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(29, 5, 1, 76.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(30, 5, 2, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(31, 5, 3, 74.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(32, 5, 4, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(33, 5, 5, 72.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(34, 5, 6, 85.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(35, 5, 7, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(36, 6, 1, 90.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(37, 6, 2, 92.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(38, 6, 3, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(39, 6, 4, 86.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(40, 6, 5, 84.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(41, 6, 6, 94.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(42, 6, 7, 90.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(43, 7, 1, 65.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(44, 7, 2, 70.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(45, 7, 3, 62.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(46, 7, 4, 68.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(47, 7, 5, 65.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(48, 7, 6, 75.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(49, 7, 7, 72.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(50, 8, 1, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(51, 8, 2, 86.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(52, 8, 3, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(53, 8, 4, 84.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(54, 8, 5, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(55, 8, 6, 88.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(56, 8, 7, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(57, 9, 1, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(58, 9, 2, 75.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(59, 9, 3, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(60, 9, 4, 72.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(61, 9, 5, 70.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(62, 9, 6, 82.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(63, 9, 7, 76.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(64, 10, 1, 74.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(65, 10, 2, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(66, 10, 3, 70.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(67, 10, 4, 76.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(68, 10, 5, 72.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(69, 10, 6, 80.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48'),
(70, 10, 7, 78.00, 'Ganjil', '2024/2025', '2026-04-06 12:40:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `semester` varchar(10) DEFAULT 'Ganjil',
  `tahun_ajaran` varchar(20) DEFAULT '2024/2025',
  `rata_rata` decimal(5,2) DEFAULT 0.00,
  `predikat` varchar(20) DEFAULT NULL,
  `status` enum('draft','verified') DEFAULT 'draft',
  `catatan` text DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rapor`
--

INSERT INTO `rapor` (`id`, `siswa_id`, `semester`, `tahun_ajaran`, `rata_rata`, `predikat`, `status`, `catatan`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 40, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(2, 39, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(3, 38, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(4, 37, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(5, 36, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(6, 35, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(7, 34, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(8, 33, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(9, 32, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(10, 31, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(11, 30, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(12, 29, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(13, 28, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(14, 27, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(15, 26, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(16, 25, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(17, 24, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(18, 23, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(19, 22, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(20, 21, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(21, 20, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(22, 19, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(23, 18, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(24, 17, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(25, 16, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(26, 15, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(27, 14, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(28, 13, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(29, 12, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(30, 11, 'Ganjil', '2024/2025', 0.00, 'E', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(31, 10, 'Ganjil', '2024/2025', 75.43, 'C', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(32, 9, 'Ganjil', '2024/2025', 76.14, 'C', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(33, 8, 'Ganjil', '2024/2025', 82.86, 'B', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(34, 7, 'Ganjil', '2024/2025', 68.14, 'D', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(35, 6, 'Ganjil', '2024/2025', 89.14, 'B', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(36, 5, 'Ganjil', '2024/2025', 78.14, 'C', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(37, 4, 'Ganjil', '2024/2025', 85.71, 'B', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(38, 3, 'Ganjil', '2024/2025', 73.29, 'C', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(39, 2, 'Ganjil', '2024/2025', 88.57, 'B', 'draft', NULL, NULL, NULL, '2026-04-06 14:07:05', '2026-04-06 14:07:05'),
(40, 1, 'Ganjil', '2024/2025', 82.57, 'B', 'verified', NULL, 4, '2026-04-06 09:07:54', '2026-04-06 14:07:05', '2026-04-06 14:07:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `kelas`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, 'Andi Pratama', '20240001', '7A', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(2, 'Bunga Lestari', '20240002', '7A', 'P', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(3, 'Cahyo Wibowo', '20240003', '7A', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(4, 'Dina Safitri', '20240004', '7A', 'P', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(5, 'Eka Putra', '20240005', '7B', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(6, 'Fitri Handayani', '20240006', '7B', 'P', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(7, 'Galih Ramadhan', '20240007', '7B', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(8, 'Hani Mulyani', '20240008', '8A', 'P', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(9, 'Irfan Maulana', '20240009', '8A', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(10, 'Joko Susilo', '20240010', '8A', 'L', '2026-04-06 12:40:48', '2026-04-06 12:40:48'),
(11, 'Lukman Hakim', '20240011', '7B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(12, 'Mega Putri', '20240012', '7B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(13, 'Kartika Sari', '20240013', '8A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(14, 'Dimas Prayoga', '20240014', '8A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(15, 'Lestari Dewi', '20240015', '8A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(16, 'Rizky Ramadhan', '20240016', '8A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(17, 'Nadia Putri', '20240017', '8B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(18, 'Bayu Pratama', '20240018', '8B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(19, 'Sari Indah', '20240019', '8B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(20, 'Arif Hidayat', '20240020', '8B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(21, 'Wulandari', '20240021', '8B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(22, 'Fajar Sidiq', '20240022', '8B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(23, 'Anisa Rahma', '20240023', '9A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(24, 'Budi Setiawan', '20240024', '9A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(25, 'Citra Lestari', '20240025', '9A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(26, 'Dedi Kurniawan', '20240026', '9A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(27, 'Elsa Maharani', '20240027', '9A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(28, 'Fandi Ahmad', '20240028', '9A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(29, 'Gita Nuraini', '20240029', '9A', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(30, 'Hasan Basri', '20240030', '9A', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(31, 'Indah Permata', '20240031', '9B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(32, 'Joni Iskandar', '20240032', '9B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(33, 'Kartini Wulandari', '20240033', '9B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(34, 'Luthfi Rahman', '20240034', '9B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(35, 'Mila Kusuma', '20240035', '9B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(36, 'Naufal Aziz', '20240036', '9B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(37, 'Olivia Putri', '20240037', '9B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(38, 'Panji Aditya', '20240038', '9B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(39, 'Qori Amalia', '20240039', '9B', 'P', '2026-04-06 14:01:57', '2026-04-06 14:01:57'),
(40, 'Reza Mahendra', '20240040', '9B', 'L', '2026-04-06 14:01:57', '2026-04-06 14:01:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','kepala_sekolah') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@sias.id', '$2y$10$FHv2.n20P7S7mtpOJaN1HuS2sz4X.NMuttMBnLHJ3PMMgMqrvQ1La', 'admin', '2026-04-06 12:40:48', '2026-04-06 13:42:41'),
(2, 'Sari Dewi, S.Pd', 'guru1@sias.id', '$2y$10$FHv2.n20P7S7mtpOJaN1HuS2sz4X.NMuttMBnLHJ3PMMgMqrvQ1La', 'guru', '2026-04-06 12:40:48', '2026-04-06 13:42:41'),
(3, 'Ahmad Fauzi, S.Pd', 'guru2@sias.id', '$2y$10$FHv2.n20P7S7mtpOJaN1HuS2sz4X.NMuttMBnLHJ3PMMgMqrvQ1La', 'guru', '2026-04-06 12:40:48', '2026-04-06 13:42:41'),
(4, 'Dr. Budi Santoso, M.Pd', 'kepsek@sias.id', '$2y$10$FHv2.n20P7S7mtpOJaN1HuS2sz4X.NMuttMBnLHJ3PMMgMqrvQ1La', 'kepala_sekolah', '2026-04-06 12:40:48', '2026-04-06 13:42:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_kehadiran` (`siswa_id`,`tanggal`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_nilai` (`siswa_id`,`mapel_id`,`semester`,`tahun_ajaran`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materi_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rapor`
--
ALTER TABLE `rapor`
  ADD CONSTRAINT `rapor_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rapor_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
