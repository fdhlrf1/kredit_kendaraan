<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_kredit'])) {
    $id_kredit = $_GET['id_kredit'];
    // var_dump($_GET);
    // die;

    //ambil status lama di tabel kredit
    $query_status_lama = "SELECT id_kendaraan, status FROM tkredit WHERE id_kredit = '$id_kredit'";
    $result_status_lama = mysqli_query($conn, $query_status_lama);
    $data_status = mysqli_fetch_assoc($result_status_lama);
    $status_lama = $data_status['status'];
    $id_kendaraan = $data_status['id_kendaraan'];

    //kalau status nya sudah selesai tolak penghapusan
    if ($status_lama == 'selesai') {
        $_SESSION['alertype_gagal_pk'] = "warning";
        $_SESSION['alertmessage_gagal_pk'] = "Kredit yang sudah selesai tidak dapat dihapus Proses nya.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    //ambil hasil sebelumnya dari tproseskredit
    $query_hasil_lama = "SELECT hasil FROM tproseskredit WHERE id_kredit = '$id_kredit'";
    $result_hasil_lama = mysqli_query($conn, $query_hasil_lama);
    $data_hasil = mysqli_fetch_assoc($result_hasil_lama);
    $hasil_lama = $data_hasil['hasil'];

    if ($hasil_lama == 'disetujui') {
        $query_tambah_stok = "UPDATE tkendaraan SET stok = stok + 1 WHERE id_kendaraan = '$id_kendaraan'";
        mysqli_query($conn, $query_tambah_stok);
    }

    $query_pk = "DELETE FROM tproseskredit WHERE id_kredit=$id_kredit";
    $result_pk = mysqli_query($conn, $query_pk);

    if ($result_pk) {
        $query_k = "UPDATE tkredit SET status='menunggu' WHERE id_kredit=$id_kredit";
        $result_k = mysqli_query($conn, $query_k);

        if ($result_k) {
            $_SESSION['alertype_sukses_pk'] = "success";
            $_SESSION['alertmessage_sukses_pk'] = "Proses Kredit berhasil dihapus!";
            header("Location: ../proses-kredit.php");
            exit();
        } else {
            $_SESSION['alertype_gagal_pk'] = "danger";
            $_SESSION['alertmessage_gagal_pk'] = "Gagal menghapus proses kredit!";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    }
} else {
    die("akses dilarang...");
}
