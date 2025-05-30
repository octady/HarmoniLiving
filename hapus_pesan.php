<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang bisa menghapus pesan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil ID pesan dari POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Hapus pesan dari database
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Berhasil hapus, redirect kembali ke halaman admin
        header("Location: admin.php?pesan_terhapus=true");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus pesan. Coba lagi nanti.'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Pesan tidak ditemukan.'); window.history.back();</script>";
}

$conn->close();
?>
