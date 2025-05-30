<?php

include '../../config/config.php';

$id_kredit = $_GET['id_kredit'] ?? '';
// var_dump($id_kredit);
// die;

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
    // var_dump($data_hasil);
    // die;

    if ($hasil_lama == 'disetujui') {
        $query_tambah_stok = "UPDATE tkendaraan SET stok = stok + 1 WHERE id_kendaraan = '$id_kendaraan'";
        mysqli_query($conn, $query_tambah_stok);
    }

    //UBAH STATUS JADI MENUNGGU
    $update_status_ke_menunggu = "UPDATE tkredit SET status = 'menunggu' WHERE id_kredit = '$id_kredit'";
    $result_update_status_ke_menunggu = mysqli_query($conn, $update_status_ke_menunggu);

    //HAPUS PROSES KREDIT
    $query_pk = "DELETE FROM tproseskredit WHERE id_kredit=$id_kredit";
    $result_pk = mysqli_query($conn, $query_pk);

    if ($result_update_status_ke_menunggu && $result_pk) {
        $_SESSION['alertype_sukses_k'] = 'success';
        $_SESSION['alertmessage_sukses_k'] = 'Status Kredit berhasil diubah menjadi Menunggu';
        header("Location: ../kredit.php");
        exit();
    } else {
        $_SESSION['alertype_sukses_k'] = 'danger';
        $_SESSION['alertmessage_gagal_k'] = 'Error: ' . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
