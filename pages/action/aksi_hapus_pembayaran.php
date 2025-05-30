<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_pembayaran'])) {
    $id_pembayaran = $_GET['id_pembayaran'];
    // var_dump($_GET);
    // die;

    // Ambil data pembayaran yang akan dihapus
    $query_pembayaran = "SELECT * FROM tpembayaran WHERE id_pembayaran = $id_pembayaran";
    $result_pembayaran = mysqli_query($conn, $query_pembayaran);
    $pembayaran = mysqli_fetch_assoc($result_pembayaran);

    $id_kredit = $pembayaran['id_kredit'];

    $query_hapus = "DELETE FROM tpembayaran WHERE id_pembayaran=$id_pembayaran";
    $result_hapus = mysqli_query($conn, $query_hapus);

    // AND id_pembayaran != '$id_pembayaran'
    if ($result_hapus) {

        //ambil total harga/total kredit
        $query_kredit = "SELECT total_harga FROM tkredit WHERE id_kredit='$id_kredit'";
        $result_kredit = mysqli_query($conn, $query_kredit);
        $kredit = mysqli_fetch_assoc($result_kredit);
        $total_kredit = $kredit['total_harga'];


        //ambil semua pembayaran dari awal, urutkan berdasarkan tanggal dan id
        //untuk menghitung ulang sisa_cicilan setiap ada perubahan
        $query_all_pembayaran = "SELECT * FROM tpembayaran 
                             WHERE id_kredit = '$id_kredit' 
                             ORDER BY tanggal_pembayaran ASC, id_pembayaran ASC";
        $result_all_pembayaran = mysqli_query($conn, $query_all_pembayaran);

        $sisa = $total_kredit; //awalnya total kredit
        while ($row = mysqli_fetch_assoc($result_all_pembayaran)) {
            $id_p = $row['id_pembayaran'];
            $jumlah = round((float)$row['jumlah_bayar'], 2);
            $sisa -= $jumlah;
            if ($sisa < 0) $sisa = 0;

            // Update sisa_cicilan berdasarkan urutan terbaru
            $update_sisa = "UPDATE tpembayaran SET sisa_cicilan = '$sisa' WHERE id_pembayaran = '$id_p'";
            mysqli_query($conn, $update_sisa);
        }

        //ambil jumlah bayar
        $query_bayar = "SELECT SUM(jumlah_bayar) AS jumlah_bayar 
                                FROM tpembayaran 
                                WHERE id_kredit = '$id_kredit'
                                ";
        $result_bayar = mysqli_query($conn, $query_bayar);
        $pembayaran = mysqli_fetch_assoc($result_bayar);
        $jumlah_bayar = $pembayaran['jumlah_bayar'] ?? 0;

        // var_dump($jumlah_bayar);
        // die;

        // $jumlah_bayar_terbaru = $jumlah_bayar_sebelumnya + $jumlah_bayar;

        //menentukan status baru
        if ($jumlah_bayar < $total_kredit) {
            $status = "sedang_berjalan";
        } else {
            $status = "selesai";
        }

        // var_dump($status);
        // die;

        //update status di tkredit
        $query_update_status = "UPDATE tkredit SET status = '$status' WHERE id_kredit = '$id_kredit'";
        mysqli_query($conn, $query_update_status);

        $_SESSION['alertype_sukses_pn'] = "success";
        $_SESSION['alertmessage_sukses_pn'] = "Pembayaran berhasil dihapus!";
        header("Location: ../detail_riwayat-pembayaran.php?id_kredit=$id_kredit");
        exit();
    } else {
        $_SESSION['alertype_gagal_pn'] = "danger";
        $_SESSION['alertmessage_gagal_pn'] = "Gagal menghapus pembayaran!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    die("akses dilarang...");
}
