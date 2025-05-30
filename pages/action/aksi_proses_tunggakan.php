<?php

include '../../config/config.php';
session_start();

$id_kredit = $_GET['id_kredit'] ?? '';

if ($id_kredit) {
    //ambil hasil sebelumnya dari tproseskredit
    $query_hasil_lama = "SELECT pk.hasil, k.id_kendaraan
                         FROM tproseskredit pk
                         JOIN tkredit k ON k.id_kredit = pk.id_kredit
                         WHERE pk.id_kredit = '$id_kredit'";
    $result_hasil_lama = mysqli_query($conn, $query_hasil_lama);
    $data_hasil = mysqli_fetch_assoc($result_hasil_lama);
    $hasil_lama = $data_hasil['hasil'];
    $id_kendaraan = $data_hasil['id_kendaraan'];

    if ($hasil_lama == 'disetujui') {
        $query_tambah_stok = "UPDATE tkendaraan SET stok = stok + 1 WHERE id_kendaraan = '$id_kendaraan'";
        mysqli_query($conn, $query_tambah_stok);
    }

    //UBAH STATUS DAN HASIL JADI GAGAL DAN DITOLAK
    $update_status_ke_gagal = "UPDATE tkredit SET status = 'gagal' WHERE id_kredit = '$id_kredit'";
    $result_update_status_ke_gagal = mysqli_query($conn, $update_status_ke_gagal);

    $update_status_ke_ditolak = "UPDATE tproseskredit SET hasil = 'ditolak' WHERE id_kredit = '$id_kredit'";
    $result_update_status_ke_ditolak = mysqli_query($conn, $update_status_ke_ditolak);

    if ($result_update_status_ke_gagal && $result_update_status_ke_ditolak) {
        $_SESSION['alertype_sukses_tg'] = 'success';
        $_SESSION['alertmessage_sukses_tg'] = 'Status Kredit berhasil diubah menjadi GAGAL dan DITOLAK!';
        header("Location: ../tunggakan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_tg'] = 'danger';
        $_SESSION['alertmessage_gagal_tg'] = 'Error: ' . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
