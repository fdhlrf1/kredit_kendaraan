<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_kredit'])) {
    $id_kredit = $_GET['id_kredit'];
    // var_dump($_GET);
    // die;

    try {
        //ambil hasil sebelumnya dari tproseskredit
        $query_hasil_lama = "SELECT pk.hasil, k.id_kendaraan
                         FROM tproseskredit pk
                         JOIN tkredit k ON k.id_kredit = pk.id_kredit
                         WHERE pk.id_kredit = '$id_kredit'";
        $result_hasil_lama = mysqli_query($conn, $query_hasil_lama);
        $data_hasil = mysqli_fetch_assoc($result_hasil_lama);
        $hasil_lama = $data_hasil['hasil'];
        $id_kendaraan = $data_hasil['id_kendaraan'];
        // var_dump($data_hasil);
        // die;

        if ($hasil_lama == 'disetujui') {
            $query_tambah_stok = "UPDATE tkendaraan SET stok = stok + 1 WHERE id_kendaraan = '$id_kendaraan'";
            mysqli_query($conn, $query_tambah_stok);
        }

        $query = "DELETE FROM tkredit WHERE id_kredit=$id_kredit";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['alertype_sukses_k'] = "success";
            $_SESSION['alertmessage_sukses_k'] = "Kredit berhasil dihapus!";
            header("Location: ../kredit.php");
            exit();
        } else {
            throw new Exception("Query gagal dijalankan: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $_SESSION['alertype_gagal_k'] = "danger";
        $_SESSION['alertmessage_gagal_k'] = "Gagal menghapus kredit! Error: " . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    die("akses dilarang...");
}