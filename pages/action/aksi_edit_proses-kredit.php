<?php

include '../../config/config.php';
session_start();

$pesan = '';
$sukses = false;

//Proses form ketika disubmit
if (isset($_POST['submit'])) {
    // var_dump($_POST['hasil']);
    // die;
    $id_kredit = $_POST['id_kredit'];
    //ambil data dari form
    $hasil = $_POST['hasil'];
    $keterangan = $_POST['keterangan'];

    //ambil status lama di tabel kredit
    $query_status_lama = "SELECT id_kendaraan, status FROM tkredit WHERE id_kredit = '$id_kredit'";
    $result_status_lama = mysqli_query($conn, $query_status_lama);
    $data_status = mysqli_fetch_assoc($result_status_lama);
    $status_lama = $data_status['status'];
    $id_kendaraan = $data_status['id_kendaraan'];

    //ambil hasil sebelumnya dari tproseskredit
    $query_hasil_lama = "SELECT hasil FROM tproseskredit WHERE id_kredit = '$id_kredit'";
    $result_hasil_lama = mysqli_query($conn, $query_hasil_lama);
    $data_hasil = mysqli_fetch_assoc($result_hasil_lama);
    $hasil_lama = $data_hasil['hasil'];

    //cek stok
    $query_stok = "SELECT stok FROM tkendaraan WHERE id_kendaraan = '$id_kendaraan'";
    $result_stok = mysqli_query($conn, $query_stok);
    $stok = mysqli_fetch_assoc($result_stok);

    if ($stok['stok'] <= 0) {
        $_SESSION['alertype_gagal_pk'] = 'danger';
        $_SESSION['alertmessage_gagal_pk'] = 'Stok kendaraan habis. Tidak bisa disetujui.';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $query = "UPDATE tproseskredit SET 
    hasil='$hasil',
    keterangan='$keterangan'
    WHERE id_kredit = $id_kredit";
    $query_result = mysqli_query($conn, $query);

    if ($query_result) {
        if ($hasil_lama != 'disetujui' && $hasil == 'disetujui') {
            //kurangi stok
            $query_update_stok = "UPDATE tkendaraan SET stok = stok - 1 WHERE id_kendaraan = '$id_kendaraan'";
            mysqli_query($conn, $query_update_stok);
        } else if ($hasil_lama == 'disetujui' && $hasil != 'disetujui') {
            //kembalikan stok
            $query_update_stok = "UPDATE tkendaraan SET stok = stok + 1 WHERE id_kendaraan = '$id_kendaraan'";
            mysqli_query($conn, $query_update_stok);
        }

        //menentukan hasil
        if ($hasil == 'disetujui') {
            if ($status_lama != 'selesai') {
                $status = 'sedang_berjalan';
            } else {
                $status = 'selesai';
            }
        } else {
            $status = 'gagal';
        }

        $query_kredit = "UPDATE tkredit SET status='$status' WHERE id_kredit='$id_kredit'";
        $result_kredit = mysqli_query($conn, $query_kredit);

        if ($result_kredit) {
            $_SESSION['alertype_sukses_pk'] = 'success';
            $_SESSION['alertmessage_sukses_pk'] = 'Proses kredit berhasil diedit!';
            header("Location: ../proses-kredit.php");
            exit();
        } else {
            $_SESSION['alertype_gagal_pk'] = 'danger';
            $_SESSION['alertmessage_gagal_pk'] = 'Error: ' . mysqli_error($koneksi);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    } else {
        $_SESSION['alertype_gagal_pk'] = 'danger';
        $_SESSION['alertmessage_gagal_pk'] = 'Error saat update proses kredit: ' . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
